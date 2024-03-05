<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class SalaryController extends MyController
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Salary::find(),
        ]);
    }

    public function actionView($id)
    {
        return \common\models\Salary::findOne($id);
    }

    public function actionCreate()
    {
        $model = new \common\models\Salary();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionUpdate($id)
    {
        $model = \common\models\Salary::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionDelete($id)
    {
        return \common\models\Salary::findOne($id)->delete();
    }
}