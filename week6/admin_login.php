<?php
session_start();

// Redirect to admin panel if already logged in as admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_panel.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Dummy admin credentials (replace with database check if needed)
    $admin_email = 'admin@bakery.com';
    $admin_password = 'admin123';

    if ($email === $admin_email && $password === $admin_password) {
        // Set session for admin
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.php');
        exit();
    } else {
        $error = 'Invalid email or password.';
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Admin Login</h1>
    <form method="POST" class="mt-4" style="max-width: 400px; margin: 0 auto;">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
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

<?php include 'footer.php'; ?>
