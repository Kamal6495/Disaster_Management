<?php
header("Content-Type: application/json");
include 'db_connect.php';

$disaster_id = $_GET['disaster_id']; // Get disaster ID from request

$sql = "SELECT * FROM relief_measures WHERE disaster_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $disaster_id);
$stmt->execute();
$result = $stmt->get_result();

$relief = [];
while ($row = $result->fetch_assoc()) {
    $relief[] = $row;
}

echo json_encode($relief);
$conn->close();
?>
