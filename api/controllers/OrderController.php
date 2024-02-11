<?php

namespace api\controllers;

use common\models\CleanItem;
use common\models\Order;
use common\models\OrderItem;
use yii\data\ActiveDataProvider;

class OrderController extends MyController
{
    public function behaviors()
    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['corsFilter'] = [
//            'class' => \yii\filters\Cors::className(),
//        ];
//
//        return $behaviors;
        //cors error react request header field access-control-allow-origin is not allowed by access-control-allow-headers in preflight response
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return new ActiveDataProvider([
            'query' => Order::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
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
                return \Yii::$app->response->statusCode = 201;
            } else {
                return $model->getErrors();
            }
        } else {
            return $orderItems;
        }
    }
    public function actionUpdate()
    {
        $model = new Order();
        $orderItem = new OrderItem();
        if (\Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post(), '');
            $model->customer_id = \Yii::$app->request->post('customer_id');
            $model->date = \Yii::$app->request->post('date');
            $model->status = \Yii::$app->request->post('status');
            $model->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
            $model->comment = \Yii::$app->request->post('comment');
            $orderItem->clean_item_id = \Yii::$app->request->post('clean_item_id');
            $orderItem->order_id = \Yii::$app->request->post('order_id');
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
}