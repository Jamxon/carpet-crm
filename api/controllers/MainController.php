<?php

namespace api\controllers;

use api\models\Customer;
use common\models\Order;
use common\models\OrderItem;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;

class MainController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'except' => ['options']
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->getHeaders()->set('Allow', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function actionIndex()
    {
            $startDate = \Yii::$app->request->get('start_date');
            $endDate = \Yii::$app->request->get('end_date');
        $registered_customer = Customer::find()->where(['>=', 'created_at', $startDate])
            ->andWhere(['<=', 'created_at', $endDate])
            ->count();
        $registered_order = Order::find()->where(['created_at' => \Yii::$app->request->get('date')])->count();
        $receive_order = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Qabul qilindi'])->count();
        $bringing = Order::find()->where(['created_at' => \Yii::$app->request->get('date'),'status' => 'Olib kelishda'])->count();
        $cancelled = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Bekor qilindi' ])->count();
        $registered_order_item = OrderItem::find()
            ->select('order_item.clean_item_id, order_item.order_id, order_item.size, order_item.count')
            ->leftJoin('clean_item', 'clean_item.id = order_item.clean_item_id')
            ->leftJoin('order', 'order.id = order_item.order_id')
            ->where(['created_at' => \Yii::$app->request->get('date')])
            ->count();
        $cleaned = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Quritishda'])->count();
        $packaged = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yetkazib berishda'])->count();
        $completed = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'status' => 'Yakunlandi'])->count();
        $is_reclean = Order::find()->where(['created_at' => \Yii::$app->request->get('date'), 'is_reclean' => 1])->count();
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
            'is_reclean' => $is_reclean
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