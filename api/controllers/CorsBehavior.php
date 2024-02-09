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
}