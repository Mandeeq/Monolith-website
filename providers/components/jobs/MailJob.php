<?php

namespace dashboard\jobs;

use Yii;
use yii\base\BaseObject;
use helpers\traits\Mail;

class MailJob extends BaseObject implements \yii\queue\JobInterface
{
    use Mail;

    public $email;
    public $subject;
    public $body;


    public function execute($queue)
    {
        $date = date('Y-m-d H:i:s');

        if (self::send($this->email, $this->subject, $this->body)) {
            Yii::info("Email sent to {$this->email} at: {$date}", 'mailQueue');
        } else {
            Yii::error("Failed to send email to {$this->email}", 'mailQueue');

            Yii::$app->queue->delay(30)->push(new MailJob([
                'email' => $this->email,
                'subject' => $this->subject,
                'body' => $this->body,
            ]));
        }
    }

    public static function queueEmail($email, $subject, $body)
    {
        $queueu = Yii::$app->queue->push(new \dashboard\jobs\MailJob([
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
        ]));
        Yii::info("Email queued for: {$email}", 'mailQueue');

        if (!$queueu) {
            return false;
        }
        return true;
    }
}
