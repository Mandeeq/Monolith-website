<?php
/** @var array $data */
$name = $data['name'];
$email = $data['email'];
$subject = $data['subject'];
$message = $data['message'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thank You for Contacting Qaffee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Thank You, <?= htmlspecialchars($name) ?>!</h2>
        <p>We have received your message and will get back to you soon.</p>
        <p><strong>Your Submission Details:</strong></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($subject) ?></p>
        <p><strong>Message:</strong></p>
        <p><?= nl2br(htmlspecialchars($message)) ?></p>
        <p>If you have any further questions, feel free to reply to this email or contact us at support@qaffee.com.</p>
        <div class="footer">
            &copy; <?= date('Y') ?> Qaffee Restaurant. All rights reserved.
        </div>
    </div>
</body>
</html>