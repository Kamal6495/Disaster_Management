<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<!-- Toggle Button for Small Screens -->
<button id="toggleSidebar" class="btn">☰ Menu</button>

<!-- Sidebar -->
<nav class="sidebar d-lg-block">
    <div class="container">
        <a class="navbar-brand text-white d-block mb-3" href="index.php">Disaster Management</a>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

<script>
    // Toggle sidebar on small screens
    document.getElementById("toggleSidebar").addEventListener("click", function() {
        let sidebar = document.querySelector(".sidebar");
        sidebar.style.display = (sidebar.style.display === "block") ? "none" : "block";
    });
</script>

</body>
</html>
