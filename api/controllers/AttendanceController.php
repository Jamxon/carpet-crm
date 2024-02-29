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
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }

    public function actionOptions()
    {
        $header = \Yii::$app->response->getHeaders();
        $header->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
        return $header;
    }
    public function actionIndex()
    {
        $startDate = \Yii::$app->request->params['start_date'];
        $endDate = \Yii::$app->request->params['end_date'];

        $query = Attendance::find();

        if (!empty($startDate)) {
            $query->andWhere(['>=', 'come_time', $startDate]);
        }

        if (!empty($endDate)) {
            $query->andWhere(['<=', 'go_time', $endDate]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
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