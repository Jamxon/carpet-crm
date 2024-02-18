<?php

namespace api\controllers;



use yii\data\ActiveDataProvider;
use yii\web\Response;

class CustomerController extends MyController
{
    public function behaviors() {
        return [
            'formats' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    public function actionOptions(){
        $header = \Yii::$app->response->headers;
        $header->add('Access-Control-Allow-Origin', '*');
        $header->add('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $header->add('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
    public function actionSearchbyphone($phone)
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['LIKE', 'phone_1', $phone])
                ->orWhere(['LIKE', 'phone_2', $phone]),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    private function cyrillic_to_latin($cyrillicString)
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'ғ', 'ҳ', 'Ғ', 'Ҳ', 'қ', 'Қ',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'ў', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Ў', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'g\'', 'h', 'G\'', 'H', 'q', 'Q',
            'r', 's', 't', 'u', 'f', 'x', 's', 'ch', 'sh', 'o\'', '', '', '', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'X', 'S', 'Ch', 'Sh', 'O\'', '', '', '', 'E', 'Yu', 'Ya'
        ];
        return str_replace($cyr, $lat, $cyrillicString);
    }
    public function actionSearchbyname($name)
    {
        $name = $this->cyrillic_to_latin($name);
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find()
                ->where(['LIKE', 'name', $name]),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => \common\models\Customer::find(),
            'pagination' => [
                'pageSize' => 100,
            ]
        ]);
    }
    public function actionCreate($employer_id, $name, $phone_1, $phone_2, $address, $date, $source, $level, $comment)
    {
        $model = new \common\models\Customer();
        $model->employer_id = $employer_id;
        $model->name = $name;
        $model->phone_1 = $phone_1;
        $model->phone_2 = $phone_2;
        $model->address = $address;
        $model->date = $date;
        $model->source = $source;
        $model->level = $level;
        $model->comment = $comment;
        $model->save();
        return $model;
    }
    public function actionUpdate($id)
    {
        $model = \common\models\Customer::findOne($id);
        if (\Yii::$app->request->post())
        {
            $model->employer_id = \Yii::$app->request->post('employer_id');
            $model->name = \Yii::$app->request->post('name');
            $model->phone_1 = \Yii::$app->request->post('phone_1');
            $model->phone_2 = \Yii::$app->request->post('phone_2');
            $model->address = \Yii::$app->request->post('address');
            $model->date = \Yii::$app->request->post('date');
            $model->source = \Yii::$app->request->post('source');
            $model->level = \Yii::$app->request->post('level');
            $model->comment = \Yii::$app->request->post('comment');
            if ($model->save()){
                return ["Success"];
            }else {
                return $model->getErrors();
            }
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = \common\models\Customer::findOne($id);
        $model->delete();
        return $model;
    }
    public function actionView($id)
    {
        return \api\models\Customer::findOne($id);
    }
}