<?php

namespace api\controllers;

use Yii;
use yii\filters\Cors;

class CorsBehavior extends Cors
{
    public function beforeAction($action): bool
    {
        parent::beforeAction($action);
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT OPTIONS');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', "*");
            Yii::$app->end();
        }
        return true;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // Tarmoqdan kelgan so'rovni qo'llab-quvvatlaydigan yoki rad etadigan domenlar
                'Origin' => ['*'],
                // Faqat kerakli metodlarni qo'llab-quvvatlash
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                // Quyidagi xususiyatlarni qo'llab-quvvatlash
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,                 // 1 soat ichida qayta so'rovni bajarishga ruxsat beriladi
                'Access-Control-Allow-Headers' => ['Content-Type', 'X-Requested-With'],
                'Access-Control-Allow-Origin' => ['*'],
            ],
        ];

        return $behaviors;
    }
}