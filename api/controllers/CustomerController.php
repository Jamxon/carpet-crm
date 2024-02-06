<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class CustomerController extends MyController
{
    public function actionSearchbyphone($phone)
    {
        return new ActiveDataProvider([
            'sql' => "SELECT * FROM customer WHERE phone_1 LIKE '%$phone%' OR phone_2 LIKE '%$phone%'",
        ]);
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find(),
        ]);
    }
    public function actionCreate($employer_id, $name, $phone_1, $phone_2, $address, $source, $level, $comment)
    {
        $model = new \common\models\Customer();
        $model->employer_id = $employer_id;
        $model->name = $name;
        $model->phone_1 = $phone_1;
        $model->phone_2 = $phone_2;
        $model->address = $address;
        $model->source = $source;
        $model->level = $level;
        $model->comment = $comment;
        $model->save();
        return $model;
    }
    public function actionUpdate($id, $employer_id, $name, $phone_1, $phone_2, $address, $source, $level, $comment)
    {
        $model = \common\models\Customer::findOne($id);
        $model->employer_id = $employer_id;
        $model->name = $name;
        $model->phone_1 = $phone_1;
        $model->phone_2 = $phone_2;
        $model->address = $address;
        $model->source = $source;
        $model->level = $level;
        $model->comment = $comment;
        $model->save();
        return $model;
    }
    public function actionDelete($id)
    {
        $model = \common\models\Customer::findOne($id);
        $model->delete();
        return $model;
    }
    public function actionView($id)
    {
        return \common\models\Customer::findOne($id);
    }
}