<?php

namespace api\controllers;

use api\models\Customer;
use common\models\Order;
use common\models\OrderItem;

class MainController extends MyController
{
    public function behaviors()
    {
        return [
            'format' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }
    public function actionIndex()
    {
        $registered = count(Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all());
        $order = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all());
        $bringing = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')),'status' => 'Olib kelishda'])->all());
        $cancelled = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Bekor qilindi' ])->all());
//        $register = count(Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all());
        //olingan orderlar
        $registered_order = Order::find()->join('LEFT JOIN', 'order_item', 'order_item.order_id = order.id')->where(['order.created_at' => date(\Yii::$app->request->get('date'))])->all();
        $cleaned = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Quritishda'])->all());
        $packaged = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Yetkazib berishda'])->all());
        $completed = count(Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Yakunlandi'])->all());
        return [
            'registered' => $registered,
            'order' => $order,
            'bringing' => $bringing,
            'cancelled' => $cancelled,
//            'register' => $register,
            'cleaned' => $cleaned,
            'packaged' => $packaged,
            'completed' => $completed,
            'registered_order' => $registered_order
        ];
    }
}