<?php
$api_url = "https://eonet.gsfc.nasa.gov/api/v3/events";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

if (!$data || empty($data['events'])) {
    die("Error: No events found from NASA API.");
}

echo "<pre>";
print_r($data);
echo "</pre>";
?>
