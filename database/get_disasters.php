
<?php
include './assets/key/config.php';
header('Content-Type: application/json');

// Database Connection
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "disaster_db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch all disasters
$sql = "SELECT * FROM disaster_alerts";
$result = $conn->query($sql);
$disasters = [];

while ($row = $result->fetch_assoc()) {
    $disasters[] = $row;
}

echo json_encode($disasters);
$conn->close();
?>

