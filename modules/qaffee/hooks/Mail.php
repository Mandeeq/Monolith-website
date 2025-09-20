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
            'host' =>  'smtp.gmail.com',
            'username' => 'imanjamal370@gmail.com',
            'password' => 'emra xudt xlft zmab',
            'port' => 465,
            'encryption' => 'ssl',
        ]);
        // $this->setTransport([
        //     'scheme' => 'smtps',
        //     'host' => Yii::$app->config->get('smtp_host') ?? 'smtp.gmail.com',
        //     'username' => Yii::$app->config->get('smtp_user'),
        //     'password' => Yii::$app->config->get('smtp_password'),
        //     'port' => (int) Yii::$app->config->get('smtp_port'),
        //     'encryption' => Yii::$app->config->get('email_encryption'),
        // ]);
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

            $to = "imanjamal370@gmail.com";
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
                Yii::debug("Contact email sending failed for: " . $to, 'contact');
                Yii::error("Contact email sending failed for: " . $to, 'contact');
            }

            return $result;
        } catch (\Exception $e) {
            Yii::error("Failed to send contact email: " . $e->getMessage(), 'contact');
            Yii::error("Exception trace: " . $e->getTraceAsString(), 'contact');
            return false;
        }
    }
    public function sendConfirmationEmail($name, $email, $subject, $message)
    {
        try {
            Yii::info("Starting confirmation email send process for: " . $email, 'contact');

            $mailData = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ];

            $result = $this->sendEmail($email, 'Thank You for Contacting Qaffee', 'confirmation', $mailData);

            if ($result) {
                Yii::info("Confirmation email sent successfully to: " . $email, 'contact');
            } else {
                Yii::error("Confirmation email sending failed for: " . $email, 'contact');
            }

            return $result;
        } catch (\Exception $e) {
            Yii::error("Failed to send confirmation email: " . $e->getMessage(), 'contact');
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
                ->setFrom(['imanjamal370@gmail.com' => 'Iman Jamal']) // Use a valid sender email

                ->setReplyTo($data['email']) // Set reply-to as the sender's email
                ->setSubject($subject)
                ->send();
        } catch (\Exception $e) {
            return false;
        }
    }
}
