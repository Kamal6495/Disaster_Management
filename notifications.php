<!-- notifications.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            background: rgba(30, 30, 60, 0.7);
            border-radius: 20px;
            padding: 40px 30px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
            color: #ffffff;
        }

        label {
            font-weight: 500;
            color: #dddddd;
        }

        input.form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            color: #fff;
            padding: 10px 15px;
            margin-top: 5px;
        }

        input.form-control::placeholder {
            color: #aaa;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #b388eb;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #9a6fe2;
        }

        .btn-success {
            background-color: #7bed9f;
            color: #222;
        }

        .btn-success:hover {
            background-color: #55efc4;
        }

        .btn-danger {
            background-color: #ff7675;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #d63031;
        }

        #otpSection {
            transition: all 0.4s ease;
        }

        #successPopup {
            background: rgba(30, 30, 60, 0.9);
            border-radius: 20px;
            color: #fff;
            border: 2px solid #b388eb;
            text-align: center;
            z-index: 9999;
            padding: 40px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        #successPopup h1 {
            font-size: 3rem;
        }

        #successPopup h3 {
            margin-top: 20px;
        }

        #okButton {
            background-color: #b388eb;
            color: #fff;
            padding: 10px 30px;
            border-radius: 10px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            transition: background 0.3s;
        }

        #okButton:hover {
            background-color: #9a6fe2;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Registration</h2>
    <form id="otpForm">
        <div class="form-group mb-3">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>
        <div class="form-group mb-3">
            <label for="mobile">Mobile number</label>
            <input type="text" class="form-control" id="mobile" placeholder="Enter mobile number" required>
        </div>
        <button type="button" id="sendOtp" class="btn btn-primary">Send OTP</button>

        <div id="otpSection" class="d-none mt-4">
            <div class="form-group mb-3">
                <label for="otp">Enter OTP</label>
                <input type="text" class="form-control" id="otp" placeholder="Enter OTP" required>
            </div>
            <button type="button" id="verifyOtp" class="btn btn-success">Verify OTP</button>
        </div>
    </form>

    <!-- Broadcast Button -->
    <button id="broadcastBtn" class="btn btn-danger mt-4">Send Broadcast Message</button>
</div>

<!-- Popup Success -->
<div id="successPopup" class="d-none position-fixed top-50 start-50 translate-middle bg-white text-center p-5 shadow rounded-4" style="z-index: 1050;">
    <h1>✅</h1>
    <h3 class="mt-3">Your Registration Successful 🎉</h3>
    <button id="okButton" class="btn btn-primary mt-4">OK</button>
</div>



</body>
</html>
