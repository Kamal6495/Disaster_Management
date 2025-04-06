<?php
session_start();
require '../vendor/autoload.php';
require '../assets/key/config.php';

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// DB connection
$conn = new mysqli("localhost", "root", "", "disaster_db");
if ($conn->connect_error) {
    die(json_encode(["status" => "ERROR", "message" => "DB connection failed."]));
}

function generateOTP() {
    return rand(100000, 999999);
}

function sendEmailOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // ✅ Replace with actual SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // ✅ Replace with actual email
        $mail->Password = 'your-password'; // ✅ Replace with actual password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@example.com', 'Disaster Alert');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        $mail->send();
        return "EMAIL_SENT";
    } catch (Exception $e) {
        return "EMAIL_ERROR: " . $mail->ErrorInfo;
    }
}

function sendSMSOTP($mobile, $otp) {
    global $twilio_sid, $twilio_token, $twilio_number;
    $client = new Client($twilio_sid, $twilio_token);
    try {
        $client->messages->create($mobile, [
            'from' => $twilio_number,
            'body' => "Your OTP is: $otp"
        ]);
        return "SMS_SENT";
    } catch (Exception $e) {
        return "SMS_ERROR: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];

    if (isset($_POST['send_otp'])) {
        $email = $_POST['email'];
        $mobile = "+91" . ltrim($_POST['mobile'], '0');
        $otp = generateOTP();

        $stmt = $conn->prepare("INSERT INTO users (email, mobile, otp) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE otp = ?");
        $stmt->bind_param("ssii", $email, $mobile, $otp, $otp);

        if ($stmt->execute()) {
            $response = [
                "status" => "OTP_SENT",
                "email" => sendEmailOTP($email, $otp),
                "sms" => sendSMSOTP($mobile, $otp)
            ];
        } else {
            $response = ["status" => "ERROR", "message" => "Failed to store OTP"];
        }

        echo json_encode($response);
        exit;
    }

    if (isset($_POST['verify_otp'])) {
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $otp = $_POST['otp'];

        $stmt = $conn->prepare("SELECT otp FROM users WHERE email = ? OR mobile = ?");
        $stmt->bind_param("ss", $email, $mobile);
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
?>
