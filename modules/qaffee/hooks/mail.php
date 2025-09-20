<?php
namespace qaffee\hooks;

use Yii;
use yii\symfonymailer\Mailer;

class Mail extends Mailer
{
    public $useFileTransport = false;
    public $_transport;

    public function init()
    {
        $this->setTransport([
            'scheme' => 'smtps',
            'host' => Yii::$app->config->get('smtp_host') ?? 'smtp.gmail.com',
            'username' => Yii::$app->config->get('smtp_user'),
            'password' => Yii::$app->config->get('smtp_password'),
            'port' => (int) Yii::$app->config->get('smtp_port'),
            'encryption' => Yii::$app->config->get('email_encryption'),
        ]);
        parent::init();
    }

    /**
     * Sends a contact form email to the admin
     * @param string $name Sender's name
     * @param string $email Sender's email
     * @param string $subject Email subject
     * @param string $message Message content
     * @return bool Whether the email was sent successfully
     */
    public function sendContactEmail($name, $email, $subject, $message)
    {
        try {
            Yii::info("Starting contact email send process for: " . $email, 'contact');
            
            $to = Yii::$app->config->get('admin_email') ?? 'admin@qaffee.com';
            $mailData = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ];

            $result = $this->sendEmail($to, $subject, 'contact', $mailData);

            if ($result) {
                Yii::info("Contact email sent successfully to: " . $to, 'contact');
            } else {
                Yii::error("Contact email sending failed for: " . $to, 'contact');
            }

            return $result;

        } catch (\Exception $e) {
            Yii::error("Failed to send contact email: " . $e->getMessage(), 'contact');
            Yii::error("Exception trace: " . $e->getTraceAsString(), 'contact');
            return false;
        }
    }

    /**
     * Sends an email using the specified template and data
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $template Email template name
     * @param array $data Data to pass to the template
     * @return bool Whether the email was sent successfully
     */
    protected function sendEmail($to, $subject, $template, $data)
    {
        try {
            return $this->compose($template, ['data' => $data])
                ->setTo($to)
                ->setFrom([Yii::$app->config->get('sender_email') => Yii::$app->name])
                ->setReplyTo($data['email']) // Set reply-to as the sender's email
                ->setSubject($subject)
                ->send();
        } catch (\Exception $e) {
            return false;
        }
    }
}