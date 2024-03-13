<?php

namespace api\modules\v1\controllers;

use common\models\Customer;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Customer::find(),
        ]);
    }
}