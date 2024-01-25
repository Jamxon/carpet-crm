<?php

namespace api\controllers;

use yii\rest\ActiveController;

class AttendanceController extends ActiveController
{
    public $modelClass = 'common\models\Attendance';
}