


<div class="container">

    <!-- Heading and Logo Row -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Disaster Alert Map</h2>
        <img src="images/logo.jpg" alt="Logo" style="width: 3cm; height: 3cm; object-fit: contain;">
    </div>

    <!-- Gradient Line -->
    <hr style="height: 4px; background: linear-gradient(to right, #ff5252, #ffca28, #66bb6a); border: none; margin: 10px 0;">

    <!-- Dynamic Marquee -->
    <marquee
        behavior="scroll"
        direction="left"
        scrollamount="10"
        onmouseover="this.stop();"
        onmouseout="this.start();"
        style="color: #b71c1c; font-weight: bold; padding: 8px 0;
           background: #fff3e0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: block;">
        <?php
        // DB config
        $conn = new mysqli("localhost", "root", "root", "disaster_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch latest 10 GDACS alerts
        $sql = "SELECT * FROM disaster_gdacs ORDER BY pubDate DESC LIMIT 10";
        $result = $conn->query($sql);

        // Event type icons
        $icons = [
            'Earthquake' => '🌍',
            'Flood' => '🌊',
            'Wildfire' => '🔥',
            'Drought' => '🌾',
            'Storm' => '⛈️',
            'Volcanoes' => '🌋',
            'Tsunami' => '🌊',
            'Blizzard' => '❄️',
            'Landslide' => '🪨',
            'Rain' => '☔',
            'Unknown' => '⚠️'
        ];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $event_type = $row['event_type'];
                $icon = $icons[$event_type] ?? $icons['Unknown'];
                $title = htmlspecialchars($row['title']);
                $desc = htmlspecialchars($row['description']);
                $country = htmlspecialchars($row['country']);
                $link = htmlspecialchars($row['link']);

                echo "<a href='$link' target='_blank' style='text-decoration:none; color:inherit; margin-right: 20px;'>
                    $icon <strong>[$title]</strong>  
                </a> | ";
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

<style>
  .wrapper {
    padding: 3rem 1rem;
    background: linear-gradient(to right, #e0f7fa, #fefefe);
  }

  .header {
    margin-bottom: 3rem;
  }

  .tagline {
    font-size: 1.2rem;
    color: #555;
    font-style: italic;
  }

  .card {
    height: 100%;
    margin: 10px;
    padding: 4px;
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    background: linear-gradient(135deg, limegreen, #1e90ff, crimson);
    background-size: 200% 200%;
    animation: cardGradient 8s ease infinite;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
  }
  .row {
  margin-bottom: 20px !important;
}


  @keyframes cardGradient {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }

  .card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  }

  .card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 0.5rem;
  }

  .card-body {
    padding: 1rem;
    flex: 1;
    background-color: rgba(255, 255, 255, 0.85);
    border-radius: 0.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .card-body h3 {
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: #2c3e50;
    font-weight: bold;
  }

  .btn-primary {
    align-self: flex-start;
    background-color: #007bff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: background-color 0.2s ease;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  @media (max-width: 768px) {
    .card img {
      height: 180px;
    }

    .card-body h3 {
      font-size: 1.25rem;
    }
  }
</style>




<div class="wrapper">
    <!-- INFORMATION SECTION -->
    <div class="container">
        <div class="header text-center">
            <p class="tagline">Nature is beautiful but it can sometimes be disastrous</p>
            <h1>Understanding Disasters</h1>
        </div>

        <div class="row g-4 mb-4">
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

        <div class="row g-4 mb-4">
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

        <div class="row g-4 mb-4">
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

        <div class="row g-4 mb-4">
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