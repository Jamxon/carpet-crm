<?php

namespace api\controllers;

use api\models\AccessToken;
use api\models\LoginForm;
use common\models\TypeEmployer;
use yii\rest\Controller;

class AuthController extends MyController
{
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
                'except' => ['login', 'logout'],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'login' => ['POST'],
                    'logout' => ['POST'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
//                'cors' => [
//                    // restrict access to
//                    'Origin' => ['*'],
//                    // Allow only POST and PUT methods
//                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
//                    // Allow only headers 'X-Wsse'
//                    'Access-Control-Request-Headers' => ['*'],
//                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
//                    'Access-Control-Allow-Credentials' => true,
//                    // Allow OPTIONS caching
//                    'Access-Control-Max-Age' => 3600,
//                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
//                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
//                ],

            ],
        ];
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
    public function logout()
    {
        $accessToken = AccessToken::find()->where(['access_token' => \Yii::$app->request->headers['Authorization']])->one();
        $accessToken->delete();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'message' => 'Logout success'
        ];
    }

}