<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
 
</head>

<body>
    <nav class="sidebar">
        <h4 class="text-center">Disaster Management</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#home" onclick="showSection('home')">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#relief" onclick="showSection('relief')">Relief</a></li>
            <li class="nav-item"><a class="nav-link" href="#notifications" onclick="showSection('notifications')">Get Notifications</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact" onclick="showSection('contact')">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="#info" onclick="showSection('info')">Information</a></li>
            <li class="nav-item"><a class="nav-link" href="#data" onclick="showSection('data')">Data</a></li>
            <li class="nav-item"><a class="nav-link" href="#about" onclick="showSection('about')">About</a></li>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="content">
            <div id="home" class="section active">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="date">Select Disaster Date:</label>
                        <input type="date" id="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="disaster-type">Disaster Type:</label>
                        <select id="disaster-type" class="form-control">
                            <option value="all">All</option>
                            <option value="Wildfire">Wildfire</option>
                            <option value="Storm">Storm</option>
                            <option value="Flood">Flood</option>
                            <option value="Earthquake">Earthquake</option>
                            <option value="Volcano">Volcano</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="country">Country:</label>
                        <select id="country" class="form-control">
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
                <div id="map"></div>
            </div>

            <div id="relief" class="section">Relief Information</div>
            <div id="contact" class="section">Contact Details</div>
            <div id="info" class="section">Information Section</div>
            <div id="data" class="section">Data Section</div>
            <div id="about" class="section">About Us</div>

            <div id="notifications" class="section">
                <h3>Subscribe for Notifications</h3>
                <form id="notification-form">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="text" id="mobile" class="form-control" placeholder="Enter mobile number">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter email">
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>

        <footer>
            <p>&copy; 2025 Disaster Management | <a href="https://github.com/Kamal6495" target="_blank">GitHub</a></p>
        </footer>
    </div>
    <script src="assets/js/script.js" defer></script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>
</body>

</html>
