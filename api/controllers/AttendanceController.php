<?php

namespace api\controllers;

use api\models\Attendance;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class AttendanceController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
        //date funtion is not working returned cors error
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        //cors error
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
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
            'query' => Attendance::find()->select("id, user_id, come_time, go_time, full_time, daily_salary, comment"),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionDate($start_date, $end_date): ActiveDataProvider
    {
        if ($start_date == '' && $end_date == ''){
            return new ActiveDataProvider([
                'query' => Attendance::find(),
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]);
        } elseif ($start_date == '' && $end_date != ''){
            return new ActiveDataProvider([
                'query' => Attendance::find()->where(['<=', 'go_time', $end_date]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        } elseif ($start_date != '' && $end_date == ''){
            return new ActiveDataProvider([
                'query' => Attendance::find()->where(['>=', 'come_time', $start_date]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        } else {
            return new ActiveDataProvider([
                'query' => Attendance::find()->where(['>=', 'come_time', $start_date])
                    ->andWhere(['<=', 'go_time', $end_date]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }
    }

    public function actionView($id, $start_date, $end_date)
    {
        $model = Attendance::find()->where(['id' => $id])
            ->andWhere(['>=', 'come_time', $start_date])
            ->andWhere(['<=', 'go_time', $end_date]);
        if ($model) {
            return $model;
        } else {
            return "not found";
        }
    }


    public function actionFind($id)
    {
        $model = Attendance::findOne($id);
        if ($model) {
            return $model;
        } else {
            return "not found";
        }
    }
    public function actionFindbyuserid($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find()->where(['user_id' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $dataProvider;
    }
    public function actionCreate($user_id, $come_time, $go_time, $full_time, $daily_salary, $comment)
    {
        $model = new Attendance();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $model->user_id = $user_id;
        $model->come_time = $come_time;
        $model->go_time = $go_time;
        $model->full_time = $full_time;
        $model->daily_salary = $daily_salary;
        $model->comment = $comment;
        if ($model->save()) {
            return $model;
        } else {
            return array_values($model->getFirstErrors())[0];
        }
    }
    public function actionUpdate($id, $user_id, $come_time, $go_time, $full_time, $daily_salary, $comment)
    {
        $model = Attendance::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $model->user_id = $user_id;
        $model->come_time = $come_time;
        $model->go_time = $go_time;
        $model->full_time = $full_time;
        $model->daily_salary = $daily_salary;
        $model->comment = $comment;
        if ($model->save()) {
            return $model;
        } else {
            return array_values($model->getFirstErrors())[0];
        }
    }
    public function actionDelete($id)
    {
        $model = Attendance::findOne($id);
        $model->delete();
        return "delete success";
    }

}