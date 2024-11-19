<?php
session_start();

// If a user is logged in, log them out when accessing admin page
if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Database connection settings
$dbHost = "localhost";
$dbUser = "root"; // Replace with your DB username
$dbPass = "";     // Replace with your DB password
$dbName = "bakery"; // Replace with your DB name

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle admin login form submission
$loginError = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminEmail = $_POST['email'];
    $adminPassword = $_POST['password'];

    // Query to fetch admin details
    $sql = "SELECT * FROM admin WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password (hashed comparison)
        if (hash("sha256", $adminPassword) === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin_panel.php");
            exit();
        } else {
            $loginError = "Invalid password.";
        }
    } else {
        $loginError = "Admin not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
            </div>
        </div>
    </nav>

    <!-- Admin Login Form -->
    <div class="container my-5">
        <h2 class="text-center">Admin Login</h2>
        <?php if ($loginError): ?>
            <div class="alert alert-danger"><?php echo $loginError; ?></div>
        <?php endif; ?>
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
