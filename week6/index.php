<?php

session_start();
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bakery</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            background-image: url('img5.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-top: 1rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .btn-custom {
            background-color: #f76c6c;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #e55b5b;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 40px;
        }


        .contact-card {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
        }
    </style>
</head>

<body>
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
            
           
        </div>
    </div>
</nav>
    <!-- Hero Section -->
    <section class="hero-section">
        <h1>Welcome to Our Online Bakery</h1>
        <p>Delicious Cakes, Cookies, and Pastries Delivered Fresh to Your Doorstep</p>
        <a href="#menu" class="btn btn-custom mt-4">Explore Our Menu</a>
    </section>

    <!-- About Us Section -->
    <section class="container py-5">
        <h2 class="text-center section-title">Why Choose Us?</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <img src="Ingredients.jpg" class="img-fluid rounded-circle mb-3" alt="Quality Ingredients">
                <h4>Fresh Ingredients</h4>
                <p>We use only the freshest and finest ingredients in all our products to ensure the best taste and quality.</p>
            </div>
            <div class="col-md-4">
                <img src="handmade.png" class="img-fluid rounded-circle mb-3" alt="Quality Ingredients">
                <h4>Handmade With Love</h4>
                <p>All our bakery items are handmade with love, bringing you the warm taste of home in every bite.</p>
            </div>
            <div class="col-md-4">
                <img src="delivery.jpg" class="img-fluid rounded-circle mb-3" alt="Quality Ingredients">
                <h4>Quick Delivery</h4>
                <p>Enjoy the convenience of quick and efficient delivery right to your doorstep, ensuring freshness every time.</p>
            </div>
        </div>
    </section>

   

    <!-- Contact Us Card -->
    <section class="container my-5">
        <div class="contact-card text-center">
            <h3>Contact Us</h3>
            <p>Have any questions or special requests? We would love to hear from you!</p>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> support@onlinebakery.com</li>
                <li><strong>Phone:</strong> +91 98765 43210</li>
                <li><strong>Address:</strong> 123, Sweet Street, Cake Town, India</li>
            </ul>
            <a href="contact.php" class="btn btn-custom">Get In Touch</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 Online Bakery. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
