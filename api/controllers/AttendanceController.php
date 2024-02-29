<?php

namespace api\controllers;


use api\models\Attendance;
use yii\data\ActiveDataProvider;

class AttendanceController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options', 'index', 'date'];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }


    public function actionIndex()
    {
        return \api\models\Attendance::find()->all();
    }

    public function actionDate()
    {
        //Get the start date and end date from the request where in params

        $startDate = \Yii::$app->request->get('start_date');
        $endDate = \Yii::$app->request->get('end_date');

//        $startDate = \Yii::$app->request->post('start_date');
//        $endDate = \Yii::$app->request->post('end_date');

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


}