<?php

namespace api\controllers;

use api\models\Attendance;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;

class AttendanceController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find(),
        ]);

        return $dataProvider;
    }

    public function actionCreate()
    {
        $model = new Attendance();
        $model->load(\Yii::$app->request->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->errors;
    }
}