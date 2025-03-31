<?php
require_once '../assets/key/config.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GeoJSON";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
} else {
    echo "✅ Database Connected Successfully.<br>";
}

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Fetch data from API
$json_data = file_get_contents(NASA_EONET_GEOJSON_URL);
$data = json_decode($json_data, true);

// Debug API response
if (!$data || !isset($data['features']) || count($data['features']) == 0) {
    die("❌ Invalid API response or no features found.");
} else {
    echo "✅ API Data Fetched Successfully.<br>";
}

// Insert into geojson_responses
$type = $data['type'];
$stmt = $conn->prepare("INSERT INTO geojson_responses (type) VALUES (?)");
$stmt->bind_param("s", $type);
$stmt->execute();
$geojson_response_id = $stmt->insert_id;
$stmt->close();
echo "✅ GeoJSON response stored successfully.<br>";

// Insert features
foreach ($data['features'] as $feature) {
    $feature_type = $feature['type'];

    $stmt = $conn->prepare("INSERT INTO features (geojson_response_id, type) VALUES (?, ?)");
    $stmt->bind_param("is", $geojson_response_id, $feature_type);
    if (!$stmt->execute()) {
        die("❌ Error inserting feature: " . $stmt->error);
    }
    $feature_id = $stmt->insert_id;
    $stmt->close();

    echo "✅ Feature inserted successfully (ID: $feature_id).<br>";

    // Insert properties
    $properties = $feature['properties'];
    $title = $properties['title'] ?? null;
    $description = $properties['description'] ?? null;
    $link = $properties['link'] ?? null;
    $closed = isset($properties['closed']) ? date("Y-m-d H:i:s", strtotime($properties['closed'])) : null;
    $date = isset($properties['date']) ? date("Y-m-d H:i:s", strtotime($properties['date'])) : null;
    $magnitude_value = isset($properties['magnitudeValue']) ? (float)$properties['magnitudeValue'] : null;
    $magnitude_unit = $properties['magnitudeUnit'] ?? null;

    $stmt = $conn->prepare("INSERT INTO properties (feature_id, title, description, link, closed, date, magnitude_value, magnitude_unit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssdds", $feature_id, $title, $description, $link, $closed, $date, $magnitude_value, $magnitude_unit);
    if (!$stmt->execute()) {
        die("❌ Error inserting properties: " . $stmt->error);
    }
    $property_id = $stmt->insert_id;
    $stmt->close();

    echo "✅ Properties stored successfully (Feature ID: $feature_id).<br>";

    // Insert categories
    if (!empty($properties['categories'])) {
        foreach ($properties['categories'] as $category) {
            $category_id = $category['id'];
            $category_title = $category['title'];

            $stmt = $conn->prepare("INSERT INTO categories (property_id, category_id, title) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $property_id, $category_id, $category_title);
            if (!$stmt->execute()) {
                die("❌ Error inserting categories: " . $stmt->error);
            }
            $stmt->close();
        }
        echo "✅ Categories stored successfully.<br>";
    }

    // Insert sources
    if (!empty($properties['sources'])) {
        foreach ($properties['sources'] as $source) {
            $source_id = $source['id'];
            $source_url = $source['url'];

            $stmt = $conn->prepare("INSERT INTO sources (property_id, source_id, url) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $property_id, $source_id, $source_url);
            if (!$stmt->execute()) {
                die("❌ Error inserting sources: " . $stmt->error);
            }
            $stmt->close();
        }
        echo "✅ Sources stored successfully.<br>";
    }

    // Insert geometry
    $geometry = $feature['geometry'];
    if (!empty($geometry)) {
        $geometry_type = $geometry['type'];

        $stmt = $conn->prepare("INSERT INTO geometry (feature_id, type) VALUES (?, ?)");
        $stmt->bind_param("is", $feature_id, $geometry_type);
        if (!$stmt->execute()) {
            die("❌ Error inserting geometry: " . $stmt->error);
        }
        $geometry_id = $stmt->insert_id;
        $stmt->close();

        echo "✅ Geometry stored successfully (Feature ID: $feature_id).<br>";

        // Insert geometry coordinates
        if (!empty($geometry['coordinates'])) {
            $coordinates = $geometry['coordinates'];

            if (is_array($coordinates[0])) {
                // Multi-point (LineString, Polygon, etc.)
                foreach ($coordinates as $coord) {
                    $latitude = (double)$coord[1];
                    $longitude = (double)$coord[0];

                    $stmt = $conn->prepare("INSERT INTO geometry_coordinates (geometry_id, latitude, longitude) VALUES (?, ?, ?)");
                    $stmt->bind_param("idd", $geometry_id, $latitude, $longitude);
                    if (!$stmt->execute()) {
                        die("❌ Error inserting coordinates: " . $stmt->error);
                    }
                    $stmt->close();
                }
            } else {
                // Single-point (Point)
                $latitude = (double)$coordinates[1];
                $longitude = (double)$coordinates[0];

                $stmt = $conn->prepare("INSERT INTO geometry_coordinates (geometry_id, latitude, longitude) VALUES (?, ?, ?)");
                $stmt->bind_param("idd", $geometry_id, $latitude, $longitude);
                if (!$stmt->execute()) {
                    die("❌ Error inserting single-point coordinates: " . $stmt->error);
                }
                $stmt->close();
            }
        }
        echo "✅ Coordinates stored successfully.<br>";
    }

    // Insert geometry dates
    if (!empty($properties['geometryDates'])) {
        foreach ($properties['geometryDates'] as $geometry_date) {
            $formatted_date = date("Y-m-d H:i:s", strtotime($geometry_date));

            $stmt = $conn->prepare("INSERT INTO geometry_dates (property_id, geometry_date) VALUES (?, ?)");
            $stmt->bind_param("is", $property_id, $formatted_date);
            if (!$stmt->execute()) {
                die("❌ Error inserting geometry dates: " . $stmt->error);
            }
            $stmt->close();
        }
        echo "✅ Geometry dates stored successfully.<br>";
    }
}

echo "<br>🎉 Data successfully stored in the database!";

$conn->close();
?>
