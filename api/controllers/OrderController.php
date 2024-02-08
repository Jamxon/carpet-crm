<?php

namespace api\controllers;

use common\models\Order;
use common\models\OrderItem;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class OrderController extends MyController
{
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
        $orderItem = OrderItem::find()->all();
        if (\Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post(), '');
            $model->customer_id = \Yii::$app->request->post('customer_id');
            $model->date = \Yii::$app->request->post('date');
            $model->status = \Yii::$app->request->post('status');
            $model->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
            $model->comment = \Yii::$app->request->post('comment');
            if ($model->save()) {
                return \Yii::$app->response->statusCode = 201;
            } else {
                return $model->getErrors();
            }
        } else {
            return $orderItem;
        }
    }
    public function actionUpdate()
    {
        $model = new Order();
        if (\Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post(), '');
            $model->customer_id = \Yii::$app->request->post('customer_id');
            $model->date = \Yii::$app->request->post('date');
            $model->status = \Yii::$app->request->post('status');
            $model->finish_discount_price = \Yii::$app->request->post('finish_discount_price');
            $model->comment = \Yii::$app->request->post('comment');
            if ($model->save()) {
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
                //search by id or name or phone or address , request from data
                "SELECT * FROM `order` WHERE `id` LIKE '%" . \Yii::$app->request->get('id') . "%' OR `name` LIKE '%" . \Yii::$app->request->get('name') . "%' OR `phone` LIKE '%" . \Yii::$app->request->get('phone') . "%' OR `address` LIKE '%" . \Yii::$app->request->get('address') . "%'"
            ),
        ]);
    }
}