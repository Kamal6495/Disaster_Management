<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/plain");

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Include Twilio config
include __DIR__ . '/assets/key/config.php';

use Twilio\Rest\Client;

// Initialize Twilio
$client = new Client($account_sid, $auth_token);

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "root", "disaster_db");
if ($mysqli->connect_error) {
    http_response_code(500);
    die("Database Connection Error: " . $mysqli->connect_error);
}

// Fetch users
$result = $mysqli->query("SELECT mobile FROM users WHERE mobile IS NOT NULL AND mobile != ''");
$response = [];

while ($row = $result->fetch_assoc()) {
    $mobile = $row['mobile'];

    if (preg_match('/^\+?[1-9]\d{9,14}$/', $mobile)) {
        try {
            $client->messages->create($mobile, [
                'from' => $twilio_number,
                'body' => "📢 Jai Maheshmati Samrayajam"
            ]);
            $response[] = "✅ Sent to: $mobile";
        } catch (Exception $e) {
            $response[] = "❌ Failed to send to $mobile: " . $e->getMessage();
        }
    } else {
        $response[] = "⚠️ Invalid number format: $mobile";
    }
}

echo implode("\n", $response);
