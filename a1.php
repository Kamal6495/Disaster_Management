
<?php
$host = "localhost";
$username = "root";
$password = "root"; // set your password
$database = "disaster_db";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// === NASA API Fetch ===
// if (isset($_GET['refresh'])) {
//     $nasa_url = "https://eonet.gsfc.nasa.gov/api/v3/events";
//     $nasa_data = json_decode(file_get_contents($nasa_url), true);

//     if (isset($nasa_data['events'])) {
//         foreach ($nasa_data['events'] as $event) {
//             $event_id = $conn->real_escape_string($event['id']);
//             $title = $conn->real_escape_string($event['title']);
//             $type = $conn->real_escape_string($event['categories'][0]['title']);
//             $source = $conn->real_escape_string($event['sources'][0]['url']);
//             $status = $conn->real_escape_string($event['status']);
//             $timestamp = date('Y-m-d H:i:s', strtotime($event['geometry'][0]['date']));
//             $lat = $event['geometry'][0]['coordinates'][1] ?? null;
//             $lon = $event['geometry'][0]['coordinates'][0] ?? null;

//             $location = $conn->real_escape_string($event['geometry'][0]['type'] ?? 'Unknown');

//             $check_sql = "SELECT * FROM disaster_alerts WHERE event_id = '$event_id'";
//             if ($conn->query($check_sql)->num_rows == 0) {
//                 $sql = "INSERT INTO disaster_alerts (event_id, title, type, source, status, timestamp, latitude, longitude, location)
//                         VALUES ('$event_id', '$title', '$type', '$source', '$status', '$timestamp', '$lat', '$lon', '$location')";
//                 $conn->query($sql);
//             }
//         }
//         header("Location: dashboard.php?status=completed");
//         exit;
//     }
// }

// === Fetch all disaster types ===
$types = ['Earthquake', 'Sea and Lake Ice', 'Hurricane', 'Typhoon', 'Wildfires', 'Volcanoes'];
$year_filter = $_GET['year'] ?? '';
$country_filter = $_GET['country'] ?? '';

function fetchCounts($type, $conn, $year_filter, $country_filter) {
    $where = "WHERE type = '$type'";
    if ($year_filter) $where .= " AND YEAR(timestamp) = '$year_filter'";
    if ($country_filter) $where .= " AND title LIKE '%$country_filter%'";
    $result = $conn->query("SELECT COUNT(*) as count, YEAR(timestamp) as year FROM disaster_alerts $where GROUP BY year ORDER BY year");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['year']] = $row['count'];
    }
    return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Disaster Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 0; padding: 20px; }
        .grid { display: flex; flex-wrap: wrap; gap: 20px; }
        .card {
            flex: 1 1 calc(33% - 20px);
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            border-radius: 12px;
            padding: 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 300px;
        }
        .card:nth-child(2) { background: linear-gradient(135deg, #fcb69f, #ffecd2); color: #000; }
        .card:nth-child(3) { background: linear-gradient(135deg, #89f7fe, #66a6ff); }
        .card:nth-child(4) { background: linear-gradient(135deg, #ff416c, #ff4b2b); }
        .card:nth-child(5) { background: linear-gradient(135deg, #3a7bd5, #3a6073); }
        .card:nth-child(6) { background: linear-gradient(135deg, #ff758c, #ff7eb3); }

        .filters { margin-bottom: 20px; }
        select { padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc; margin-right: 10px; }
        button { padding: 6px 14px; border: none; border-radius: 6px; background: #28a745; color: white; cursor: pointer; }
    </style>
</head>
<body>

<h2>🌍 Global Disaster Data Dashboard</h2>

<form method="get" class="filters">
    <select name="year">
        <option value="">Filter by Year</option>
        <?php for ($y = 2000; $y <= date('Y'); $y++): ?>
            <option value="<?= $y ?>" <?= ($year_filter == $y) ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

    <select name="country">
        <option value="">Filter by Keyword (Country/Region)</option>
        <option value="India">India</option>
        <option value="USA">USA</option>
        <option value="Japan">Japan</option>
        <option value="Indonesia">Indonesia</option>
    </select>

    <button type="submit">Apply Filters</button>
    <button type="submit" name="refresh" value="1" style="background:#007bff;">🔄 Refresh NASA Data</button>
</form>

<div class="grid">
<?php foreach ($types as $index => $type): 
    $counts = fetchCounts($type, $conn, $year_filter, $country_filter);
    $labels = json_encode(array_keys($counts));
    $data = json_encode(array_values($counts));
    ?>
    <div class="card">
        <h3><?= $type ?> Trends</h3>
        <canvas id="chart<?= $index ?>"></canvas>
        <script>
            new Chart(document.getElementById("chart<?= $index ?>"), {
                type: 'line',
                data: {
                    labels: <?= $labels ?>,
                    datasets: [{
                        label: '<?= $type ?> Incidents',
                        data: <?= $data ?>,
                        fill: true,
                        backgroundColor: 'rgba(255,255,255,0.2)',
                        borderColor: '#fff',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: { legend: { labels: { color: 'white' } } },
                    scales: {
                        x: { ticks: { color: 'white' } },
                        y: { ticks: { color: 'white' }, beginAtZero: true }
                    }
                }
            });
        </script>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
