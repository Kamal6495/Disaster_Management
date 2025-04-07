<!-- notifications.php -->
<div class="container mt-5">
    <h2 class="mb-4">OTP Verification</h2>
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
</div>

<!-- Popup Success -->
<div id="successPopup" class="d-none position-fixed top-50 start-50 translate-middle bg-white text-center p-5 shadow rounded-4" style="z-index: 1050;">
    <h1>✅</h1>
    <h3 class="mt-3">Your Registration Successful 🎉</h3>
    <button id="okButton" class="btn btn-primary mt-4">OK</button>
</div>


<!-- 
<script>
    $(document).ready(function () {
        $("#sendOtp").click(function () {
            
            const email = $("#email").val();
            const mobile = $("#mobile").val();

            if (email === "" || mobile === "") {
                alert("Please fill both fields.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "/ajax/otp-handler.php",
                data: { send_otp: true, email: email, mobile: mobile },
                dataType: "json",
                success: function (response) {
                    if (response.status === "OTP_SENT") {
                        
                        $("#otpSection").removeClass("d-none");
                        $("#sendOtp").hide();
                        console.log("OTP sent to email and mobile.");
                    } else {
                        alert("Failed to send OTP: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Failed to send OTP. Please check the console.");
                }
            });
        });

        $("#verifyOtp").click(function () {
            const email = $("#email").val();
            const mobile = $("#mobile").val();
            const otp = $("#otp").val();

            if (otp === "") {
                alert("Please enter the OTP.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "/ajax/otp-handler.php",
                data: { verify_otp: true, email: email, mobile: mobile, otp: otp },
                dataType: "json",
                success: function (response) {
                    if (response.status === "OTP_VERIFIED") {
    // Hide everything except the success popup
    $("body > *").not("#successPopup").hide();
    $("#successPopup").removeClass("d-none");

    // Set background to plain white
    $("body").css("background", "#fff");

    // Redirect to home.php when OK button is clicked
    $("#okButton").click(function () {
        window.location.href = "home.php";
    });
}

 else {
                        alert("Invalid OTP. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Failed to verify OTP.");
                }
            });
        });
    });
</script> -->
