<?php
namespace api\controllers;

use api\models\User;

class UserController extends MyController
{
    public function actionIndex()
    {
        return User::find()->all();
    }
    public function actionCreate()
    {
       $user = new User();

         $user->username = \Yii::$app->request->post('username');
         $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->password_hash = \Yii::$app->security->generatePasswordHash(\Yii::$app->request->post('password'));
            $user->email = \Yii::$app->request->post('email');
            $user->phone = \Yii::$app->request->post('phone');
            $user->comp_id = \Yii::$app->request->post('comp_id');
            $user->type_id = \Yii::$app->request->post('type_id');
            $user->status = 10;
            $user->access_token = null;
            $user->created_at = time();
            $user->updated_at = time();
            $user->verification_token = \Yii::$app->security->generateRandomString() . '_' . time();
            $user->save();
            return $user;

    }
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $user->username = \Yii::$app->request->post('username');
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->password_hash = \Yii::$app->security->generatePasswordHash(\Yii::$app->request->post('password'));
        $user->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
        $user->email = \Yii::$app->request->post('email');
        $user->phone = \Yii::$app->request->post('phone');
        $user->comp_id = \Yii::$app->request->post('comp_id');
        $user->type_id = \Yii::$app->request->post('type_id');
        $user->status = 10;
        $user->access_token = null;
        $user->created_at = time();
        $user->updated_at = time();
        $user->verification_token = \Yii::$app->security->generateRandomString() . '_' . time();
        $user->save();
        return $user;
    }
    public function actionView($id)
    {
        return User::findOne($id);
    }
    public function actionDelete($id)
    {
        $user = User::findOne($id);
        $user->delete();
        return $user;
    }
}