<?php
session_start();
require '../vendor/autoload.php';
require '../assets/key/config.php'; // Loads: $twilio_sid, $twilio_token, $twilio_number, $app_pwd, DB credentials

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// DB connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["status" => "ERROR", "message" => "DB connection failed."]));
}

function generateOTP()
{
    return rand(100000, 999999);
}

function sendEmailOTP($to, $otp)
{
    global $app_pwd;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kamal.2024cs12@mnnit.ac.in'; // Change if needed
        $mail->Password   = $app_pwd;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('kamal.2024cs12@mnnit.ac.in', 'MNNIT Disaster Alert');
        $mail->addAddress($to);
        $mail->Subject = "Your OTP for MNNIT Disaster Alert";
        $mail->Body    = "Your OTP is: $otp";

        $mail->send();
        return "EMAIL_SENT";
    } catch (Exception $e) {
        return "EMAIL_FAILED: " . $mail->ErrorInfo;
    }
}

function sendSMSOTP($to, $otp)
{
    global $twilio_sid, $twilio_token, $twilio_number;

    // Ensure E.164 format
    if (!preg_match('/^\+/', $to)) {
        $to = '+91' . ltrim($to, '0'); // Assumes Indian number if no country code
    }

    try {
        $twilio = new Client($twilio_sid, $twilio_token);
        $twilio->messages->create(
            $to,
            [
                'from' => $twilio_number,
                'body' => "Your OTP for MNNIT Disaster Alert is: $otp"
            ]
        );
        return "SMS_SENT";
    } catch (Exception $e) {
        return "SMS_FAILED: " . $e->getMessage();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $email  = $_POST['email'];
        $mobile = $_POST['mobile'];

        // Always ensure +91 prefix before storing
        $mobile = preg_replace('/[^0-9]/', '', $mobile); // remove non-digits
        if (strlen($mobile) == 10) {
            $mobile = '+91' . $mobile;
        } elseif (!preg_match('/^\+/', $mobile)) {
            $mobile = '+91' . ltrim($mobile, '0');
        }

        $otp    = generateOTP();

        // Store or update user entry
        $stmt = $conn->prepare("INSERT INTO users (email, mobile, otp) VALUES (?, ?, ?)
                                ON DUPLICATE KEY UPDATE mobile = VALUES(mobile), otp = VALUES(otp)");
        $stmt->bind_param("ssi", $email, $mobile, $otp);

        if ($stmt->execute()) {
            $emailStatus = sendEmailOTP($email, $otp);
            $smsStatus   = sendSMSOTP($mobile, $otp);

            echo json_encode([
                "status" => "OTP_SENT",
                "email_status" => $emailStatus,
                "sms_status" => $smsStatus
            ]);
        } else {
            echo json_encode(["status" => "ERROR", "message" => "Failed to store OTP"]);
        }
        exit;
    }

    if (isset($_POST['verify_otp'])) {
        $email = $_POST['email'];
        $otp   = $_POST['otp'];

        $stmt = $conn->prepare("SELECT otp FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($stored_otp);
        $stmt->fetch();
        $stmt->close();

        if ($otp == $stored_otp) {
            $_SESSION['otp_verified'] = true;
            echo json_encode(["status" => "OTP_VERIFIED"]);
        } else {
            echo json_encode(["status" => "INVALID_OTP"]);
        }
        exit;
    }
}
