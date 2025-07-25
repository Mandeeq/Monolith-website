<?php

namespace auth\models\static;

use Yii;
use yii\base\Model;
use auth\models\User;
use auth\models\Tokens;


class PasswordReset extends Model
{
    public $password;
    public $confirm_password;
    public $token;

    private $_user;
    private $_token;

    public function __construct($user = null, $token = null, $config = [])
    {
        $this->_user = $user;
        $this->_token = $token;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            ['password', 'string', 'min' => 4],
            [
                'password',
                'match',
                'pattern' => '/^\S*(?=\S*[\W])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
                'message' => 'Password should contain at least: 1 number, 1 lowercase letter, 1 uppercase letter, and 1 special character'
            ],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            // ['token', 'validateToken'],
        ];
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->token) {
            $this->addError($attribute, 'Password reset token cannot be blank.');
            return;
        }

        $this->_token = Tokens::findOne(['token' => $this->token, 'token_type' => 'password_reset_token', /*'status' => 1*/]);
        if (!$this->_token || !$this->isPasswordResetTokenValid($this->_token->token)) {
            $this->addError($attribute, 'Invalid or expired password reset token.');
            return;
        }

        $this->_user = User::findOne(['user_id' => $this->_token->user_id, 'status' => User::STATUS_ACTIVE]);
        if (!$this->_user) {
            $this->addError($attribute, 'User associated with this token was not found or is inactive.');
        }
    }

    public function validateAndFetchUserByToken($token)
    {
        if (!$token) {
            return ['error' => 'Password reset token cannot be blank.'];
        }

        $this->_token = Tokens::findOne([
            'token' => $token,
            'token_type' => 'password_reset_token'
        ]);

        if (!$this->_token || !$this->isPasswordResetTokenValid($this->_token->token)) {
            return ['error' => 'Invalid or expired password reset token.'];
        }

        $this->_user = User::findOne([
            'user_id' => $this->_token->user_id,
            'status' => User::STATUS_ACTIVE
        ]);

        if (!$this->_user) {
            return ['error' => 'User associated with this token was not found or is inactive.'];
        }

        return [
            'user' => $this->_user,
            'token' => $this->_token
        ];
    }


    public function isPasswordResetTokenValid($token)
    {
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function resetPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        if (!$this->_user || !$this->_token) {
            return false;
        }

        $this->_user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        return $this->_user->save(false);
        // if ($this->_user->save()) {
        //     // Invalidate the token by setting its status to 0
        //     // $this->_token->status = 0;
        //     return $this->_token->save();
        // }

        // return false;
    }
}
