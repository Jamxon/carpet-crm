<?php

namespace api\controllers;

use api\models\TypeEmployer;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\IdentityInterface;
use yii\web\Response;

class TypeemployerController  extends Controller
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