<?php

namespace api\controllers;

use api\models\Customer;
use common\models\OrderLocation;
use common\models\Cleanitem;
use common\models\Kpi;
use common\models\Order;
use common\models\OrderItem;
use common\models\Salary;
use Psy\Util\Json;
use yii\data\ActiveDataProvider;
use yii\debug\models\search\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\Response;

class OrderController extends Controller
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
            'except' => ['options', 'update','bringing','cleaning','drying','packaging','delivering','complete','cancelled','reclean','search',],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
           'query' => Order::find(),
        ]);
    }
    public function actionView($id)
    {
        return Order::findOne($id);
    }
    public function actionCreate()
    {
        $customer = new Customer();
        $order = new Order();
//        return  \Yii::$app->request->post('add_new_customer');
        if (\Yii::$app->request->post('add_new_customer') == 1) {
            $customer->employer_id = \Yii::$app->request->post('employer_id');
            $customer->name = \Yii::$app->request->post('name');
            $customer->phone_1 = \Yii::$app->request->post('phone_1');
            $customer->phone_2 = \Yii::$app->request->post('phone_2');
            $customer->address = \Yii::$app->request->post('address');
            $customer->date = \Yii::$app->request->post('date_call');
            $customer->source = \Yii::$app->request->post('source');
            $customer->level = \Yii::$app->request->post('level');
            $customer->comment = \Yii::$app->request->post('comment_call');

            if ($customer->save()) {
                $order->customer_id = $customer->id;
                $order->date = \Yii::$app->request->post('date_order');
                $order->submit_date = \Yii::$app->request->post('submit_date');
                $order->status = "Olib kelishda";
                $order->discount_type = \Yii::$app->request->post('discount_type');
                $order->discount_item = \Yii::$app->request->post('discount_item');
                $order->discount_amount = \Yii::$app->request->post('discount_amount');
                $order->driver_id = \Yii::$app->request->post('driver_id');
                $order->finish_discount_price = null;
                $order->comment = \Yii::$app->request->post('comment_order');
                if ($order->save()){
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
                } else {
                    return $order->getErrors();
                }
            } else {
                return $customer->getErrors();
            }
        }
        elseif (\Yii::$app->request->post('add_new_order') == 1) {
            $order->customer_id = \Yii::$app->request->post('customer_id');
            $order->date = \Yii::$app->request->post('date_order');
            $order->submit_date = \Yii::$app->request->post('submit_date');
            $order->status = "Olib kelishda";
            $order->discount_type = \Yii::$app->request->post('discount_type');
            $order->discount_item = \Yii::$app->request->post('discount_item');
            $order->discount_amount = \Yii::$app->request->post('discount_amount');
            $order->driver_id = \Yii::$app->request->post('driver_id');
            $order->finish_discount_price = null;
            $order->comment = \Yii::$app->request->post('comment_order');
                    $kpi = new Kpi();
                    $salary = Salary::find()->where(['user_id' => \Yii::$app->request->post('employer_id')])->one();
                    if ($salary && $salary->type == "Kpi"){
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
            if ($order->save() && $kpi->save()) {
                return ['Success'];
            } else {
                return $order->getErrors();
            }
        }
        else {
            return $order->getErrors();
        }
    }
    public function actionUpdate()
    {
        return \Yii::$app->request->post('id');
        $order = Order::find()->where(['id' => $id])->one();
        $orderLocation = new OrderLocation();
//        if (\Yii::$app->request->post('update') == 1){
//            $order->customer_id = \Yii::$app->request->post('customer_id');
//            $order->record_id = \Yii::$app->request->post('record_id');
//            $order->date = \Yii::$app->request->post('date');
//            $order->submit_date = \Yii::$app->request->post('submit_date');
//            $order->status = \Yii::$app->request->post('status');
//            $order->discount_type = \Yii::$app->request->post('discount_type');
//            $order->discount_item = \Yii::$app->request->post('discount_item');
//            $order->discount_amount = \Yii::$app->request->post('discount_amount');
//            $order->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
//            $order->driver_id = \Yii::$app->request->post('driver_id');
//            $order->comment = \Yii::$app->request->post('comment') ?? null;
//            if ($order->save()){
//                if(\Yii::$app->request->post('orderitem')){
//                    foreach (\Yii::$app->request->post('orderitem') as $item){
//                        $orderItem = OrderItem::findOne($item['id']);
//                        $orderItem->order_id = \Yii::$app->request->post('id');
//                        $orderItem->clean_item_id = $item['clean_item_id'];
//                        $orderItem->count = $item['count'];
//                        $orderItem->size = $item['size'];
//                        if (!$orderItem->save()){
//                            return $orderItem->getErrors();
//                        }
//                    }
//                }
//                if (\Yii::$app->request->post('latitude')){
//                    $orderLocation->order_id = \Yii::$app->request->post('id');
//                    $orderLocation->latitude = \Yii::$app->request->post('latitude');
//                    $orderLocation->longitude = \Yii::$app->request->post('longitude');
//                    $orderLocation->address = \Yii::$app->request->post('address');
//                    if (!$orderLocation->save()){
//                        return $orderLocation->getErrors();
//                    }
//                    return $order;
//                }
//                return $order;
//            }else{
//                $order->getErrors();
//            }
//            return $order;
//        }
        return $order;
    }

    public function actionCancel($id)
    {
        $model = Order::find($id);
        $model->status = 'Bekor qilindi';
        if ($model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
    }

    public function actionDelete($id)
    {
        $model = Order::findOne($id);
        if ($model->delete()) {
            return \Yii::$app->response->statusCode = 204;
        } else {
            return $model->getErrors();
        }
    }
    public function actionSearch()
    {
        $model = new ActiveDataProvider([
            'query' => Order::find()->where(['like', 'id', \Yii::$app->request->get('id')]),
        ]);
    }

    public function actionBringing()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Olib kelishda']),
        ]);
    }
    public function actionCleaning()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yuvishda']),
        ]);
    }
    public function actionDrying()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Quritishda']),
        ]);
    }
    public function actionPackaging()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Qadoqlashda']),
        ]);
    }
    public function actionDelivering()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yetkazib berishda']),
        ]);
    }
    public function actionComplete()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yakunlandi']),
        ]);
    }
    public function actionCancelled()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Bekor qilindi']),
        ]);
    }
    public function actionReclean()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['is_reclean' => 1]),
        ]);
    }
}