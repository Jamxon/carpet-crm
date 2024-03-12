<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;

class ChiqimtypeController extends MyController
{
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => \common\models\Chiqimtype::find(),
        ]);
    }

    public function actionCreate()
    {
        $model = new \common\models\Chiqimtype();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->post('id')) {
            $model = \common\models\Chiqimtype::findOne(\Yii::$app->request->post('id'));
            $model->load(\Yii::$app->request->post(), '');
            if ($model->save()) {
                return $model;
            }
            return $model->getErrors();
        }
        return 'id is required';
    }

    public function actionView($id): ?\common\models\Chiqimtype
    {
        return \common\models\Chiqimtype::findOne($id);
    }
    public function actionDelete($id): int
    {
        return \common\models\Chiqimtype::deleteAll(['id' => $id]);
    }
}