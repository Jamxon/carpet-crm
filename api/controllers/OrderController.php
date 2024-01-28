<?php

namespace api\controllers;

use yii\rest\ActiveController;

class OrderController extends MyController
{
    public $modelClass = 'common\models\Order';
}