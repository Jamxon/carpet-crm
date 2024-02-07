<?php

namespace api\controllers;

use api\models\LoginForm;
use common\models\TypeEmployer;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $model =new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '') && ($token = $model->login()) ){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $type = TypeEmployer::find()->where(['id' => $token['type_id']])->one();
            return [
                'access_token' => $token['access_token'],
                'type' => $type->name
            ];
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error'
            ];
        }
    }
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
//                'cors' => [
//                    'Access-Control-Allow-Origin' => ['*'],
//                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD'],
//                    'Access-Control-Request-Headers' => ['*'],
//                ],
            ],
        ];
    }
}