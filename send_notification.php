<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;

$conn = new mysqli("localhost", "root", "", "users_db");

$result = $conn->query("SELECT email, mobile FROM users WHERE verified=1");

while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $mobile = $row['mobile'];

    // Send Email Reminder
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com';
    $mail->Password = 'your-email-password';
    $mail->setFrom('your-email@example.com', 'Your App');
    $mail->addAddress($email);
    $mail->Subject = "Daily Reminder";
    $mail->Body = "Hello, this is your daily notification!";
    $mail->send();

    // Send SMS Reminder
    $twilio = new Client("your_twilio_sid", "your_twilio_auth_token");
    $twilio->messages->create($mobile, [
        'from' => "+1234567890",
        'body' => "Hello! This is your daily reminder."
    ]);
}
?>
