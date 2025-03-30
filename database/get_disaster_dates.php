<?php
require_once '../assets/key/config.php';

$query = "SELECT DISTINCT DATE(timestamp) as disaster_date FROM disaster_alerts ORDER BY disaster_date DESC";
$result = $conn->query($query);

$dates = [];
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['disaster_date'];
}

header('Content-Type: application/json');
echo json_encode($dates);
?>
