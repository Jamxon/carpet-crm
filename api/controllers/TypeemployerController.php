<?php

namespace api\controllers;

use api\models\TypeEmployer;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;

class TypeemployerController  extends MyController
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => TypeEmployer::find(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionCreate()
    {
        $model = new TypeEmployer();
        if (\Yii::$app->request->post()){
            $model->name = \Yii::$app->request->post('name');
            if ($model->save()){
                return "Success";
            }else{
                return $model->getErrors();
            }
        }
        return ["Tog'ri jo'nat krisa"];
    }
    public function actionUpdate($id)
    {
        $model = TypeEmployer::findOne($id);
        if (\Yii::$app->request->post()){
            $model->name = \Yii::$app->request->post('name');
            if ($model->save()){
                return ["Success"];
            }else{
                return $model->getErrors();
            }
        }
        return ["Tog'ri jo'nat krisa"];
    }
    public function actionDelete($id)
    {
        $model = TypeEmployer::findOne($id);
        if ($model->delete()){
            return ["Success"];
        }
        return null;
    }
    public function actionView($id)
    {
        return  TypeEmployer::findOne($id);
    }
}