<?php
/**
 * @var array $data
 * $data contains:
 *   - email   (recipient)
 *   - subject (email subject)
 *   - message (custom message passed in)
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['subject']) ?></title>
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
        <h2>Confirmation</h2>
        <p>Hello,</p>
        <p><?= nl2br(htmlspecialchars($data['message'])) ?></p>

        <p>If you did not request this email, please ignore it.</p>

        <div class="footer">
            &copy; <?= date('Y') ?> Qaffee App. All rights reserved.
        </div>
    </div>
</body>
</html>
