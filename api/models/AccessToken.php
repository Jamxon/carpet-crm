<?php

namespace api\models;

use yii\db\ActiveRecord;

//property
/**
 * This is the model class for table "user_access_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property string $expired_at
 * @property string $used_at
 */
class AccessToken extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_access_token';
    }
    public function rules()
    {
        return [
            [['user_id', 'access_token', 'expired_at'], 'required'],
            [['user_id'], 'integer'],
            [['expired_at', 'used_at'], 'safe'],
            [['access_token'], 'string', 'max' => 255],
            [['access_token'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'access_token' => 'Access Token',
            'expired_at' => 'Expired At',
            'used_at' => 'Used At',];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->expired_at = date('Y-m-d H:i:s', strtotime('+1 day'));
            }
            return true;
        }
        return false;
    }
    public function isExpired()
    {
        return strtotime($this->expired_at) < time();
    }
    public function refresh()
    {
        $this->expired_at = date('Y-m-d H:i:s', strtotime('+1 day'));
        return $this->save();
    }
    //delete token
    public function delete()
    {
        return parent::delete();
    }

}