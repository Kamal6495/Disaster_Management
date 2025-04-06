<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Historical Disaster Data</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f4f4f4;
        }

        .header {
            background: linear-gradient(to right,rgb(54, 125, 155),rgb(2, 192, 255), #2c5364);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
        }

        .header p {
            font-size: 18px;
            margin-top: 10px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 50px 20px;
            gap: 30px;
        }

        .card {
            width: 330px;
            border-radius: 18px;
            color: white;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.25);
        }

        .card h2 {
            margin-top: 0;
            font-size: 22px;
        }

        .card p {
            font-size: 15px;
            line-height: 1.6;
        }

        .tsunami { background: linear-gradient(135deg, #74ebd5, #acb6e5); }
        .earthquake { background: linear-gradient(135deg, #ffafbd, #ffc3a0); }
        .flood { background: linear-gradient(135deg, #89f7fe, #66a6ff); }
        .wildfire { background: linear-gradient(135deg, #f12711, #f5af19); }
        .hurricane { background: linear-gradient(135deg, #3a7bd5, #3a6073); }
        .volcano { background: linear-gradient(135deg, #ff6e7f, #bfe9ff); }

        .footer {
            text-align: center;
            padding: 20px;
            background: #2d3e50;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Historical Disaster Data & Global Heatmaps</h1>
        <p>Explore patterns, frequency, and intensity of disasters across time and regions</p>
    </div>

    <div class="container">

        <!-- Tsunami Card -->
        <a href="map_tsunami.php" class="card tsunami">
            <h2>Tsunami Heatmap</h2>
            <p>
                View global tsunami impact over time. Analyze coastal vulnerability, frequency trends, and recovery patterns
                using data-backed visualizations layered on interactive maps.
            </p>
        </a>

        <!-- Earthquake Card -->
        <a href="map_earthquake.php" class="card earthquake">
            <h2>Earthquake Zones</h2>
            <p>
                Explore seismic activity history worldwide. Visualize fault lines, quake magnitudes, and affected regions,
                with heatmaps showing most impacted zones by decade.
            </p>
        </a>

        <!-- Flood Card -->
        <a href="map_flood.php" class="card flood">
            <h2>Flood-Prone Regions</h2>
            <p>
                Flood impact and rainfall-based flood data visualized on topographical maps. Understand river overflow zones,
                city vulnerability, and flood history per region.
            </p>
        </a>

        <!-- Wildfire Card -->
        <a href="map_wildfire.php" class="card wildfire">
            <h2>Wildfire Intensity Map</h2>
            <p>
                Analyze fire-prone forests and urban interface areas. Examine frequency, duration, and cause distribution
                over the past 20 years via global heatmaps.
            </p>
        </a>

        <!-- Hurricane Card -->
        <a href="map_hurricane.php" class="card hurricane">
            <h2>Hurricane Tracks</h2>
            <p>
                Interactive maps showing hurricane tracks, wind strength, landfall zones, and damage footprints across
                Atlantic and Pacific regions.
            </p>
        </a>

        <!-- Volcano Card -->
        <a href="map_volcano.php" class="card volcano">
            <h2>Volcano Eruption History</h2>
            <p>
                Global volcanic activity displayed with eruption frequency and lava flow zones. Includes active, dormant,
                and extinct volcano classification.
            </p>
        </a>

    </div>

    <div class="footer">
        &copy; 2025 Global Disaster Data Hub | Built with passion for preparedness
    </div>

</body>
</html>
