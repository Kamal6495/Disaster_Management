<?php
require_once '../assets/key/config.php'; // Database connection

header("Content-Type: application/json");

// Get filters from request
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$type = isset($_GET['type']) && $_GET['type'] !== 'all' ? $_GET['type'] : null;
$country = isset($_GET['country']) && $_GET['country'] !== 'all' ? $_GET['country'] : null;

// SQL query with filtering
$sql = "SELECT disaster_type, category, severity, timestamp, latitude, longitude, region, source_url 
        FROM disaster_alerts 
        WHERE DATE(timestamp) = ?";

$params = [$date];
$types = "s";

// Filter by disaster type if selected
if ($type) {
    $sql .= " AND disaster_type = ?";
    $params[] = $type;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$disasters = [];
while ($row = $result->fetch_assoc()) {
    // Reverse geocode latitude & longitude to get country
    $country_name = getCountryFromCoordinates($row['latitude'], $row['longitude']);

    // Filter by country if selected
    if ($country && $country !== $country_name) {
        continue; // Skip if country does not match
    }

    $row['country'] = $country_name;
    $disasters[] = $row;
}

// Return JSON response
echo json_encode($disasters ?: []);

/**
 * Reverse Geocoding - Get country from latitude & longitude
 */
function getCountryFromCoordinates($lat, $lng)
{
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=" . GOOGLE_GEOCODE_API;
    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (!empty($json['results'])) {
        foreach ($json['results'][0]['address_components'] as $component) {
            if (in_array("country", $component['types'])) {
                return $component['long_name']; // Return country name
            }
        }
    }
    return "Unknown";
}
?>
