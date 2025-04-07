<?php
// include './assets/key/config.php';
include __DIR__ . '/assets/key/config.php';
// Database Connection
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "disaster_db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**********NASA DATA FECTH FOR MARING in GAMAPs********************************** */
$nasa_url = "https://eonet.gsfc.nasa.gov/api/v3/events";
$nasa_data = json_decode(file_get_contents($nasa_url), true);

// === NASA JSON Data Insertion ===
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
        /************* Debug print each field before inserting************** */
        // echo "<pre>NASA Event: " . print_r($event, true) . "</pre>";
        
        echo "<pre>";
        echo "<div style='margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #f9f9f9;'>";
        echo "🛰️ NASA Event Data:\n";
        echo "Event ID: $event_id\n";
        echo "Title: $title\n";
        echo "Type: $type\n";
        echo "Source: $source\n";
        echo "Status: $status\n";
        echo "Timestamp: $timestamp\n";
        echo "Latitude: $lat\n";
        echo "Longitude: $lon\n";
        echo "</div>";
        echo "</pre>";
        



        /***Inserting in dv */

        $check_sql = "SELECT * FROM disaster_alerts WHERE event_id = '$event_id'";
        if ($conn->query($check_sql)->num_rows == 0) {
            $sql = "INSERT INTO disaster_alerts (event_id, title, type, source, status, timestamp, latitude, longitude)
                    VALUES ('$event_id', '$title', '$type', '$source', '$status', '$timestamp', '$lat', '$lon')";

            if ($conn->query($sql)) {
                echo "✅ Inserted: $title<br>";
            } else {
                echo "❌ Error inserting $event_id: " . $conn->error . "<br>";
            }
        } else {
            echo "⚠️ Already exists: $event_id - $title<br>";
        }
    }
}
/**********GDACS DAATA FOR MARQUEE********************************** */
$gdacs_url = "https://www.gdacs.org/xml/rss.xml";
$xml = simplexml_load_file($gdacs_url);

if (!$xml) {
    die("❌ Failed to load GDACS RSS feed.");
}

$added = 0;
$skipped = 0;

$count = 1;
foreach ($xml->channel->item as $item) {
    /*********Debuuging Print**************/
    // echo "<hr><h3>🔍 Basic Fields (Item #" . ($count + 1) . ")</h3><pre>";
    // print_r($item->guid);
    // echo "</pre>";

    /********Data Storing in varibal************* */
    $event_id = $conn->real_escape_string((string)$item->guid);
    $title = $conn->real_escape_string((string)$item->title);
    $description = $conn->real_escape_string((string)$item->description);
    $link = $conn->real_escape_string((string)$item->link);
    $pubDate = date('Y-m-d H:i:s', strtotime((string)$item->pubDate));

    // Access namespaces
    $namespaces = $item->getNameSpaces(true);
    $gdacs = $item->children($namespaces['gdacs']);
    $geo = $item->children($namespaces['geo']);
    $point = $geo->Point;

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
            break;
    }


    $alert_level = $conn->real_escape_string((string)$gdacs->alertlevel);
    // $event_id = $conn->real_escape_string((string)$gdacs->eventid);
    $country = $conn->real_escape_string((string)$gdacs->country);
    $icon = $conn->real_escape_string((string)$gdacs->icon);
    $lat = isset($point->lat) ? (float)$point->lat : null;
    $lon = isset($point->long) ? (float)$point->long : null;

    /*********Debuuging Print**************/

    // echo "<h3>🌐 GDACS Fields</h3><pre>";
    // print_r($gdacs);
    // echo "</pre>";

    // echo "<h3>📍 GEO Fields</h3><pre>";
    // print_r($geo);
    // echo "</pre>";
    echo "<pre>";
    echo "<div style='margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #f9f9f9;'>";
    echo "<h3>🌍 GDACS Event $count</h3>";
    echo "<strong>event id:</strong> $event_id<br>";
    echo "<strong>Title:</strong> $title<br>";
    echo "<strong>Description:</strong> $description<br>";
    echo "<strong>Link:</strong> <a href='$link' target='_blank'>$link</a><br>";
    echo "<strong>Published Date:</strong> $pubDate<br>";
    echo "<strong>EVENT Type :</strong> $event_type<br>";
    echo "<strong>country Type :</strong> $country<br>";
    echo "<strong>icon Type :</strong> $icon<br>";
    echo "<strong>lat Type :</strong> $lat<br>";
    echo "<strong>long Type :</strong> $lon<br>";
    echo "</div>";
    echo "</pre>";

    /****************Insert Into table********************************************** */
    // Check if already exists
    $check_sql = "SELECT id FROM disaster_gdacs WHERE event_id = '$event_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        $insert_sql = "INSERT INTO disaster_gdacs 
            (title, description, link, pubDate, event_id, alert_level, event_type, country, latitude, longitude, icon_url)
            VALUES 
            ('$title', '$description', '$link', '$pubDate', '$event_id', '$alert_level', '$event_type', '$country', '$lat', '$lon', '$icon_url')";

        if ($conn->query($insert_sql)) {
            echo "✅ Inserted: $title<br>";
        } else {
            echo "❌ Error inserting $event_id: " . $conn->error . "<br>";
        }
    } else {
        echo "⚠️ Already exists: $event_id - $title<br>";
    }



    // $count++;
}

echo "✅ Fetched and inserted GDACS data.<br>";
echo "➕ New entries added: $added<br>";
echo "⏭️ Skipped (already existing): $skipped<br>";

$conn->close();
