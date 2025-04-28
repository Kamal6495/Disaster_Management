<?php
include 'assets/key/config.php';
$google_maps_api_key = GOOGLE_MAPS_API_KEY; // Ensure this is defined in config.php
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Platform</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <!-- Top Section -->
        <div class="sidebar-header">
            <img src="images/disaster_logo.jpg" alt="Avatar" class="avatar" style="width: 4cm; height: 4cm;">
            <h5 style="margin-top: 10px;">Disaster Management</h5>

            <!-- Theme Toggle Button -->
            <div class="theme-toggle" title="Toggle Theme">
                <i class="fas fa-moon" id="theme-icon"></i>
            </div>
        </div>

        <!-- Navigation Links -->
        <ul class="nav flex-column mt-4">
            <li class="nav-item"><a class="nav-link load-page" href="home.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="relief.php"><i class="fa fa-hand-holding-heart"></i> Relief</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="notifications.php"><i class="fa fa-bell"></i> Get Notifications</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="contacts.php"><i class="fa fa-address-book"></i> Contact</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="info.php"><i class="fa fa-book"></i> Knowledge</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="data.php"><i class="fa fa-database"></i> Data</a></li>
            <li class="nav-item"><a class="nav-link load-page" href="about.php"><i class="fa fa-info-circle"></i> About</a></li>
        </ul>
        <!-- Bottom Info Card -->
        <!-- <div class="create-teams-card">
            <i class="fa fa-users"></i>
            <h6>Create Teams</h6>
            <p style="font-size: 12px;">Increase your speed with more members</p>
        </div> -->
    </nav>

    <!-- Content Section -->
    <div id="content">
        <div class="loading-spinner"></div> <!-- Default loader before home.php load -->
        <div id="home-content">
            <?php include 'home.php'; ?> <!-- Load home.php initially -->
        </div>
    </div>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap&loading=async" async></script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Theme Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.querySelector('.theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const body = document.body;

            // Load saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                body.classList.add('light-mode');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }

            themeToggle.addEventListener('click', () => {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');
                localStorage.setItem('theme', isLight ? 'light' : 'dark');
                themeIcon.classList.toggle('fa-moon', !isLight);
                themeIcon.classList.toggle('fa-sun', isLight);
            });
        });

        // Broadcast Button
        $(document).on("click", "#broadcastBtn", function() {
            $.ajax({
                url: "send-broadcast.php",
                type: "GET",
                dataType: "text",
                success: function(data) {
                    alert("Broadcast sent:\n" + data);
                },
                error: function(xhr) {
                    alert("Failed to send broadcast. Check console.");
                }
            });
        });

        function syncDisasterData() {
            // Show a quick visual cue (optional)
            const button = event.target;
            button.disabled = true;
            button.innerText = '⏳ Syncing...';

            // Call your PHP script
            fetch('database/fetch_nasa_data.php')
                .then(response => {
                    if (!response.ok) throw new Error('Sync failed');
                    return response.text();
                })
                .then(data => {
                    console.log('Sync successful:', data);
                    // Reload page after sync
                    location.reload();
                })
                .catch(error => {
                    console.error('Error during sync:', error);
                    alert('Sync failed. Please try again.');
                })
                .finally(() => {
                    // Reset button in case of error (optional)
                    button.disabled = false;
                    button.innerText = '🔄 Sync';
                });
        }



        function showSubscribePopup() {
            document.getElementById("subscribePopup").classList.remove("d-none");
        }

        function sendSubscriptionOtp() {
            const email = document.getElementById("subEmail").value.trim();
            const mobile = document.getElementById("subMobile").value.trim();

            if (!email || !mobile) {
                alert("Please enter both email and mobile number.");
                return;
            }

            $.post('ajax/otp-handler.php', {
                send_otp: true,
                email: email,
                mobile: mobile
            }, function(res) {
                let data;
                try {
                    data = JSON.parse(res);
                } catch (e) {
                    alert("Unexpected response from server.");
                    console.error(res);
                    return;
                }

                if (data.status === "OTP_SENT") {
                    alert("✅ OTP sent to Email and Mobile.");
                    document.getElementById("otpSection").classList.remove("d-none");
                } else {
                    alert("❌ Error sending OTP: " + (data.message || ""));
                }
            });
        }

        function verifySubscriptionOtp() {
            const email = document.getElementById("subEmail").value.trim();
            const otp = document.getElementById("subOtp").value.trim();

            if (!email || !otp) {
                alert("Please enter email and OTP.");
                return;
            }

            $.post('ajax/otp-handler.php', {
                verify_otp: true,
                email: email,
                otp: otp
            }, function(res) {
                let data;
                try {
                    data = JSON.parse(res);
                } catch (e) {
                    alert("Unexpected response from server.");
                    console.error(res);
                    return;
                }

                if (data.status === "OTP_VERIFIED") {
                    document.getElementById("subscribePopup").classList.add("d-none");
                    document.getElementById("thankYouPopup").classList.remove("d-none");
                } else {
                    alert("❌ Invalid OTP");
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/script.js"></script>



</body>

</html>