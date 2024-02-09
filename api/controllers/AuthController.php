<?php

namespace api\controllers;

use api\models\LoginForm;
use common\models\TypeEmployer;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
//            'cors' => [
//                // Tarmoqdan kelgan so'rovni qo'llab-quvvatlaydigan yoki rad etadigan domenlar
//                'Origin' => ['*'],
//                // Faqat kerakli metodlarni qo'llab-quvvatlash
//                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
//                // Quyidagi xususiyatlarni qo'llab-quvvatlash
//                'Access-Control-Allow-Credentials' => true,
//                'Access-Control-Max-Age' => 3600,                 // 1 soat ichida qayta so'rovni bajarishga ruxsat beriladi
//                'Access-Control-Allow-Headers' => ['Content-Type', 'X-Requested-With'],
//                'Access-Control-Allow-Origin' => ['*'],
//            ],
        ];

        return $behaviors;
    }
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
            //return error 401
            return \Yii::$app->response->statusCode = 401;
        }
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'message' => 'Logout success'
        ];
    }

}