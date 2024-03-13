<?php

namespace api\modules\v1\controllers;

use common\models\Customer;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class MainController extends Controller
{
    public function behaviors()
    {
        return  [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            //json
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Customer::find(),
        ]);
    }
}