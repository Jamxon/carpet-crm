<?php

namespace api\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
//    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
//            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return array whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $access_token = Yii::$app->security->generateRandomString(32);

            // Create a new AccessToken instance
            $userAccessToken = new AccessToken();
            $userAccessToken->user_id = $user->id;
            $userAccessToken->access_token = $access_token;
            $userAccessToken->expired_at = date('Y-m-d H:i:s', strtotime('+1 day'));

            // Save the AccessToken instance
            if ($userAccessToken->save()) {
                // Update the used_at timestamp
                $userAccessToken->used_at = date('Y-m-d H:i:s');
                $userAccessToken->save();
                // Return token and other necessary information
                $model = ['access_token' => $access_token, 'type_id' => $user->type_id];
                return $model;
            } else {
                // Handle saving failure
                return null;
            }
        }
        return ["Tog'ri jo'nat krisa"];
    }

// Function to delete expired tokens
    public function deleteExpiredTokens()
    {
        $expiredTokens = AccessToken::find()->where(['<', 'expired_at', date('Y-m-d H:i:s')])->all();
        foreach ($expiredTokens as $token) {
            $token->delete();
        }
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
