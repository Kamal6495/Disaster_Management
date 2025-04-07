<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Disaster Relief & Help Contacts</title>
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

        .email, .phone {
            font-weight: bold;
            color: #2c3e50;
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
        <h1>Relief & Help - Disaster Management</h1>
        <p>Reach out. Support. Volunteer. Stay Safe.</p>
    </div>

    <div class="container">

        <!-- Emergency Contacts -->
        <div class="card">
            <h2>Emergency Contacts</h2>
            <ul>
                <li><span class="phone">National Disaster Helpline:</span> 108 / 112</li>
                <li><span class="phone">Medical Emergency:</span> 102</li>
                <li><span class="phone">Fire Services:</span> 101</li>
                <li><span class="phone">Police Helpline:</span> 100</li>
                <li><span class="email">Email:</span> emergency@disasterhelp.org</li>
            </ul>
        </div>

        <!-- Volunteer Registration -->
        <div class="card">
            <h2>Volunteer Registration</h2>
            <ul>
                <li>Join our trained volunteer force to assist in rescue and relief.</li>
                <li>Get certified through local disaster management authorities.</li>
                <li>Register online or contact your nearest relief office.</li>
                <li><span class="email">Email:</span> volunteer@disasterrelief.org</li>
                <li><span class="phone">Phone:</span> +91 98765 43210</li>
            </ul>
        </div>

        <!-- NGO Support -->
        <div class="card">
            <h2>NGO Support Lines</h2>
            <ul>
                <li>Donate essentials: food, water, medicines, clothing.</li>
                <li>Connect with verified NGOs working in disaster zones.</li>
                <li>Collaborate with shelter providers and medical units.</li>
                <li><span class="email">Email:</span> support@rescuengo.in</li>
                <li><span class="phone">Phone:</span> +91 90000 11122</li>
            </ul>
        </div>

        <!-- Government Help Desks -->
        <div class="card">
            <h2>Government Help Desks</h2>
            <ul>
                <li>Access compensation claims and housing support.</li>
                <li>Check for government relief camp locations.</li>
                <li>Report missing persons or request relocation aid.</li>
                <li><span class="email">Email:</span> reliefdesk@gov.in</li>
                <li><span class="phone">Phone:</span> +91 1800 123 4567</li>
            </ul>
        </div>

        <!-- Psychological Aid -->
        <div class="card">
            <h2>Psychological Support</h2>
            <ul>
                <li>24x7 mental health counseling post-disaster trauma.</li>
                <li>Helpline for grief, anxiety, PTSD support.</li>
                <li>Remote sessions by certified psychologists.</li>
                <li><span class="email">Email:</span> care@mindrelief.org</li>
                <li><span class="phone">Phone:</span> +91 84444 77788</li>
            </ul>
        </div>

    </div>

    <div class="footer">
        &copy; 2025 Disaster Management Authority | Stay Informed. Stay Safe.
    </div>

</body>
</html>
