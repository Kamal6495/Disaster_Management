<div class="container">

    <!-- Heading and Logo Row -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Disaster Alert Map</h2>
        <img src="images/logo.jpg" alt="Logo" style="width: 3cm; height: 3cm; object-fit: contain;">
    </div>

    <!-- Gradient Line -->
    <hr style="height: 4px; background: linear-gradient(to right, #ff5252, #ffca28, #66bb6a); border: none; margin: 10px 0;">

    <!-- Dynamic Marquee -->
    <marquee behavior="scroll" direction="left" scrollamount="6"
        style="color: #b71c1c; font-weight: bold; padding: 8px 0;
           background: #fff3e0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <?php
        // DB config
        $conn = new mysqli("localhost", "root", "", "disaster_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch 10 latest alerts
        $sql = "SELECT title, type FROM disaster_alerts ORDER BY timestamp DESC LIMIT 10";
        $result = $conn->query($sql);

        // Icons
        $icons = [
            'earthquake' => '🌍',
            'flood' => '🌊',
            'wildfire' => '🔥',
            'hurricane' => '🌪',
            'volcano' => '🌋',
            'tsunami' => '🌊',
            'storm' => '⛈️',
            'blizzard' => '❄️',
            'rain' => '☔',
            'landslide' => '🪨',
            'default' => '⚠️'
        ];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $type = strtolower($row['type']);
                $icon = $icons[$type] ?? $icons['default'];
                echo "{$icon} {$row['title']} | ";
            }
        } else {
            echo "✅ No current disaster alerts.";
        }
        $conn->close();
        ?>
    </marquee>


    <!-- Map Container -->
    <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>

</div>



<!-- Load Custom Script After API -->
<script src="./assets/js/script.js"></script>

<!-- Horizontal Line Separator -->
<hr style="border: none; height: 20px; background-color: #333; margin: 40px 0;">

<div class="wrapper">
    <!-- INFORMATION SECTION -->
    <div class="container">
        <div class="header text-center">
            <p class="tagline">Nature is beautiful but it can sometimes be disastrous</p>
            <h1>Understanding Disasters</h1>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/tornado.jpg" alt="Tornado">
                    <div class="card-body">
                        <h3>Tornado</h3>
                        <p>A tornado is a rapidly rotating column of air...</p>
                        <a href="./information/tornado.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/hurricane.jpg" alt="Hurricane">
                    <div class="card-body">
                        <h3>Hurricane</h3>
                        <p>In meteorology, a hurricane is a large-scale air mass...</p>
                        <a href="./information/hurricane.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/tsunami.jpg" alt="Tsunami">
                    <div class="card-body">
                        <h3>Tsunami</h3>
                        <a href="./information/tsunami.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/earthquake.jpg" alt="Earthquake">
                    <div class="card-body">
                        <h3>Earthquake</h3>
                        <a href="./information/earthquake.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/flood.jpg" alt="Flood">
                    <div class="card-body">
                        <h3>Flood</h3>
                        <a href="https://www.ready.gov/floods" class="btn btn-primary" target="_blank">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/wildfires.jpg" alt="Wildfire">
                    <div class="card-body">
                        <h3>Wildfire</h3>
                        <a href="./information/wildfires.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/fpre.jpg" alt="Financial Preparedness">
                    <div class="card-body">
                        <h3>Financial Preparedness</h3>
                        <a href="./information/fp.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/kpre.jpg" alt="Youth Preparedness">
                    <div class="card-body">
                        <h3>Youth Preparedness</h3>
                        <a href="./information/yp.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>