<?php

namespace api\controllers;

use api\models\Customer;
use common\models\CleanItem;
use common\models\Order;
use common\models\OrderItem;
use Psy\Util\Json;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;

class OrderController extends MyController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
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
        $model = new Order();
        $orderItem = new OrderItem();
        $cleanItem = new CleanItem();
        $orderItems = OrderItem::find()->all();
        if (\Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post(), '');
            $model->customer_id = \Yii::$app->request->post('customer_id');
            $model->date = \Yii::$app->request->post('date');
            $model->status = \Yii::$app->request->post('status');
            $model->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
            $model->comment = \Yii::$app->request->post('comment');
            $orderItem->clean_item_id = $cleanItem->id;
            $orderItem->order_id = $model->id;
            $orderItem->size = \Yii::$app->request->post('size');
            $orderItem->count = \Yii::$app->request->post('count');
            if ($model->save() && $orderItem->save()) {
                return ["Success" => "Order saved successfully"];
            } else {
                return $model->getErrors();
            }
        } else {
            return $orderItems;
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
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionCleaning()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yuvishda']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionDrying()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Quritishda']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionPackaging()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Qadoqlashda']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionDelivering()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yetkazib berishda']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionComplete()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Yakunlandi']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionCancelled()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 'Bekor qilindi']),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
}