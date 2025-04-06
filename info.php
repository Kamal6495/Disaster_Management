<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Disaster Knowledge Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        .header {
            background-color: #2d3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            padding: 40px;
        }

        .card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 25px;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            color: #2d3e50;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .card ul {
            padding-left: 18px;
            color: #444;
            font-size: 15px;
            line-height: 1.6;
        }

        .card ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Disaster Knowledge Portal</h1>
        <p>Learn, Prepare, and Analyze for Safer Communities</p>
    </div>

    <div class="container">

        <!-- Scenario: Tsunami -->
        <div class="card">
            <h2>Tsunami Preparedness</h2>
            <ul>
                <li>Live coastal alerts integrated with tide and seismic sensors.</li>
                <li>High-risk zones visualized with historical tsunami maps.</li>
                <li>Safety tips including vertical evacuation plans and inland routes.</li>
                <li>Guides on recognizing natural warning signs (e.g., sudden ocean retreat).</li>
                <li>Evacuation drills and survival kits suggestions tailored to coastal communities.</li>
            </ul>
        </div>

        <!-- Scenario: Wildfire Awareness -->
        <div class="card">
            <h2>Wildfire Awareness & Response</h2>
            <ul>
                <li>Real-time fire maps with satellite data and wind direction overlays.</li>
                <li>Community alert systems for evacuation notices and air quality updates.</li>
                <li>Home safety checklists: defensible space, flammable material clearance.</li>
                <li>Recovery support: insurance guidance, re-entry safety protocols.</li>
                <li>Education on causes (natural vs human-made), prevention strategies.</li>
            </ul>
        </div>

        <!-- Scenario: Earthquake Safety -->
        <div class="card">
            <h2>Earthquake Safety Measures</h2>
            <ul>
                <li>Shake intensity maps with building vulnerability overlays.</li>
                <li>Step-by-step earthquake drill animations ("Drop, Cover, and Hold").</li>
                <li>Preparation checklists: securing shelves, emergency food/water supplies.</li>
                <li>School and workplace safety zones clearly marked.</li>
                <li>Aftershock tracking and mental health support information.</li>
            </ul>
        </div>

        <!-- Scenario: Flood Risk Awareness -->
        <div class="card">
            <h2>Flood Risk & Awareness</h2>
            <ul>
                <li>Dynamic floodplain maps with rainfall prediction data.</li>
                <li>Real-time river level monitoring and warning systems.</li>
                <li>Guides on waterproofing basements, securing electricity points.</li>
                <li>Post-flood sanitation and water contamination alerts.</li>
                <li>Regional policies and government aid procedures listed.</li>
            </ul>
        </div>

        <!-- Scenario: Public Safety Platform Overview -->
        <div class="card">
            <h2>Public Awareness & Safety Platform</h2>
            <ul>
                <li>Interactive disaster maps highlighting affected zones.</li>
                <li>Custom alerts based on user’s geolocation and profile.</li>
                <li>Evacuation routes, nearest hospitals, and relief shelters displayed.</li>
                <li>Multilingual guidance for safety instructions and emergency contacts.</li>
                <li>Community forums and volunteer networks integrated into the portal.</li>
            </ul>
        </div>

        <!-- Scenario: Historical Data Analysis -->
        <div class="card">
            <h2>Historical Data & Trend Analysis</h2>
            <ul>
                <li>Access to historical records of disasters: year, type, impact, region.</li>
                <li>Heatmaps to show disaster-prone areas globally by decade.</li>
                <li>Visualization of frequency & intensity patterns over time.</li>
                <li>Correlation between disasters and population density, urbanization.</li>
                <li>Exportable datasets for academic and government use (CSV, JSON).</li>
                <li>Case studies highlighting climate-related escalations.</li>
            </ul>
        </div>

    </div>

</body>
</html>
