<?php

namespace api\modules\v1\models;

use api\models\Customer;
use common\models\Customer_token;
use yii\base\Model;

class Login extends Model
{
    public $phone;
    public $password;

    private $_user = false;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['phone', 'string', 'max' => 15],
            ['password', 'string', 'max' => 255],
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $access_token = \Yii::$app->security->generateRandomString(32);
            $accessToken = new Customer_token();
            $accessToken->user_id = $user->id;
            $accessToken->access_token1 = $access_token;
            if ($accessToken->save()) {
                return [
                    'id' => $user->id,
                    'access_token' => $access_token,
                ];
            } else {
                return $accessToken->getErrors();
            }
        } else {
            return $this->getErrors();
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = (new \api\models\Customer)->findByPhone($this->phone);
        }
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Phone',
            'password' => 'Password',
        ];
    }

    public function fields()
    {
        return [
            'phone' => 'phone',
            'password' => 'password',
        ];
    }

}