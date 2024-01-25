<?php

namespace api\controllers;

use yii\rest\ActiveController;

class OrderController extends ActiveController
{
    public $modelClass = 'common\models\Order';
}