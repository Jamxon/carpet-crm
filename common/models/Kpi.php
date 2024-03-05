<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $salary_id
 * @property int $date
 * @property int $comment
 */


class Kpi extends ActiveRecord
{
    public static function tableName()
    {
        return 'kpi';
    }

    public function rules()
    {
        return [
            [['user_id', 'order_id', 'salary_id',], 'integer'],
            [['user_id','salary_id', 'date', 'comment'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'salary_id' => 'Salary ID',
            'date' => 'Date',
            'comment' => 'Comment',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
    public function getSalary()
    {
        return $this->hasOne(Salary::class, ['id' => 'salary_id']);
    }
}