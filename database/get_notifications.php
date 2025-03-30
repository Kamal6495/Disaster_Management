<?php
header("Content-Type: application/json");
include 'db_connect.php';

$user_id = $_GET['user_id']; // Get user ID from request

$sql = "SELECT * FROM user_notifications WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
$conn->close();
?>
