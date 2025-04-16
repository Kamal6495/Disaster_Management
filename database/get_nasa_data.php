<?php
include '../assets/key/config.php';
header('Content-Type: application/json');

// Get the year from the request (if provided)
$year = isset($_GET['year']) ? $_GET['year'] : '';

// Construct the SQL query
$sql = "SELECT * FROM disaster_alerts";
if ($year) {
    // If year is provided, filter by year extracted from the timestamp
    $sql .= " WHERE YEAR(timestamp) = $year";
}

$result = $conn->query($sql);
$disasters = [];

while ($row = $result->fetch_assoc()) {
    $disasters[] = $row;
}

echo json_encode($disasters);
?>
