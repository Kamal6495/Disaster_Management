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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap" async defer></script>

</head>

<body>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <h4>Disaster Management</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="relief.php">Relief</a></li>
            <li class="nav-item"><a class="nav-link" href="notifications.php">Get Notifications</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="info.php">Information</a></li>
            <li class="nav-item"><a class="nav-link" href="data.php">Data</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        </ul>
    </nav>

    <!-- Content Section -->
    <div id="content">
        <div class="loading-spinner"></div> <!-- Default loader before home.php loads -->
    </div>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap&loading=async"
        async></script>

    <!-- Load Custom Script After API -->
    <script src="./assets/js/script.js"></script>

</body>

</html>