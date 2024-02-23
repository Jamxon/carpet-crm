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
        $registered_customer = count(Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all());
        $registered_order = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date')])->all());
        $receive_order = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Qabul qilindi'])->all());
        $bringing = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'),'status' => 'Olib kelishda'])->all());
        $cancelled = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Bekor qilindi' ])->all());
        $registered_order_item = count(Order::find()->leftJoin('orderitem', 'orderitem.order_id = order.id')->where(['created_at' => \Yii::$app->request->get('date')])->all());
        $cleaned = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Quritishda'])->all());
        $packaged = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yetkazib berishda'])->all());
        $completed = count(Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yakunlandi'])->all());

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