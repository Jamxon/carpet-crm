<?php

namespace api\controllers;

use api\models\Attendance;
use yii\data\ActiveDataProvider;

class AttendanceController extends MyController
{
    public function actionIndex($start_date, $end_date)
    {
        return new ActiveDataProvider([
            'query' => Attendance::find()->where(['>=', 'come_time', $start_date])
                ->andWhere(['<=', 'go_time', $end_date]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
    public function actionView($id, $start_date, $end_date)
    {
        $model = Attendance::find()->where(['id' => $id])
            ->andWhere(['>=', 'come_time', $start_date])
            ->andWhere(['<=', 'go_time', $end_date])->one();
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

    public function findByDateRange($start_date, $end_date)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find()->where(['between', 'date', $start_date, $end_date]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $dataProvider;
    }
}