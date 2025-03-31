<?php
require '../Disaster_Management/database/dbconnect.php';

// Fetch all features with properties
$query = "
    SELECT f.id AS feature_id, f.type AS feature_type, 
           p.title, p.description, p.link, p.closed, p.date, 
           p.magnitude_value, p.magnitude_unit 
    FROM features f
    JOIN properties p ON f.id = p.feature_id
    ORDER BY p.date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NASA EONET GeoJSON Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 30px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">NASA EONET GeoJSON Events</h2>

    <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= htmlspecialchars($row['title']) ?></h4>
                <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
                <p><strong>Date:</strong> <?= $row['date'] ?></p>
                <p><strong>Magnitude:</strong> <?= $row['magnitude_value'] ? $row['magnitude_value'] . " " . $row['magnitude_unit'] : 'N/A' ?></p>
                <?php if ($row['link']) : ?>
                    <a href="<?= $row['link'] ?>" target="_blank" class="btn btn-primary">View Details</a>
                <?php endif; ?>

                <!-- Fetch and Display Categories -->
                <?php
                $feature_id = $row['feature_id'];
                $category_query = "SELECT title FROM categories WHERE property_id = (SELECT id FROM properties WHERE feature_id = $feature_id)";
                $category_result = $conn->query($category_query);
                if ($category_result->num_rows > 0) :
                ?>
                    <p><strong>Categories:</strong>
                        <?php while ($cat = $category_result->fetch_assoc()) : ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($cat['title']) ?></span>
                        <?php endwhile; ?>
                    </p>
                <?php endif; ?>

                <!-- Fetch and Display Sources -->
                <?php
                $source_query = "SELECT source_id, url FROM sources WHERE property_id = (SELECT id FROM properties WHERE feature_id = $feature_id)";
                $source_result = $conn->query($source_query);
                if ($source_result->num_rows > 0) :
                ?>
                    <p><strong>Sources:</strong>
                        <?php while ($src = $source_result->fetch_assoc()) : ?>
                            <a href="<?= $src['url'] ?>" target="_blank" class="badge bg-info"><?= htmlspecialchars($src['source_id']) ?></a>
                        <?php endwhile; ?>
                    </p>
                <?php endif; ?>

                <!-- Fetch and Display Geometry -->
                <?php
                $geo_query = "SELECT id, type FROM geometry WHERE feature_id = $feature_id";
                $geo_result = $conn->query($geo_query);
                if ($geo_result->num_rows > 0) :
                ?>
                    <p><strong>Geometry Type:</strong>
                        <?php while ($geo = $geo_result->fetch_assoc()) : ?>
                            <?= htmlspecialchars($geo['type']) ?>
                        <?php endwhile; ?>
                    </p>

                    <p><strong>Coordinates:</strong>
                        <?php
                        $geo_id = $geo['id'];
                        $coord_query = "SELECT latitude, longitude FROM geometry_coordinates WHERE geometry_id = $geo_id";
                        $coord_result = $conn->query($coord_query);
                        while ($coord = $coord_result->fetch_assoc()) :
                        ?>
                            <span class="badge bg-success">(<?= $coord['latitude'] ?>, <?= $coord['longitude'] ?>)</span>
                        <?php endwhile; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
