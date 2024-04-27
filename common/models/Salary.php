<?php

namespace common\models;

/**
 * This is the model class for table "
 * @property int $id
 * @property int $user_id
 * @property int $salary
 * @property int $type
 */


class Salary extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'salary';
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'salary',
            'type'
        ];
    }
    public function rules()
    {
        return [
            [['user_id', 'salary', 'type'], 'integer'],
            [['user_id', 'salary', 'type'], 'required'],
            [['user_id', 'salary', 'type'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'salary' => 'Salary',
            'type' => 'Type',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}