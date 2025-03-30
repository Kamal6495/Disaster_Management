<?php
require_once 'assets/key/config.php'; // Load API Keys
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            width: 100%;
        }

        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <h4 class="text-center">Disaster Management</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="relief.php">Relief</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="info.php">Information</a></li>
            <li class="nav-item"><a class="nav-link" href="data.php">Data</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div class="content">
        <!-- Filters -->
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

        <!-- Map Section -->
        <div id="map"></div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2025 Disaster Management | <a href="https://github.com/Kamal6495" target="_blank"
                    style="color: white;">GitHub</a></p>
        </footer>
    </div>

    <!-- Load Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>

    <script>
        let map;
        let markers = [];
        let countryCache = {}; // Cache for country lookups

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 3,
                center: { lat: 20.5937, lng: 78.9629 } // Centered around India
            });

            loadDisasterDates();
            loadDisasterData();

            // Event Listeners
            document.getElementById("date").addEventListener("change", loadDisasterData);
            document.getElementById("disaster-type").addEventListener("change", loadDisasterData);
            document.getElementById("country").addEventListener("change", loadDisasterData);
        }

        function loadDisasterData() {
            let selectedDate = document.getElementById("date").value;
            let selectedType = document.getElementById("disaster-type").value;
            let selectedCountry = document.getElementById("country").value;

            fetch(`database/get_disasters.php?date=${selectedDate}&type=${selectedType}&country=${selectedCountry}`)
                .then(response => response.json())
                .then(data => {
                    clearMarkers();
                    updateCountryDropdown(data);

                    let bounds = new google.maps.LatLngBounds();
                    let hasData = false;

                    data.forEach(disaster => {
                        let severityColor = getColor(disaster.severity);
                        let position = { lat: parseFloat(disaster.latitude), lng: parseFloat(disaster.longitude) };

                        let marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: disaster.disaster_type,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 10,
                                fillColor: severityColor,
                                fillOpacity: 0.8,
                                strokeWeight: 1
                            }
                        });

                        let infoWindow = new google.maps.InfoWindow({
                            content: `<b>${disaster.disaster_type}</b><br>
                              <b>Category:</b> ${disaster.category}<br>
                              <b>Severity:</b> ${disaster.severity}<br>
                              <b>Timestamp:</b> ${disaster.timestamp}<br>
                              <b>Country:</b> ${disaster.country || "Unknown"}<br>
                              <a href="${disaster.source_url}" target="_blank">More Info</a>`
                        });

                        marker.addListener("click", () => infoWindow.open(map, marker));
                        markers.push(marker);
                        bounds.extend(position);
                        hasData = true;
                    });

                    if (hasData) {
                        map.fitBounds(bounds);
                    }
                })
                .catch(error => console.error("Error fetching disaster data:", error));
        }

        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        function getColor(severity) {
            return {
                "Extreme": "red",
                "Severe": "orange",
                "Moderate": "yellow",
                "Low": "green"
            }[severity] || "blue";
        }

        function updateCountryDropdown(data) {
            let countryDropdown = document.getElementById("country");
            let uniqueCountries = [...new Set(data.map(d => d.country).filter(Boolean))];

            countryDropdown.innerHTML = '<option value="all">All</option>' + 
                uniqueCountries.map(country => `<option value="${country}">${country}</option>`).join('');
        }

        function loadDisasterDates() {
            fetch("database/get_disaster_dates.php")
                .then(response => response.json())
                .then(dates => {
                    let dateInput = document.getElementById("date");
                    let dateSet = new Set(dates);
                    
                    dateInput.setAttribute("min", dates[dates.length - 1]);
                    dateInput.setAttribute("max", dates[0]);

                    dateInput.addEventListener("input", function() {
                        if (!dateSet.has(this.value)) {
                            alert("No disaster recorded on this date!");
                            this.value = "";
                        }
                    });

                    dateInput.style.backgroundColor = "#ffcccc";
                })
                .catch(error => console.error("Error loading disaster dates:", error));
        }
    </script>

</body>
</html>
