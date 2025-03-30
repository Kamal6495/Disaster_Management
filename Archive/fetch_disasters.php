<?php
include 'config.php';

$sql = "SELECT * FROM disaster_alerts ORDER BY timestamp DESC";
$result = $conn->query($sql);

$disasters = array();
while ($row = $result->fetch_assoc()) {
    $disasters[] = $row;
}
echo json_encode($disasters);
?>
