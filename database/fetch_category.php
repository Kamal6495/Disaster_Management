<?php
require_once '../assets/key/config.php';
    $url = EONET_Event_CATEGORY;
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "EonetCategory";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert categories into database
    foreach ($data['categories'] as $category) {
        $id = $conn->real_escape_string($category['id']);
        $title = $conn->real_escape_string($category['title']);
        $link = $conn->real_escape_string($category['link']);
        $description = $conn->real_escape_string($category['description']);
        $layers = $conn->real_escape_string($category['layers']);
        
        $sql = "INSERT INTO Category (id, title, link, description, layers) 
                VALUES ('$id', '$title', '$link', '$description', '$layers')
                ON DUPLICATE KEY UPDATE title='$title', link='$link', description='$description', layers='$layers'";
        $conn->query($sql);
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EONET Event Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">EONET Event Categories</h2>
        <div class="row">
            <?php foreach ($data['categories'] as $category) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $category['title']; ?></h5>
                            <p class="card-text"><?php echo $category['description']; ?></p>
                            <a href="<?php echo $category['link']; ?>" class="btn btn-primary" target="_blank">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>