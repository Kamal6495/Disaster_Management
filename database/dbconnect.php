<?php
$host = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed

try {
    // Connect to GeoJson database
    $pdoGeoJson = new PDO("mysql:host=$host;dbname=GeoJSON;charset=utf8", $username, $password);
    $pdoGeoJson->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connect to EonetCategory database
    $pdoEonetCategory = new PDO("mysql:host=$host;dbname=EonetCategory;charset=utf8", $username, $password);
    $pdoEonetCategory->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to both databases successfully!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
