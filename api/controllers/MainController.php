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
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }
    public function actionIndex()
    {
        $registered = Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all();
        $order = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all();
        $bringing = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')),'status' => 'Olib kelishda'])->all();
        $cancelled = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Bekor qilindi' ])->all();
        $register = Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])->all();
        $cleaned = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Quritishda'])->all();
        $packaged = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Yetkazib berishda'])->all();
        $completed = Order::find()->where(['created_at' => date(\Yii::$app->request->get('date')), 'status' => 'Yakunlandi'])->all();
        $registered_order = OrderItem::findBySql('SELECT * FROM order_item WHERE created_at = :date group by ',[':date' => date(\Yii::$app->request->get('date'))])->all();
    }
}