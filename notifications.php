<?php
session_start();
require 'vendor/autoload.php'; // Load Twilio & PHPMailer

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (leave empty)
$dbname = "users_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Twilio credentials
$twilio_sid    = "your_twilio_sid";
$twilio_token  = "your_twilio_auth_token";
$twilio_number = "+1234567890"; // Your Twilio number

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send Email OTP
function sendEmailOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';
        $mail->Password = 'your-email-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@example.com', 'Your App');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to send SMS OTP via Twilio
function sendSMSOTP($mobile, $otp) {
    global $twilio_sid, $twilio_token, $twilio_number;
    $client = new Client($twilio_sid, $twilio_token);
    try {
        $client->messages->create(
            $mobile, 
            ['from' => $twilio_number, 'body' => "Your OTP code is: $otp"]
        );
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$emailOTPVisible = false;
$mobileOTPVisible = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_email_otp'])) {
        $_SESSION['email_otp'] = generateOTP();
        sendEmailOTP($_POST['email'], $_SESSION['email_otp']);
        echo "<script>alert('Email OTP sent successfully!');</script>";
        $emailOTPVisible = true;
    }

    if (isset($_POST['send_mobile_otp'])) {
        $_SESSION['mobile_otp'] = generateOTP();
        sendSMSOTP($_POST['mobile'], $_SESSION['mobile_otp']);
        echo "<script>alert('Mobile OTP sent successfully!');</script>";
        $mobileOTPVisible = true;
    }

    if (isset($_POST['register'])) {
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $email_otp = $_POST['email_otp'];
        $mobile_otp = $_POST['mobile_otp'];

        if ($email_otp == $_SESSION['email_otp'] && $mobile_otp == $_SESSION['mobile_otp']) {
            // Store in database
            $stmt = $conn->prepare("INSERT INTO users (email, mobile, verified) VALUES (?, ?, 1)");
            $stmt->bind_param("ss", $email, $mobile);
            if ($stmt->execute()) {
                $_SESSION["loggedin"] = true;
                echo "<script>alert('Registration Successful!'); window.location.href='welcome.php';</script>";
            } else {
                echo "<script>alert('User already registered!');</script>";
            }
        } else {
            echo "<script>alert('Invalid OTPs. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Register</h2>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="send_email_otp">Send OTP</button>
        <br><br>
        
        <label>Enter Email OTP:</label>
        <input type="text" name="email_otp" required>
        <br><br>
        
        <label>Mobile Number:</label>
        <input type="tel" name="mobile" pattern="[0-9]{10}" required>
        <button type="submit" name="send_mobile_otp">Send OTP</button>
        <br><br>

        <label>Enter Mobile OTP:</label>
        <input type="text" name="mobile_otp" required>
        <br><br>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>