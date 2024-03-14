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
            'except' => ['options']
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
    public function actionSearchbyphone($phone)
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['=', 'phone_1', $phone])
                ->orWhere(['=', 'phone_2', $phone]),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    private function cyrillic_to_latin($cyrillicString)
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'ғ', 'ҳ', 'Ғ', 'Ҳ', 'қ', 'Қ',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'ў', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Ў', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'g\'', 'h', 'G\'', 'H', 'q', 'Q',
            'r', 's', 't', 'u', 'f', 'x', 's', 'ch', 'sh', 'o\'', '', '', '', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'X', 'S', 'Ch', 'Sh', 'O\'', '', '', '', 'E', 'Yu', 'Ya'
        ];
        return str_replace($cyr, $lat, $cyrillicString);
    }
    public function actionSearchbyname($name)
    {
        $name = $this->cyrillic_to_latin($name);
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['LIKE', 'name', $name]),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
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
               $kpi->user_id = \Yii::$app->request->post('employer_id');
               $kpi->order_id = 0;
               $kpi->customer_id = $customer->id;
               $kpi->salary_id = $salary->salary;
               $kpi->date = date('Y-m-d H:i:s');
               $kpi->comment = "Olingan mijoz uchun kpi";
               if (!$kpi->save()){
                   return $kpi->getErrors();
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
}