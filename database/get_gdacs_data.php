<?php
include '../assets/key/config.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM disaster_gdacs";
$result = $conn->query($sql);
$disasters = [];

while ($row = $result->fetch_assoc()) {
    $disasters[] = $row;
}


echo json_encode($disasters);
// echo json_encode($disasters1);
?>

