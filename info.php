<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Disaster Knowledge Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f2f2f2;
        }

        .header {
            background: linear-gradient(to right, #007991, #78ffd6);
            padding: 30px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
        }

        .header p {
            font-size: 18px;
            margin-top: 8px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            padding: 50px 20px;
        }

        .card {
            background: linear-gradient(135deg, #ffffff, #f3f9ff);
            width: 330px;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .card:hover {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            transform: translateY(-10px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            margin-top: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        .card ul {
            padding-left: 20px;
            font-size: 15px;
            color: #333;
            line-height: 1.6;
        }

        .card ul li {
            margin-bottom: 10px;
        }

        .footer {
            background: #2d3e50;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Disaster Knowledge Portal</h1>
        <p>Learn, Prepare, and Analyze for Safer Communities</p>
    </div>

    <div class="container">

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

    <div class="footer">
        &copy; 2025 Disaster Knowledge Portal | Empowering Preparedness & Resilience
    </div>

</body>
</html>
