<?php
session_start();
require './vendor/autoload.php'; // Load Twilio & PHPMailer
require './assets/key/config.php';

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "disaster_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("ERROR: Database connection failed: " . $conn->connect_error);
}

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send Email OTP
function sendEmailOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Update with correct SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your SMTP username
        $mail->Password = 'your-email-password'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@example.com', 'Your App');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        $mail->send();
        return "EMAIL_SENT";
    } catch (Exception $e) {
        return "EMAIL_ERROR: " . $mail->ErrorInfo;
    }
}

// Function to send SMS OTP via Twilio
function sendSMSOTP($mobile, $otp) {
    global $twilio_sid, $twilio_token, $twilio_number;
    $client = new Client($twilio_sid, $twilio_token);
    try {
        $client->messages->create($mobile, ['from' => $twilio_number, 'body' => "Your OTP code is: $otp"]);
        return "SMS_SENT";
    } catch (Exception $e) {
        return "SMS_ERROR: " . $e->getMessage();
    }
}

// Handling Send OTP Request
if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $mobile = "+91" . ltrim($_POST['mobile'], '0');
    $otp = generateOTP();

    // Store OTP in the database
    $stmt = $conn->prepare("INSERT INTO users (email, mobile, otp) VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE otp = ?");
    $stmt->bind_param("ssii", $email, $mobile, $otp, $otp);

    if ($stmt->execute()) {
        $email_status = sendEmailOTP($email, $otp);
        $sms_status = sendSMSOTP($mobile, $otp);
        
        echo json_encode(["status" => "OTP_SENT", "email" => $email_status, "sms" => $sms_status]);
    } else {
        echo json_encode(["status" => "ERROR", "message" => "Failed to store OTP"]);
    }
    exit();
}

// Handling Verify OTP Request
if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    $stmt = $conn->prepare("SELECT otp FROM users WHERE email = ? OR mobile = ?");
    $stmt->bind_param("ss", $_POST['email'], $_POST['mobile']);
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
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/css/styleN.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; transition: background 0.5s; }
        .container { text-align: center; margin-top: 50px; }
        .popup { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                 background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
                 text-align: center; z-index: 1000; }
        .popup img { width: 80px; height: 80px; }
        .popup h3 { font-size: 24px; margin: 10px 0; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="container" id="mainContent">
        <h2>Register</h2>
        <form id="otpForm">
            <label>Email:</label>
            <input type="email" id="email" name="email" required>

            <label>Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" required>

            <button type="button" id="sendOtp">Send OTP</button>

            <div id="otpSection" class="hidden">
                <label>Enter OTP:</label>
                <input type="text" id="otp" name="otp" required>
                <button type="button" id="verifyOtp">Verify OTP</button>
            </div>
        </form>
    </div>

    <!-- Success Popup -->
    <div id="successPopup" class="popup">
        <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Success">
        <h3>Your Registration is Successful! 🎉</h3>
        <p>Redirecting to Dashboard...</p>
    </div>

    <script>
        $(document).ready(function () {
            $("#sendOtp").click(function () {
                var email = $("#email").val();
                var mobile = $("#mobile").val();

                $.ajax({
                    type: "POST",
                    url: "notifications.php", // Ensure this matches your PHP file
                    data: { send_otp: true, email: email, mobile: mobile },
                    dataType: "json",
                    success: function (response) {
                        console.log("Response:", response);
                        if (response.status === "OTP_SENT") {
                            $("#otpSection").show();
                            $("#sendOtp").hide();
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error("Server Response:", xhr.responseText);
                        alert("An error occurred. Check console for details.");
                    }
                });
            });

            $("#verifyOtp").click(function () {
                var otp = $("#otp").val();

                $.ajax({
                    type: "POST",
                    url: "notifications.php",
                    data: { verify_otp: true, otp: otp, email: $("#email").val(), mobile: $("#mobile").val() },
                    dataType: "json",
                    success: function (response) {
                        console.log("Response:", response);
                        if (response.status === "OTP_VERIFIED") {
                            $("body").css("background", "rgba(0, 0, 0, 0.8)");
                            $("#mainContent").hide();
                            $("#successPopup").fadeIn(500);
                            setTimeout(function () {
                                window.location.href = "dashboard.php";
                            }, 2000);
                        } else {
                            alert("Invalid OTP. Please try again.");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
