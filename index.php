<?php
include './assets/key/config.php';
$google_maps_api_key = GOOGLE_MAPS_API_KEY; // Ensure this is defined in config.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Platform</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap" async defer></script> -->

</head>

<body>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <h4>Disaster Management</h4>
        


        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="relief.php">Relief</a></li>
            <li ><a class="nav-link" href="notifications.php">Get Notifications</a></li>
            <li class="nav-item"><a class="nav-link" href="contacts.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="info.php">Knowledge</a></li> 
             <!-- //nedd to be modified every where -->
            <li class="nav-item"><a class="nav-link" href="data.php">Data</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        </ul>
    </nav>

    <!-- Content Section -->
    <div id="content">
        <div class="loading-spinner"></div> <!-- Default loader before home.php loads -->
        <?php include 'home.php'; ?>  <!-- Load home.php initially -->
    </div>

    
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap&loading=async"
        async></script>

    <!-- Load Custom Script After API -->
    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).on("click", "#sendOtp", function () {
            let email = $("#email").val();
            let mobile = $("#mobile").val();

            $.ajax({
                type: "POST",
                url: "ajax/otp-handler.php",
                data: { send_otp: true, email: email, mobile: mobile },
                dataType: "json",
                success: function (response) {
                    if (response.status === "OTP_SENT") {
                        $("#otpSection").removeClass("d-none");
                        $("#sendOtp").hide();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert("Failed to send OTP. Please check the console.");
                }
            });
        });

        $(document).on("click", "#verifyOtp", function () {
            let otp = $("#otp").val();

            $.ajax({
                type: "POST",
                url: "ajax/otp-handler.php",
                data: {
                    verify_otp: true,
                    otp: otp,
                    email: $("#email").val(),
                    mobile: $("#mobile").val()
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "OTP_VERIFIED") {
                        $("body").css("background", "rgba(0,0,0,0.8)");
                        $("#mainContent").hide();
                        $("#successPopup").removeClass("d-none");
                        setTimeout(function () {
                            window.location.href = "index.php?page=home";
                        }, 2000);
                    } else {
                        alert("Invalid OTP. Try again.");
                    }
                }
            });
        });

        // Sidebar toggle for mobile
        document.getElementById("menuToggle").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("active");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>