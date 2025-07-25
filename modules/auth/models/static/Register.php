<?php

namespace auth\models\static;

use Yii;
use yii\base\Model;
use auth\models\User;
use auth\models\Profiles;
use helpers\traits\Keygen;
use auth\models\Tokens;


class Register extends Model
{
    public $username;
    public $password;
    public $confirm_password;
    public $email_address;
    public $mobile_number;


    public function rules()
    {
        return [
            [['username', 'email_address'], 'trim'],
            [['username', 'email_address', 'mobile_number', 'password', 'confirm_password'], 'required'],

            ['username', 'unique', 'targetClass' => User::class, 'message' => 'An account with similar username already exists.'],
            [['email_address', 'username'], 'string', 'max' => 128],
            [['email_address'], 'email'],

            ['password', 'string', 'min' => 8],
            [
                'password',
                'match',
                'pattern' => '/^\S*(?=\S*[\W])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
                'message' => 'Password should contain at least: 1 number, 1 lowercase, 1 uppercase letter and 1 special character'
            ],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],

            [['mobile_number'], 'validateMobileNumber', 'skipOnEmpty' => false],
            [['username'], 'validateName', 'skipOnEmpty' => false]
        ];
    }
    public function validateMobileNumber($attribute, $params)
    {
        $pattern = '/^(07|01|\+2547|\+2541)[0-9]{8}$/';

        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'Invalid phone number');
        }
    }

    public function validateName($attribute, $params)
    {
        $name = $this->$attribute;

        if (!preg_match("/^[a-zA-Z']+$/", $name)) {
            $this->addError($attribute, 'The name can only contain alphabetic characters');
        }

        if (preg_match('/(.)\1{2,}/', $name)) {
            $this->addError($attribute, 'The name cannot contain three or more consecutive identical characters.');
        }
    }
    public function save()
    {
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save(false)) {
            return $user;
        }
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $uid = $this->uid('USERS', true);
        $user = new User();
        $user->user_id = $uid;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->status = User::STATUS_INACTIVE;
        $user->generateAuthKey();

        if (!$user->save()) {
            return false;
        }

        // Create Profile
        $profile = new Profiles();
        $profile->user_id = $user->user_id;
        $profile->first_name = '';
        $profile->middle_name = '';
        $profile->last_name = '';
        $profile->full_name = '';

        $profile->email_address = $this->email_address;
        $profile->mobile_number = $this->mobile_number;

        if (!$profile->save(false)) {
            $user->delete();
            return false;
        }

        // Assign Role
        $auth = Yii::$app->authManager;
        $defaultRole = $auth->getRole('user');
        if ($defaultRole) {
            $auth->assign($defaultRole, $user->user_id);
        }

        // Generate Email Verification Token
        $tokens = new Tokens();
        $tokens->user_id = $user->user_id;
        $tokens->token = Yii::$app->security->generateRandomString(32);
        $tokens->token_type = 'email_verification_token';
        $tokens->token_id = $tokens->uid('TOKENS', true);

        if (!$tokens->save(false)) {
            $user->delete();
            return false;
        }

        // Send Verification Email
        $verificationLink = Yii::$app->urlManager->createAbsoluteUrl([
            'iam/verify-email',
            'token' => $tokens->token
        ]);

        $subject = 'Verify Your Email Address';
        $body = Yii::$app->view->render('@ui/views/emails/email_verification', [
            'username' => $this->username,
            'verificationLink' => $verificationLink,
        ]);

        // if (!self::send($this->email_address, $subject, $body)) {
        //     return false;
        // }

        return true;
    }
}
