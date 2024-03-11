<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class ChiqimController extends MyController
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Chiqim::find(),
        ]);
    }

    public function actionView($id)
    {
        return \common\models\Chiqim::findOne($id);
    }

    public function actionCreate()
    {
        $model = new \common\models\Chiqim();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model;
    }

    public function actionUpdate($id)
    {
        $model = \common\models\Chiqim::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model;
    }

    public function actionDelete($id)
    {
        return \common\models\Chiqim::deleteAll(['id' => $id]);
    }

    public function actionSearch()
    {
        $model = new \common\models\Chiqim();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        return new ActiveDataProvider([
            'query' => $model->search(),
        ]);
    }


}