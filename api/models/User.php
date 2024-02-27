<?php

namespace api\models;

use api\models\TypeEmployer;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $name
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property string $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \common\models\User
{
    public function fields()
    {
        return [
            'name',
            'username',
            'company',
            'password_hash',
            'type',
            'phone',
            'access_token',
        ];
    }
    public function getType()
    {
        return $this->hasOne(TypeEmployer::className(), ['id' => 'type_id']);
    }
    public function getCompany()
    {
        return $this->hasMany(Company::className(), ['id' => 'comp_id']);
    }
}
