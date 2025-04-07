<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;
include 'config.php';

$client = new Client($TWILIO_SID, $TWILIO_AUTH_TOKEN);
$users = $conn->query("SELECT phone FROM users");
while ($user = $users->fetch_assoc()) {
    $client->messages->create($user['phone'], [
        'from' => $TWILIO_PHONE_NUMBER,
        'body' => "Disaster Alert! Check the platform for updates."
    ]);
}
?>