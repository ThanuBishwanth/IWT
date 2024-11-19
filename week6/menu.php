<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bakery'); // Update with your actual database credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all distinct item types
$type_query = "SELECT DISTINCT type FROM items";
$type_result = $conn->query($type_query);
$item_types = $type_result->fetch_all(MYSQLI_ASSOC);

// Capture filter values
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$filter_sort = isset($_GET['filter_sort']) ? $_GET['filter_sort'] : '';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;

// Build SQL query with filters
$sql = "SELECT * FROM items WHERE 1";

if (!empty($filter_type)) {
    $sql .= " AND type = '$filter_type'";
}

if ($min_price > 0) {
    $sql .= " AND cost_per_piece >= $min_price";
}

if ($max_price > 0) {
    $sql .= " AND cost_per_piece <= $max_price";
}

switch ($filter_sort) {
    case 'cost_asc':
        $sql .= " ORDER BY cost_per_piece ASC";
        break;
    case 'cost_desc':
        $sql .= " ORDER BY cost_per_piece DESC";
        break;
    case 'calories_asc':
        $sql .= " ORDER BY calories_per_piece ASC";
        break;
    case 'calories_desc':
        $sql .= " ORDER BY calories_per_piece DESC";
        break;
}

// Execute the filtered query
$items_result = $conn->query($sql);
$items = $items_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        /* Ensure all cards have the same height */
        .card {
            height: 400px; /* Set fixed height for uniformity */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            height: 200px; /* Ensure image takes up a fixed height */
            object-fit: cover; /* Crop and cover the image while maintaining its aspect ratio */
        }

        /* Ensure card body content adjusts properly */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1; /* Allow the body to take up available space */
        }
    </style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $isLoggedIn ? 'cart.php' : 'login.php'; ?>">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $isLoggedIn ? 'logout.php' : 'login.php'; ?>">
                            <?php echo $isLoggedIn ? 'Logout' : 'Login'; ?>
                        </a>
                    </li>
                </ul>
                <!-- Filter Form -->
                <form class="d-flex" method="GET" action="menu.php">
                    <select name="filter_type" class="form-select me-2">
                        <option value="">Type</option>
                        <option value="cakes" <?php echo $filter_type == 'cakes' ? 'selected' : ''; ?>>Cakes</option>
                        <option value="cookies" <?php echo $filter_type == 'cookies' ? 'selected' : ''; ?>>Cookies</option>
                        <option value="pastries" <?php echo $filter_type == 'pastries' ? 'selected' : ''; ?>>Pastries</option>
                    </select>
                    <select name="filter_sort" class="form-select me-2">
                        <option value="">Sort</option>
                        <option value="cost_asc" <?php echo $filter_sort == 'cost_asc' ? 'selected' : ''; ?>>Cost: Low to High</option>
                        <option value="cost_desc" <?php echo $filter_sort == 'cost_desc' ? 'selected' : ''; ?>>Cost: High to Low</option>
                        <option value="calories_asc" <?php echo $filter_sort == 'calories_asc' ? 'selected' : ''; ?>>Calories: Low to High</option>
                        <option value="calories_desc" <?php echo $filter_sort == 'calories_desc' ? 'selected' : ''; ?>>Calories: High to Low</option>
                    </select>
                    <input type="number" name="min_price" class="form-control me-2" placeholder="Min Price" value="<?php echo $min_price > 0 ? $min_price : ''; ?>">
                    <input type="number" name="max_price" class="form-control me-2" placeholder="Max Price" value="<?php echo $max_price > 0 ? $max_price : ''; ?>">
                    <button class="btn btn-outline-primary" type="submit">Filter</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center">Our Bakery Items</h1>
        <?php foreach ($item_types as $type): ?>
            <section class="mt-4">
                <h2 class="text-center text-capitalize"><?php echo $type['type']; ?></h2>
                <div class="row">
                    <?php
                    // Display items for the current type
                    foreach ($items as $item):
                        if ($item['type'] === $type['type']): ?>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="<?php echo $item['image_url']; ?>" class="card-img-top" alt="<?php echo $item['name']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                        <p class="card-text">Cost: ₹<?php echo $item['cost_per_piece']; ?></p>
                                        <p class="card-text">Calories: <?php echo $item['calories_per_piece']; ?> kcal</p>
                                        <form method="POST" action="add_to_cart.php">
                                            <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                            <input type="number" name="quantity" class="form-control mb-2" placeholder="Quantity" min="1" value="1" required>
                                            <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
