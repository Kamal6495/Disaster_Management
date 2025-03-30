<?php
require_once '../assets/key/config.php'; // Database connection

header("Content-Type: application/json");

define("GDACS_RSS_FEED", "https://www.gdacs.org/xml/rss.xml");

echo "<h3>🌍 Fetching GDACS Disaster Data...</h3>";

// Fetch GDACS RSS Feed
try {
    $rss = simplexml_load_file(GDACS_RSS_FEED);
    if (!$rss) {
        die("❌ Error: Could not fetch GDACS RSS feed.");
    }
} catch (Exception $e) {
    die("❌ Exception: " . $e->getMessage());
}

echo "✅ GDACS RSS feed loaded successfully!<br>";
$inserted_count = 0;
$skipped_count = 0;

$fetched_data = []; // Store fetched data for display

foreach ($rss->channel->item as $item) {
    $namespaces = $item->getNamespaces(true);
    $gdacs = $item->children($namespaces['gdacs']);
    $geo = $item->children($namespaces['geo']);
    
    $event_id = (string) $gdacs->eventid;
    $episode_id = (string) $gdacs->episodeid;
    $disaster_type = (string) $gdacs->eventtype;
    $alert_level = (string) $gdacs->alertlevel;
    $timestamp = date("Y-m-d H:i:s", strtotime((string) $gdacs->fromdate));
    $latitude = (float) $geo->lat;
    $longitude = (float) $geo->long;
    $source_url = (string) $item->link;
    $image_url = (string) $item->enclosure['url'];

    // Additional fields
    $magnitude = isset($gdacs->severity['value']) ? (float) $gdacs->severity['value'] : NULL;
    $depth = isset($gdacs->severity['depth']) ? (float) $gdacs->severity['depth'] : NULL;
    $severity_score = isset($gdacs->alertscore) ? (float) $gdacs->alertscore : NULL;
    $population_affected = isset($gdacs->population['value']) ? (int) $gdacs->population['value'] : 0;
    $country = (string) $gdacs->country;
    $glide_number = (string) $gdacs->glide;

    // Store fetched data for preview
    $fetched_data[] = [
        "event_id" => $event_id,
        "episode_id" => $episode_id,
        "disaster_type" => $disaster_type,
        "alert_level" => $alert_level,
        "timestamp" => $timestamp,
        "latitude" => $latitude,
        "longitude" => $longitude,
        "source_url" => $source_url,
        "image_url" => $image_url,
        "magnitude" => $magnitude,
        "depth" => $depth,
        "severity_score" => $severity_score,
        "population_affected" => $population_affected,
        "country" => $country,
        "glide_number" => $glide_number,
        "source" => "GDACS"
    ];
}

// Display fetched data before inserting into the database
echo "<h3>🛑 Fetched GDACS Disaster Data (Preview)</h3>";
echo "<pre>" . json_encode($fetched_data, JSON_PRETTY_PRINT) . "</pre>";

// Now proceed with database insertion
foreach ($fetched_data as $data) {
    // Check for duplicates
    $check_sql = "SELECT id FROM gdacs_disasters WHERE event_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $data['event_id']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        // Insert new event
        $insert_sql = "INSERT INTO gdacs_disasters 
                       (event_id, episode_id, disaster_type, alert_level, timestamp, latitude, longitude, source_url, image_url, magnitude, depth, severity_score, population_affected, country, glide_number, source) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_sql);
        if (!$stmt) {
            die("❌ SQL Prepare Failed: " . $conn->error);
        }

        $stmt->bind_param("sssssdssssdddsss", 
            $data['event_id'], $data['episode_id'], $data['disaster_type'], $data['alert_level'], $data['timestamp'], 
            $data['latitude'], $data['longitude'], $data['source_url'], $data['image_url'], 
            $data['magnitude'], $data['depth'], $data['severity_score'], $data['population_affected'], $data['country'], $data['glide_number'], "GDACS");

        if ($stmt->execute()) {
            echo "✅ Inserted: <b>{$data['disaster_type']}</b> (ID: {$data['event_id']})<br>";
            $inserted_count++;
        } else {
            echo "❌ Error inserting: " . $stmt->error . "<br>";
        }
    } else {
        echo "⏩ Already Exists: <b>{$data['disaster_type']}</b> (ID: {$data['event_id']})<br>";
        $skipped_count++;
    }
    $stmt->close();
}

$conn->close();
echo "<h3>✅ GDACS Disaster Data Updated!</h3>";
echo "<p>Inserted: $inserted_count | Skipped: $skipped_count</p>";
?>
