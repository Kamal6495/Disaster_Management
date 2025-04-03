

<?php
include './assets/key/config.php';
// Database Connection
$host = "localhost";
$username = "root";  // Change as needed
$password = "";      // Change as needed
$dbname = "disaster_db"; // Change to your database name

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// NASA EONET API URL
$nasa_url = "https://eonet.gsfc.nasa.gov/api/v3/events";

// GDACS API URL
$gdacs_url = "https://www.gdacs.org/xml/rss.xml";

// Fetch NASA Data
$nasa_data = json_decode(file_get_contents($nasa_url), true);
if (isset($nasa_data['events'])) {
    foreach ($nasa_data['events'] as $event) {
        $event_id = $conn->real_escape_string($event['id']);
        $title = $conn->real_escape_string($event['title']);
        $type = $conn->real_escape_string($event['categories'][0]['title']);
        $source = $conn->real_escape_string($event['sources'][0]['url']);
        $status = $conn->real_escape_string($event['status']);
        $timestamp = date('Y-m-d H:i:s', strtotime($event['geometry'][0]['date']));
        $lat = $event['geometry'][0]['coordinates'][1] ?? null;
        $lon = $event['geometry'][0]['coordinates'][0] ?? null;

        // Check for duplicate entry
        $check_sql = "SELECT * FROM disaster_alerts WHERE event_id = '$event_id'";
        if ($conn->query($check_sql)->num_rows == 0) {
            // Insert into database
            $sql = "INSERT INTO disaster_alerts (event_id, title, type, source, status, timestamp, latitude, longitude)
                    VALUES ('$event_id', '$title', '$type', '$source', '$status', '$timestamp', '$lat', '$lon')";
            $conn->query($sql);
        }
    }
}

// Fetch GDACS Data (RSS Parsing)
$xml = simplexml_load_file($gdacs_url);
foreach ($xml->channel->item as $item) {
    $title = $conn->real_escape_string($item->title);
    $link = $conn->real_escape_string($item->link);
    $description = $conn->real_escape_string($item->description);
    $pubDate = date('Y-m-d H:i:s', strtotime($item->pubDate));

    preg_match('/Lat:\s(-?\d+\.\d+),\sLon:\s(-?\d+\.\d+)/', $description, $matches);
    $lat = $matches[1] ?? null;
    $lon = $matches[2] ?? null;

    // Check for duplicates
    $check_sql = "SELECT * FROM disaster_alerts WHERE title = '$title'";
    if ($conn->query($check_sql)->num_rows == 0) {
        $sql = "INSERT INTO disaster_alerts (title, type, source, timestamp, latitude, longitude)
                VALUES ('$title', 'GDACS Event', '$link', '$pubDate', '$lat', '$lon')";
        $conn->query($sql);
    }
}

$conn->close();
?>
