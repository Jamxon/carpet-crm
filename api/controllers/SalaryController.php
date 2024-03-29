<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class SalaryController extends Controller
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
            'query' => \common\models\Salary::find(),
        ]);
    }

    public function actionView($id)
    {
        return \common\models\Salary::findOne($id);
    }

    public function actionCreate()
    {
        $model = new \common\models\Salary();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionUpdate($id)
    {
        $model = \common\models\Salary::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionDelete($id)
    {
        return \common\models\Salary::findOne($id)->delete();
    }
}