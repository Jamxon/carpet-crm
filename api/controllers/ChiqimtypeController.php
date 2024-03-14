<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class ChiqimtypeController extends Controller
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
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => \common\models\Chiqimtype::find(),
        ]);
    }

    public function actionCreate()
    {
        $model = new \common\models\Chiqimtype();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->post('id')) {
            $model = \common\models\Chiqimtype::findOne(\Yii::$app->request->post('id'));
            $model->load(\Yii::$app->request->post(), '');
            if ($model->save()) {
                return $model;
            }
            return $model->getErrors();
        }
        return 'id is required';
    }

    public function actionView($id): ?\common\models\Chiqimtype
    {
        return \common\models\Chiqimtype::findOne($id);
    }
    public function actionDelete($id): int
    {
        return \common\models\Chiqimtype::deleteAll(['id' => $id]);
    }
}