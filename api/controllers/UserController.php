<?php
namespace api\controllers;

use api\models\User;
use yii\data\ActiveDataProvider;

class UserController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options', 'index', 'create', 'update', 'view', 'delete', 'getdriver'];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update'], $actions['view'], $actions['delete']);
        return $actions;
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
    public function actionCreate()
    {
       $user = new User();

         $user->name = \Yii::$app->request->post('name');
         $user->username = \Yii::$app->request->post('username');
         $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->password_hash = \Yii::$app->security->generatePasswordHash(\Yii::$app->request->post('password'));
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
        if (\Yii::$app->request->post()){
            $user->name = \Yii::$app->request->post('name');
            $user->username = \Yii::$app->request->post('username');
            $user->auth_key = \Yii::$app->security->generateRandomString();
            if (\Yii::$app->request->post('password') != null)
                $user->password_hash = \Yii::$app->security->generatePasswordHash(\Yii::$app->request->post('password'));
            $user->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
            $user->phone = \Yii::$app->request->post('phone');
            $user->comp_id = \Yii::$app->request->post('comp_id');
            $user->type_id = \Yii::$app->request->post('type_id');
            $user->status = 10;
            $user->access_token = null;
            $user->created_at = time();
            $user->updated_at = time();
            $user->verification_token = \Yii::$app->security->generateRandomString() . '_' . time();
            if ($user->save()){
                return "Success";
            }else{
                return $user->getErrors();
            }
        }
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
    public function actionGetdriver()
    {
        $users = User::find()
            ->select(['id', 'name'])
            ->where(['type_id' => 4])
            ->all();
        return $users;
    }

}