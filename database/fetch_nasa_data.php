<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../assets/key/config.php'; // Ensure correct path

echo "<h3>🌍 Fetching NASA EONET Data...</h3>";

// Step 1: Check Database Connection
if (!$conn) {
    die("❌ Database connection is not established.");
} else {
    echo "✅ Database connection is working.<br>";
}

// Step 2: Check NASA API Fetching
$response = @file_get_contents(NASA_EONET_API_URL);
if ($response === FALSE) {
    die("❌ Error: Could not fetch NASA API data.");
}

$data = json_decode($response, true);
if (!$data || !isset($data['events'])) {
    die("❌ Error: Invalid NASA API response.");
}

echo "✅ NASA API is working correctly!<br>";

// Step 3: Process Data
$inserted_count = 0;
$skipped_count = 0;

foreach ($data['events'] as $event) {
    $event_id = $event['id'];
    $title = $conn->real_escape_string($event['title']);
    $category = $event['categories'][0]['title'] ?? "Unknown";
    $severity = "Moderate"; // Default severity
    $timestamp = isset($event['geometry'][0]['date']) ? date("Y-m-d H:i:s", strtotime($event['geometry'][0]['date'])) : date("Y-m-d H:i:s");
    $latitude = $event['geometry'][0]['coordinates'][1] ?? 0.0;
    $longitude = $event['geometry'][0]['coordinates'][0] ?? 0.0;
    $description = isset($event['description']) ? $conn->real_escape_string($event['description']) : "No description available.";
    $region = "Unknown";
    $source_url = isset($event['sources'][0]['url']) ? $conn->real_escape_string($event['sources'][0]['url']) : "N/A";

    // Check for duplicates
    $check_sql = "SELECT id FROM disaster_alerts WHERE eonet_id = ?";
    $stmt = $conn->prepare($check_sql);
    if (!$stmt) {
        die("❌ SQL Prepare Failed: " . $conn->error);
    }
    $stmt->bind_param("s", $event_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Insert into DB
        $insert_sql = "INSERT INTO disaster_alerts 
            (eonet_id, disaster_type, category, severity, timestamp, latitude, longitude, region, description, source_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_sql);
        if (!$stmt) {
            die("❌ SQL Prepare Failed: " . $conn->error);
        }
        $stmt->bind_param("sssssdssss", $event_id, $title, $category, $severity, $timestamp, $latitude, $longitude, $region, $description, $source_url);

        if ($stmt->execute()) {
            echo "✅ Inserted: <b>$title</b><br>";
            $inserted_count++;
        } else {
            echo "❌ Error inserting: " . $stmt->error . "<br>";
        }
    } else {
        echo "⏩ Already Exists: <b>$title</b><br>";
        $skipped_count++;
    }
    $stmt->close();
}

$conn->close();
echo "<h3>✅ NASA Disaster Data Updated!</h3>";
echo "<p>Inserted: $inserted_count | Skipped: $skipped_count</p>";
?>
