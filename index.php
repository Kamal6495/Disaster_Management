<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Platform</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
</head>

<body>
    <nav class="sidebar">
        <h4 class="text-center">Disaster Management</h4>
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

    <div class="wrapper">
        <div id="content">
            <h2>Loading...</h2>
        </div>

        <footer>
            <p>&copy; 2025 Disaster Management | <a href="https://github.com/Kamal6495" target="_blank">GitHub</a></p>
        </footer>
    </div>

    <script src="assets/js/script.js" defer></script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>
</body>

</html>