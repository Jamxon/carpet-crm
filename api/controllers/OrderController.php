<?php

namespace api\controllers;

use api\models\Customer;
use common\models\Cleanitem;
use common\models\Order;
use common\models\OrderItem;
use Psy\Util\Json;
use yii\data\ActiveDataProvider;
use yii\debug\models\search\User;
use yii\rest\ActiveController;
use yii\web\Response;

class OrderController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options','bringing','cleaning','drying','packaging','delivering','complete','cancelled'];
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
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
                $order->status = "Olib kelishda";
                $order->discount_type = \Yii::$app->request->post('discount_type');
                $order->discount_item = \Yii::$app->request->post('discount_item');
                $order->discount_amount = \Yii::$app->request->post('discount_amount');
                $order->driver_id = \Yii::$app->request->post('driver_id');
                $order->finish_discount_price = null;
                $order->comment = \Yii::$app->request->post('comment_order');
                if ($order->save()) {
                    return ['Success ikkalasiyam'];
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
            $order->status = "Olib kelishda";
            $order->discount_type = \Yii::$app->request->post('discount_type');
            $order->discount_item = \Yii::$app->request->post('discount_item');
            $order->discount_amount = \Yii::$app->request->post('discount_amount');
            $order->driver_id = \Yii::$app->request->post('driver_id');
            $order->finish_discount_price = null;
            $order->comment = \Yii::$app->request->post('comment_order');
            if ($order->save()) {
                return ['Success'];
            } else {
                return $order->getErrors();
            }
        }
        else {
            return $order->getErrors();
        }
    }
    public function actionUpdate($id)
    {
        $model =Order::findOne($id);
        $orderItem =OrderItem::find()->where(['order_id' => $model->id]);
        if (\Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post(), '');
            $model->customer_id = \Yii::$app->request->post('customer_id');
            $model->date = \Yii::$app->request->post('date');
            $model->status = \Yii::$app->request->post('status');
            $model->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
            $model->comment = \Yii::$app->request->post('comment');
            $orderItem->clean_item_id = \Yii::$app->request->post('clean_item_id');
//            $orderItem->order_id = \Yii::$app->request->post('order_id');
            $orderItem->size = \Yii::$app->request->post('size');
            $orderItem->count = \Yii::$app->request->post('count');
            if ($model->save() && $orderItem->save()) {
                return \Yii::$app->response->statusCode = 201;
            } else {
                return $model->getErrors();
            }
        }
        else {
            return "To'g'ri jo'nat krisa";
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
            'query' => Order::findBySql(
                "SELECT * FROM `order` WHERE `id` LIKE '%" . \Yii::$app->request->get('id') . "%' OR `name` LIKE '%" . \Yii::$app->request->get('name') . "%' OR `phone` LIKE '%" . \Yii::$app->request->get('phone') . "%' OR `address` LIKE '%" . \Yii::$app->request->get('address') . "%'"
            ),
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
}