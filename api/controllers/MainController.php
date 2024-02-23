<?php

namespace api\controllers;

use api\models\Customer;
use common\models\Order;
use common\models\OrderItem;
use yii\data\ActiveDataProvider;

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
        $registered_order_item = OrderItem::find()
            ->select('cleanitem.name, order.status, orderitem.size, orderitem.count')
            ->leftJoin('cleanitem', 'cleanitem.id = order_item.cleanitem_id')
            ->leftJoin('order', 'order.id = order_item.order_id')
            ->where(['created_at' => \Yii::$app->request->get('date')])
            ->all();
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
    public function actionRegistered_customer()
    {
        return new ActiveDataProvider([
            'query' => Customer::find()->where(['created_at' => date(\Yii::$app->request->get('date'))])
        ]);
    }
    public function actionRegistered_order()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date')])
        ]);
    }
    public function actionReceive_order()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Qabul qilindi'])
        ]);
    }
    public function actionBringing()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'),'status' => 'Olib kelishda'])
        ]);
    }
    public function actionCancelled()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Bekor qilindi' ])
        ]);
    }
    public function actionRegistered_order_item()
    {
        return new ActiveDataProvider([
            'query' => OrderItem::find()
                ->leftJoin('order', 'order.id = order_item.order_id')
                ->where(['created_at' => \Yii::$app->request->get('date')])
        ]);
    }
    public function actionCleaned()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Quritishda'])
        ]);
    }
    public function actionPackaged()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yetkazib berishda'])
        ]);
    }
    public function actionCompleted()
    {
        return new ActiveDataProvider([
            'query' => Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yakunlandi'])
        ]);
    }
}