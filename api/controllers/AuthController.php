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
        $behaviors['authenticator'] = [
            'except' => ['login'],
            'class' => \yii\filters\auth\HttpBearerAuth::class,

             'corsFilter' => [
                'class' => \yii\filters\Cors::class,
               'cors' => [
                   'Origin' => ['*'],
                  'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                 'Access-Control-Request-Headers' => ['*'],
             ],
             ],
             'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::class,
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