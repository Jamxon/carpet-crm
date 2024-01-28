<?php
namespace api\controllers;

use api\models\User;

class UserController extends MyController
{
    public function actionIndex()
    {
        return User::find()->all();
    }
}