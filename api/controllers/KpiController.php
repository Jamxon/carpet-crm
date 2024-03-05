<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class KpiController extends MyController
{
    public function actionIndex()
    {
        return  new ActiveDataProvider([
            'query' => \common\models\Kpi::find(),
        ]);
    }

    public function actionView($id)
    {
        return \common\models\Kpi::findOne($id);
    }

    public function actionCreate()
    {
        $model = new \common\models\Kpi();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        else {
            return $model->getErrors();
        }
    }

    public function actionUpdate($id)
    {
        $model = \common\models\Kpi::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        }
        else{
            return $model->getErrors();
        }
    }

    public function actionDelete($id)
    {
        $model = \common\models\Kpi::findOne($id);
        $model->delete();
        return 'Deleted';
    }


}