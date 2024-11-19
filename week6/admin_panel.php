<?php
session_start();

// Redirect to admin login if not logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Logout functionality
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Online Bakery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Admin Panel Content -->
    <div class="container mt-5">
        <h1 class="text-center">Admin Panel</h1>
        <p class="text-center text-muted">Manage the bakery's inventory and operations.</p>
        
        <div class="row text-center mt-4">
            <div class="col-md-4">
                <a href="add_item.php" class="btn btn-success btn-lg w-100 mb-3">
                    <i class="bi bi-plus-circle"></i> Add Item
                </a>
            </div>
            <div class="col-md-4">
                <a href="remove_item.php" class="btn btn-danger btn-lg w-100 mb-3">
                    <i class="bi bi-trash-fill"></i> Remove Item
                </a>
            </div>
            <div class="col-md-4">
    <a href="list_users.php" class="btn btn-primary btn-lg w-100 mb-3">
        <i class="bi bi-people-fill"></i> List of Users
    </a>
</div>
            <div class="col-md-4">
                <a href="logout.php" class="btn btn-secondary btn-lg w-100 mb-3">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 Online Bakery. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
