<?php

namespace api\controllers;

use api\models\LoginForm;
use common\models\TypeEmployer;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        //cors errors
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['*']
            ],
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