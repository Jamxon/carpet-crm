<?php

namespace api\controllers;

use api\models\Customer;
use common\models\Order;

class MainController extends MyController
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
        $registered_customer = Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->count();
        $registered_order = Order::find()->where(['created_at' => \Yii::$app->request->get('date')])->count();
        $receive_order = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Qabul qilindi'])->count();
        $bringing = Order::find()->where(['created_at' => \Yii::$app->request->get('date'),'status' => 'Olib kelishda'])->count();
        $cancelled = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Bekor qilindi' ])->count();
        $registered_order_item = Order::find()
            ->leftJoin('order_item', 'order_item.order_id = order.id')
            ->where(['created_at' => \Yii::$app->request->get('date')])
            ->count();
        $cleaned = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Quritishda'])->count();
        $packaged = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yetkazib berishda'])->count();
        $completed = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yakunlandi'])->count();

        return [
            'registered_customer' => $registered_customer,
            'registered_order' => $registered_order,
            'receive_order' => $receive_order,
            'bringing' => $bringing,
            'cancelled' => $cancelled,
            'cleaned' => $cleaned,
            'registered_order_item' => $registered_order_item,
            'packaged' => $packaged,
            'completed' => $completed,
        ];
    }
}