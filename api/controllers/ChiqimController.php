<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class ChiqimController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'except' => ['options']
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Chiqim::find(),
        ]);
    }

    public function actionView($id)
    {
        return \common\models\Chiqim::findOne($id);
    }

    public function actionCreate()
    {
        $model = new \common\models\Chiqim();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model;
    }

    public function actionUpdate($id)
    {
        $model = \common\models\Chiqim::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model;
    }

    public function actionDelete($id)
    {
        return \common\models\Chiqim::deleteAll(['id' => $id]);
    }

    public function actionSearch()
    {
        $model = new \common\models\Chiqim();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        return new ActiveDataProvider([
            'query' => $model->search(),
        ]);
    }


}