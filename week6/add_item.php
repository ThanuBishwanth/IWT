<?php
session_start();

// Redirect to admin login if not logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $cost_per_piece = floatval($_POST['cost_per_piece']);
    $calories_per_piece = intval($_POST['calories_per_piece']);
    $number_of_pieces_available = intval($_POST['number_of_pieces_available']);

    // Handle image upload
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
        }
        $image_url = $upload_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_url);
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'bakery'); // Update credentials
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert item into the database with error handling
    $stmt = $conn->prepare("INSERT INTO items (name, type, cost_per_piece, calories_per_piece, number_of_pieces_available, image_url) VALUES (?, ?, ?, ?, ?, ?)");

    // Check if prepare() failed
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssddis", $name, $type, $cost_per_piece, $calories_per_piece, $number_of_pieces_available, $image_url);

    if ($stmt->execute()) {
        $message = 'Item added successfully!';
    } else {
        $message = 'Error adding item: ' . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
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
                    <li class="nav-item"><a class="nav-link" href="admin_panel.php">Admin Panel</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-danger" href="admin_panel.php?action=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Add Item Form -->
    <div class="container mt-5">
        <h1 class="text-center">Add Item</h1>
        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="mt-4" style="max-width: 600px; margin: 0 auto;">
            <div class="mb-3">
                <label for="name" class="form-label">Item Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Item Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="cakes">Cakes</option>
                    <option value="cookies">Cookies</option>
                    <option value="pastries">Pastries</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cost_per_piece" class="form-label">Cost Per Piece</label>
                <input type="number" name="cost_per_piece" id="cost_per_piece" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="calories_per_piece" class="form-label">Calories Per Piece</label>
                <input type="number" name="calories_per_piece" id="calories_per_piece" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="number_of_pieces_available" class="form-label">Number of Pieces Available</label>
                <input type="number" name="number_of_pieces_available" id="number_of_pieces_available" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Item</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 Online Bakery. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
