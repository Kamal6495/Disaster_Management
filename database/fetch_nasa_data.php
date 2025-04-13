<?php
include '../assets/key/config.php';
//include __DIR__ . '/assets/key/config.php';
// Database Connection
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "disaster_db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/**********GDACS DAATA FOR MARQUEE********************************** */
$xml = simplexml_load_file($GDACS_RSS7D);

if (!$xml) {
    die("❌ Failed to load GDACS RSS feed.");
}
echo "📦 Total items in feed: " . count($xml->channel->item) . "<br>";
echo "<hr>";
$added = 0;
$skipped = 0;

$count = 1;

$seen_ids = [];

if (!$xml) {
    die("❌ Failed to load XML.");
}

$seen_ids = [];

$items = $xml->channel->item;
echo "Total items: " . count($items) . "<br>";

foreach ($items as $item) {
    // Trim + deduplicate before DB logic
    $raw_event_id = (string)$item->guid;
    $event_id_trimmed = trim(preg_replace('/\s+/', '', $raw_event_id));

    if (in_array($event_id_trimmed, $seen_ids)) {
        echo "🔁 Duplicate in XML (skipped before DB): $event_id_trimmed<br>";
        continue; // Skip to next
    } else {
        $seen_ids[] = $event_id_trimmed;
    }

    // Escape + assign
    $event_id = $conn->real_escape_string($raw_event_id);
    $title = $conn->real_escape_string((string)$item->title);
    $description = $conn->real_escape_string((string)$item->description);
    $link = $conn->real_escape_string((string)$item->link);
    $pubDate = date('Y-m-d H:i:s', strtotime((string)$item->pubDate));

    // Namespaces
    $namespaces = $item->getNameSpaces(true);
    $gdacs = $item->children($namespaces['gdacs']);
    $geo = $item->children($namespaces['geo']);

    // Extract bbox
    list($lon_min, $lon_max, $lat_min, $lat_max) = explode(' ', (string)$gdacs->bbox);
    $lon_min = (float)$lon_min;
    $lon_max = (float)$lon_max;
    $lat_min = (float)$lat_min;
    $lat_max = (float)$lat_max;

    // GDACS fields
    $alert_level = $conn->real_escape_string((string)$gdacs->alertlevel);
    $country = $conn->real_escape_string((string)$gdacs->country);
    $event_type = $conn->real_escape_string((string)$gdacs->eventtype);
    $icon_url = $conn->real_escape_string((string)$gdacs->icon);

    // Geo coords
    $latitude = isset($geo->Point->lat) ? (float)$geo->Point->lat : 0.0;
    $longitude = isset($geo->Point->long) ? (float)$geo->Point->long : 0.0;


    // Event type mapping
    $event_type_code = (string)$gdacs->eventtype;
    $event_type = 'Unknown';
    switch ($event_type_code) {
        case 'WF':
            $event_type = 'Wildfire';
            break;
        case 'DR':
            $event_type = 'Drought';
            break;
        case 'EQ':
            $event_type = 'Earthquake';
            break;
        case 'FL':
            $event_type = 'Flood';
        case 'TC':
            $event_type = 'Cyclone';
            break;
           
    }


    // DB Duplicate Check
    $check_sql = "SELECT id FROM disaster_gdacs WHERE event_id = '$event_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        // Insert
        $insert_sql = "INSERT INTO disaster_gdacs 
            (title, description, link, pubDate, event_id, alert_level, event_type, country, latitude, longitude, icon_url,
             lon_min, lon_max, lat_min, lat_max)
            VALUES 
            ('$title', '$description', '$link', '$pubDate', '$event_id', '$alert_level', '$event_type', '$country', 
             '$latitude', '$longitude', '$icon_url', 
             '$lon_min', '$lon_max', '$lat_min', '$lat_max')";

        if ($conn->query($insert_sql)) {
            echo "$count  =";
            echo "✅ Inserted: $title<br>";
        } else {
            echo "❌ SQL Error inserting $event_id: " . $conn->error . "<br>";
        }
    } else {
        echo "⚠️ Already exists in DB: $event_id - $title<br>";
    }

    $count++;
}


$conn->close();


/**********NASA DATA FECTH FOR MARING in GAMAPs********************************** */
// $nasa_url = "https://eonet.gsfc.nasa.gov/api/v3/events";
// $nasa_data = json_decode(file_get_contents($nasa_url), true);

// // === NASA JSON Data Insertion ===
// if (isset($nasa_data['events'])) {
//     foreach ($nasa_data['events'] as $event) {
//         $event_id = $conn->real_escape_string($event['id']);
//         $title = $conn->real_escape_string($event['title']);
//         $type = $conn->real_escape_string($event['categories'][0]['title']);
//         $source = $conn->real_escape_string($event['sources'][0]['url']);
//         $status = $conn->real_escape_string($event['status']);
//         $timestamp = date('Y-m-d H:i:s', strtotime($event['geometry'][0]['date']));
//         $lat = $event['geometry'][0]['coordinates'][1] ?? null;
//         $lon = $event['geometry'][0]['coordinates'][0] ?? null;
//         /************* Debug print each field before inserting************** */
//         // echo "<pre>NASA Event: " . print_r($event, true) . "</pre>";
        
//         echo "<pre>";
//         echo "<div style='margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #f9f9f9;'>";
//         echo "🛰️ NASA Event Data:\n";
//         echo "Event ID: $event_id\n";
//         echo "Title: $title\n";
//         echo "Type: $type\n";
//         echo "Source: $source\n";
//         echo "Status: $status\n";
//         echo "Timestamp: $timestamp\n";
//         echo "Latitude: $lat\n";
//         echo "Longitude: $lon\n";
//         echo "</div>";
//         echo "</pre>";
        



//         /***Inserting in dv */

//         $check_sql = "SELECT * FROM disaster_alerts WHERE event_id = '$event_id'";
//         if ($conn->query($check_sql)->num_rows == 0) {
//             $sql = "INSERT INTO disaster_alerts (event_id, title, type, source, status, timestamp, latitude, longitude)
//                     VALUES ('$event_id', '$title', '$type', '$source', '$status', '$timestamp', '$lat', '$lon')";

//             if ($conn->query($sql)) {
//                 echo "✅ Inserted: $title<br>";
//             } else {
//                 echo "❌ Error inserting $event_id: " . $conn->error . "<br>";
//             }
//         } else {
//             echo "⚠️ Already exists: $event_id - $title<br>";
//         }
//     }
// }