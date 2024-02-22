<?php

namespace api\controllers;

use api\models\Company;
use api\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use function Symfony\Component\VarDumper\Dumper\esc;

class CompanyController extends MyController
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Company::find(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
    }
    public function actionCreate()
    {
        $model = new Company();
        $image = new UploadForm();
        if (\Yii::$app->request->isPost()){
            $model->name = \Yii::$app->request->post('name');
            $model->image = \Yii::$app->request->post('image');
            $model->address = \Yii::$app->request->post('address');
            $model->phone = \Yii::$app->request->post('phone');
            $model->status = \Yii::$app->request->post('status');
            $image->imageFiles = UploadedFile::getInstances($image, 'imageFiles');
            if ($model->save() && $image->upload()){
                return ["Success"];
            }else{
                return ["To'g'ri jo'nat krisa"];
            }
        }
        return null;
    }
    public function actionUpdate($id)
    {
        $model =Company::findOne($id);
        $image = new UploadForm();
        if (\Yii::$app->request->isPost()){
            $model->name = \Yii::$app->request->post('name');
            $model->image = \Yii::$app->request->post('image');
            $model->address = \Yii::$app->request->post('address');
            $model->phone = \Yii::$app->request->post('phone');
            $model->status = \Yii::$app->request->post('status');
            $image->imageFiles = UploadedFile::getInstances($image, 'imageFiles');
            if ($model->save() && $image->upload()){
                return ["Success"];
            }else{
                return ["To'g'ri jo'nat krisa"];
            }
        }
        return $model;
    }
    public function actionView($id)
    {
        return new ActiveDataProvider([
            'query' => Company::findOne($id)
        ]);
    }
    public function actionDelete($id)
    {
        $model = Company::findOne($id);
        if ($model->delete())
            return ["Success"];
        return null;
    }
}