<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class OrderitemController extends MyController
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }
    public function actionIndx()
    {
        return new ActiveDataProvider([
            'query' => \common\models\OrderItem::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
    public function actionView($id)
    {
        return \common\models\OrderItem::findOne($id);
    }
    public function actionCreate()
    {
        $model = new \common\models\OrderItem();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->errors;
    }
    public function actionUpdate($id)
    {
        $model = \common\models\OrderItem::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->errors;
    }
    public function actionDelete($id)
    {
        return \common\models\OrderItem::findOne($id)->delete();
    }
}