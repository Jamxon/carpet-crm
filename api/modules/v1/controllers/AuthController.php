<?php

namespace api\modules\v1\controllers;

use api\models\Customer;
use api\modules\v1\models\Login;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $model = new Login();
        if ($model->load(\Yii::$app->request->post(), '') && ($token = $model->login()) ){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $token;
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //return error 401
            return \Yii::$app->response->statusCode = 401;
        }
    }

    public function actionRegister()
    {
        $model = new Customer();
        $model->name = \Yii::$app->request->post('name');
        $model->phone_1 = \Yii::$app->request->post('phone_1');
        $model->phone_2 = \Yii::$app->request->post('phone_2');
        $model->password = \Yii::$app->request->post('password');
        $model->address = \Yii::$app->request->post('address');
        $model->date = \Yii::$app->request->post('date');
        $model->source = \Yii::$app->request->post('source');
        $model->level = "Narx";
        $model->comment = "";
        if ($model->save()){
            return ['status' => 'success', 'message' => 'Register success'];
        } else {
            return $model->getErrors();
        }
    }
}