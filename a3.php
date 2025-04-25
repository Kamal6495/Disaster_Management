<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // Full debug
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jolly6014@gmail.com';
    $mail->Password = 'your_app_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('charlie64956024@gmail.com', 'Test Sender');
    $mail->addAddress('jolly6014@gmail.com'); // Replace with your test email

    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email via PHPMailer';

    $mail->send();
    echo 'Email sent!';
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
