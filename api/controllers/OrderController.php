<?php

namespace api\controllers;

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
        return [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'create' => ['POST'],
                    'update' => ['PUT'],
                    'delete' => ['DELETE'],
                    'search' => ['GET'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['http://yii.loc'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return new ActiveDataProvider([
           'query' => Order::find()->with('orderitem'),
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
}