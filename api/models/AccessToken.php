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
            [['expired_at'], 'safe'],
            [['access_token'], 'string', 'max' => 32],
            [['access_token'], 'unique'],
        ];
    }
}