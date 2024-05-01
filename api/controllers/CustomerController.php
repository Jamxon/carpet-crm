<?php

namespace api\controllers;


use common\models\Kpi;
use common\models\Salary;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class CustomerController extends Controller
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
            'except' => ['options','index', 'create', 'update', 'view', 'delete', 'search','searchbyphone']
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
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update'], $actions['view'], $actions['delete']);
        return $actions;
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionCreate()
    {
        $customer = new \common\models\Customer();
       if (\Yii::$app->request->post()){
           $customer->load(\Yii::$app->request->post(), '');
           $customer->employer_id = \Yii::$app->request->post('employer_id');
           $customer->name = \Yii::$app->request->post('name');
           $customer->phone_1 = \Yii::$app->request->post('phone_1');
           $customer->phone_2 = \Yii::$app->request->post('phone_2');
           $customer->address = \Yii::$app->request->post('address');
           $customer->date = \Yii::$app->request->post('date_call');
           $customer->source = \Yii::$app->request->post('source');
           $customer->level = \Yii::$app->request->post('level');
           $customer->comment = \Yii::$app->request->post('comment_call');
           if ($customer->save()){
               $kpi = new Kpi();
               $salary = Salary::find()->where(['user_id' => \Yii::$app->request->post('employer_id')])->one();
               if ($salary->type == "Kpi"){
                   $kpi->user_id = \Yii::$app->request->post('employer_id');
                   $kpi->order_id = 0;
                   $kpi->customer_id = $customer->id;
                   $kpi->salary_id = $salary->salary;
                   $kpi->date = date('Y-m-d H:i:s');
                   $kpi->comment = "Olingan mijoz ($customer->name) uchun kpi";
                   if (!$kpi->save()){
                       return $kpi->getErrors();
                   }
               }
               return ["Success"];
              }else {
                return $customer->getErrors();
           }
       }
       return $customer;
    }
    public function actionUpdate($id)
    {
        $model = \common\models\Customer::findOne($id);
        if (\Yii::$app->request->post())
        {
            $model->employer_id = \Yii::$app->request->post('employer_id');
            $model->name = \Yii::$app->request->post('name');
            $model->phone_1 = \Yii::$app->request->post('phone_1');
            $model->phone_2 = \Yii::$app->request->post('phone_2');
            $model->address = \Yii::$app->request->post('address');
            $model->date = \Yii::$app->request->post('date');
            $model->source = \Yii::$app->request->post('source');
            $model->level = \Yii::$app->request->post('level');
            $model->comment = \Yii::$app->request->post('comment');
            if ($model->save()){
                return ["Success"];
            }else {
                return $model->getErrors();
            }
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = \common\models\Customer::findOne($id);
        $model->delete();
        return $model;
    }
    public function actionView($id)
    {
        return \api\models\Customer::findOne($id);
    }
    public function actionSearch($data)
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['LIKE', 'name', $data])
                ->orWhere(['LIKE', 'phone_1', $data])
                ->orWhere(['LIKE', 'phone_2', $data])
                ->orwhere(['LIKE', 'address', $data]),
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);
    }
    public function actionSearchbyphone($phone)
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['LIKE', 'phone_1', $phone])
                ->orWhere(['LIKE', 'phone_2', $phone]),
        ]);
    }
}