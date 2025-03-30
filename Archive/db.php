<?php
$host = "localhost";
$user = "root";
$pass = "6495";  // Change if you have a MySQL root password
$dbname = "disaster_management";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
