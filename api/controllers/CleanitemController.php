<?php

namespace api\controllers;


use yii\data\ActiveDataProvider;

class CleanitemController extends MyController
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
        return new ActiveDataProvider([
            'query' => \common\models\Cleanitem::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
    public function actionView($id)
    {
        return \common\models\Cleanitem::findOne($id);
    }
    public function actionCreate()
    {
        $model = new \common\models\Cleanitem();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }
    public function actionUpdate($id)
    {
        $model = \common\models\Cleanitem::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }
    public function actionDelete($id)
    {
        return \common\models\Cleanitem::deleteAll(['id' => $id]);
    }
}