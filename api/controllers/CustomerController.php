<?php

namespace api\controllers;

use common\models\Customer;
use yii\data\ActiveDataProvider;
use yii\validators\DateValidator;
use yii\web\Response;

class CustomerController extends MyController
{
    public function behaviors() {
        return [
            'formats' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    public function actionOptions(){
        $header = \Yii::$app->response->headers;
        $header->add('Access-Control-Allow-Origin', '*');
        $header->add('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $header->add('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
    public function actionSearchbyphone($phone)
    {
        return new ActiveDataProvider([
            'query' => Customer::find()
                ->where(['LIKE', 'phone_1', $phone])
                ->orWhere(['LIKE', 'phone_2', $phone]),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionCreate($employer_id, $name, $phone_1, $phone_2, $address, $date, $source, $level, $comment)
    {
        $model = new \common\models\Customer();
        $model->employer_id = $employer_id;
        $model->name = $name;
        $model->phone_1 = $phone_1;
        $model->phone_2 = $phone_2;
        $model->address = $address;
        $model->date = $date;
        $model->source = $source;
        $model->level = $level;
        $model->comment = $comment;
        $model->save();
        return $model;
    }
    public function actionUpdate($id, $employer_id, $name, $phone_1, $phone_2, $address, $date, $source, $level, $comment)
    {
        $model = \common\models\Customer::findOne($id);
        $model->employer_id = $employer_id;
        $model->name = $name;
        $model->phone_1 = $phone_1;
        $model->phone_2 = $phone_2;
        $model->address = $address;
        $model->date = $date;
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