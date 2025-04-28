<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/plain");

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Include Twilio and PHPMailer config
include __DIR__ . '/assets/key/config.php';

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize Twilio
$twilio = new Client($account_sid, $auth_token);

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "root", "disaster_db");
if ($mysqli->connect_error) {
    http_response_code(500);
    die("Database Connection Error: " . $mysqli->connect_error);
}

// Fetch the last row from disaster_gdacs
$disaster_result = $mysqli->query("SELECT * FROM disaster_gdacs ORDER BY id DESC LIMIT 1");
if (!$disaster_result || $disaster_result->num_rows === 0) {
    die("No disaster data found.");
}
$disaster = $disaster_result->fetch_assoc();

// Prepare message content
$message_body = "📢 Disaster Alert!\n";
$message_body .= "Title: " . $disaster['title'] . "\n";
$message_body .= "Description: " . $disaster['description'] . "\n";
$message_body .= "Date: " . $disaster['pubDate'] . "\n";

// Fetch users
$user_result = $mysqli->query("SELECT email, mobile FROM users WHERE (mobile IS NOT NULL AND mobile != '') OR (email IS NOT NULL AND email != '')");
$response = [];

// Setup PHPMailer
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Change if needed
    $mail->SMTPAuth = true;
    $mail->Username = 'kamal.2024cs12@mnnit.ac.in'; // Change to your email
    $mail->Password = $app_pwd; // Use App Password if 2FA enabled
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('kamal.2024cs12@mnnit.ac.in', 'Disaster Alert');
} catch (Exception $e) {
    die('Mailer Setup Error: ' . $e->getMessage());
}

// Loop through users
while ($user = $user_result->fetch_assoc()) {
    $mobile = $user['mobile'];
    $email = $user['email'];

    // Send SMS if mobile is valid
    if (!empty($mobile) && preg_match('/^\+?[1-9]\d{9,14}$/', $mobile)) {
        try {
            $twilio->messages->create($mobile, [
                'from' => $twilio_number,
                'body' => $message_body
            ]);
            $response[] = "✅ SMS sent to: $mobile";
        } catch (Exception $e) {
            $response[] = "❌ SMS failed to $mobile: " . $e->getMessage();
        }
    } elseif (!empty($mobile)) {
        $response[] = "⚠️ Invalid mobile format: $mobile";
    }

    // Send Email if email exists
    if (!empty($email)) {
        try {
            $mail->clearAddresses();
            $mail->addAddress($email);
            $mail->Subject = '📢 Disaster Alert Notification';
            $mail->Body = $message_body;
            $mail->send();
            $response[] = "✅ Email sent to: $email";
        } catch (Exception $e) {
            $response[] = "❌ Email failed to $email: " . $mail->ErrorInfo;
        }
    }
}

echo implode("\n", $response);
