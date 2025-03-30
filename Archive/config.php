<?php
$servername = "localhost";
$username = "root";
$password = "6495";
$dbname = "disaster_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
