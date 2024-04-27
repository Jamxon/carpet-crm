<?php
namespace api\controllers;

use api\models\User;
use common\models\Salary;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'except' => ['options', 'index', 'create', 'update', 'delete', 'view', 'getdriver','blockuser','getblockedusers','unblockuser']
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find(),
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
            if ($user->save()){
                $salary = new Salary();
                $salary->user_id = $user->id;
                $salary->salary = \Yii::$app->request->post('salary');
                $salary->type = \Yii::$app->request->post('type');
                if (!$salary->save()){
                    return $salary->getErrors();
                }
            }
            return $user;
    }

    public function actionBlockuser()
    {
        $userId = \Yii::$app->request->post('id');
        $user = User::findOne($userId);

        if ($user !== null) {
            $user->status = 0;
            if ($user->save()) {
                return ['status' => 'Blocklandi'];
            } else {
                return $user->getErrors();
            }
        } else {
            return ['error' => 'User not found for ID: ' . $userId];
        }
    }


    public function actionUnblockuser()
    {
        $user = User::findOne(\Yii::$app->request->post('id'));
        $user->status = 10;
        if ($user->save()){
            return ['status' => 'Blockdan chiqarildi'];
        }else{
            return $user->getErrors();
        }
    }

    public function actionGetblockedusers()
    {
        $users = User::find()
            ->where(['not' , ['status' => 10]])
            ->all();
        return $users;
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