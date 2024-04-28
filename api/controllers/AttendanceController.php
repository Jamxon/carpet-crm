<?php

namespace api\controllers;


use api\models\Attendance;
use common\models\Kpi;
use common\models\Salary;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class AttendanceController extends Controller
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
            'except' => ['options', 'index', 'date', 'create', 'update', 'delete', 'view', 'go']
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
        return \api\models\Attendance::find()->all();
    }

    public function actionAttendance()
    {
        if (!\Yii::$app->request->isPost) {
            throw new MethodNotAllowedHttpException("Method Not Allowed. This endpoint only supports POST requests.");
        }

        $startDate = \Yii::$app->request->post('start_date');
        $endDate = \Yii::$app->request->post('end_date');

        $query = Attendance::find();

        $startDate = $this->validateDate($startDate);
        $endDate = $this->validateDate($endDate);

        if ($startDate !== null) {
            $query->andWhere(['>=', 'come_time', $startDate]);
        }

        if ($endDate !== null) {
            $query->andWhere(['<=', 'go_time', $endDate]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
    private function validateDate($date)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }
        return null;
    }
    public function actionCreate()
    {
        $model = new Attendance();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->save()) {
            return $model;
        } else {
            return $model->getErrors();
        }
    }

    public function actionUpdate($id)
    {
        $model = Attendance::findOne($id);
        if ($model) {
            $model->load(\Yii::$app->request->post(), '');
            if ($model->save()) {
                return $model;
            } else {
                return $model->getErrors();
            }
        } else {
            throw new \yii\web\NotFoundHttpException("Attendance with id $id not found");
        }
    }

    public function actionDelete($id)
    {
        $model = Attendance::findOne($id);
        if ($model) {
            $model->delete();
            \Yii::$app->response->setStatusCode(204);
        } else {
            throw new \yii\web\NotFoundHttpException("Attendance with id $id not found");
        }
    }

    public function actionView($id)
    {
        $model = Attendance::findOne($id);
        if ($model) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException("Attendance with id $id not found");
        }
    }

    public function actionGo()
    {
        $model = Attendance::findOne(\Yii::$app->request->post('id'));
        if ($model) {
            $model->full_time = \Yii::$app->request->post('full_time');
            $model->go_time = \Yii::$app->request->post('go_time');
            $model->status = "Ketdi";
            $model->comment = \Yii::$app->request->post('comment');
            if ($model->save()) {
                if ($model->user->type->name != "Operator") {
                    $kpi = new Kpi();
                    $salary = Salary::find()->where(['user_id' => $model->user_id,'type' => 'Kunlik'])->one();
                    if ($salary){
                        $kpi->user_id = $model->user_id;
                        $kpi->order_id = 0;
                        $kpi->customer_id = 0;
                        if ($model->full_time == 1){
                            $kpi->salary_id = $salary->salary;
                            $kpi->date = date('Y-m-d h:i:s');
                            $kpi->comment = "Kunlik maosh";
                            if ($kpi->save()) {
                                return $model;
                            } else {
                                return $kpi->getErrors();
                            }
                        }else{
                            $kpi->salary_id = $salary->salary / 2;
                            $kpi->date = date('Y-m-d h:i:s');
                            $kpi->comment = "Yarim kunlik maosh";
                            if ($kpi->save()) {
                                return $model;
                            } else {
                                return $kpi->getErrors();
                            }
                        }
                    }
                }
                return $model;
            } else {
                return $model->getErrors();
            }
        } else {
            throw new \yii\web\NotFoundHttpException("Attendance with id ".\Yii::$app->request->post('id')." not found");
        }
    }
}