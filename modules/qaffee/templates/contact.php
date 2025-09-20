<?php
use yii\helpers\Html;
/** @var array $data */
$name = $data['name'];
$email = $data['email'];
$subject = $data['subject'];
$message = $data['message'];
?>

<h2>New Contact Form Submission</h2>
<p><strong>Name:</strong> <?= Html::encode($name) ?></p>
<p><strong>Email:</strong> <?= Html::encode($email) ?></p>
<p><strong>Subject:</strong> <?= Html::encode($subject) ?></p>
<p><strong>Message:</strong></p>
<p><?= nl2br(Html::encode($message)) ?></p>
<p><em>Please reply directly to the sender's email address.</em></p>