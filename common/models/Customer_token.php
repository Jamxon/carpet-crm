<?php

namespace common\models;

/**
 * This is the model class for table "
 * customer_token".
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 */

class Customer_token extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'customer_token';
    }

    public function rules()
    {
        return [
            [['user_id', 'access_token'], 'required'],
            [['user_id'], 'integer'],
            [['access_token'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'access_token' => 'Access Token',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Customer::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->access_token = \Yii::$app->security->generateRandomString(32);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->user->access_token = $this->access_token;
            $this->user->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }


}