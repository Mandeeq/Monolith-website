<?php

namespace auth\models\static;

use Yii;
use yii\base\Model;
use auth\models\User;
use auth\models\Profiles;
use auth\models\Tokens;
// use dashboard\jobs\MailJob;
use yii\helpers\Url;
use helpers\traits\Mail;

class PasswordResetRequest extends Model
{

    use Mail;

    public $username;
    // public $trading_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string'],
            [
                'username',
                'exist',
                'targetClass' => '\auth\models\User',
                'targetAttribute' => ['username' => 'username'],
                'message' => 'The provided username or email does not exist.'
            ],

        ];
    }

    public function sendEmail()
    {

        $userId = User::find()->select('user_id')->where([
            'username' => $this->username,
            'status' => User::STATUS_ACTIVE
        ])->scalar();

        if (!$userId) {
            return false;
        }

        $email = Profiles::findOne([
            'user_id' => $userId,
        ]);

        if (!$email) {
            return false;
        }

        $password_reset_token = Yii::$app->security->generateRandomString(7) . '_' . time();

        $tokens = new Tokens();
        $tokens->user_id = $userId;
        $tokens->token = $password_reset_token;
        $tokens->token_type = 'password_reset_token';
        $tokens->token_id = $tokens->uid('TOKENS', true);
        $tokens->save();

        $resetLink = Yii::$app->request->hostInfo . Url::to(['/dashboard/iam/reset-password', 'token' => $password_reset_token]);

        $subject = 'Password Reset Request';

        $body = Yii::$app->view->render('@ui/views/mails/password_reset', [
            'username' => $this->username,
            'resetLink' => $resetLink,
        ]);

        // if(self::send($email->email_address, $subject, $body)){
        //     return true;
        // }
        return self::send($email->email_address, $subject, $body);

        // return false;
    }
}
