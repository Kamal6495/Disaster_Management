<?php

?>

<style>
    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
        background: #f4f4f4;
    }

    .header {
        background: linear-gradient(to right, rgb(54, 125, 155), rgb(2, 192, 255), #2c5364);
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

<div class="header">
    <h1>Historical Disaster Data & Global Heatmaps</h1>
    <p>Explore patterns, frequency, and intensity of disasters across time and regions</p>
</div>

<div class="container">
    <h2>Disaster Analysis</h2>
    <div id="chart-container" class="row"></div> <!-- Empty div, to be filled dynamically by JS -->
</div>

<hr>



<div class="footer">
    &copy; 2025 Global Disaster Data Hub | Built with passion for preparedness
</div>

