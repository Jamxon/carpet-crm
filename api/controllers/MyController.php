<?php

namespace api\controllers;

use api\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class MyController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
//            'auth' => function ($username, $password) {
//                $user = User::find()->where(['username' => $username])->one();
//                if ($user && $user->validatePassword($password)){
//                    return $user;
//                }else{
//                    return null;
//                }
//            }
        ];
        return $behaviors;
    }
}