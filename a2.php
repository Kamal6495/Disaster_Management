<?php
// Database connection
$host = 'localhost';
$db = 'disaster_db';
$user = 'root';
$pass = 'root';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Load RSS feed
$url = "https://sachet.ndma.gov.in/cap_public_website/rss/rss_india.xml";
$xml = simplexml_load_file($url);

foreach ($xml->channel->item as $item) {
    $title = $conn->real_escape_string($item->title);
    $description = $conn->real_escape_string($item->description);
    $category = $conn->real_escape_string($item->category);
    $link = $conn->real_escape_string($item->link);
    $author = $conn->real_escape_string($item->author);
    $guid = $conn->real_escape_string($item->guid);
    $pubDate = date('Y-m-d H:i:s', strtotime($item->pubDate));

    // Insert or ignore duplicate based on GUID (permanent link identifier)
    $sql = "INSERT INTO sachet_alerts (guid, title, description, category, link, author, pubDate)
            VALUES ('$guid', '$title', '$description', '$category', '$link', '$author', '$pubDate')
            ON DUPLICATE KEY UPDATE title=VALUES(title), description=VALUES(description), category=VALUES(category), link=VALUES(link), author=VALUES(author), pubDate=VALUES(pubDate)";

    $conn->query($sql);
}

echo "RSS Feed parsed and saved successfully.";

?>
