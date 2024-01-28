<?php

namespace api\controllers;

use api\models\LoginForm;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $model =new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '') && ($token = $model->login()) ){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['access_token' => $token];
        }else{
            return "To'g'ri jo'nat krisa";
        }
    }
}