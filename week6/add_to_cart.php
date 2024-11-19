<?php
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page if not logged in
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $conn = new mysqli('localhost', 'root', '', 'bakery'); // Update credentials

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];

    // Check if item is already in cart
    $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND item_id = $item_id";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Update quantity if item is already in cart
        $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND item_id = $item_id";
        $conn->query($update_query);
    } else {
        // Add new item to cart
        $insert_query = "INSERT INTO cart (user_id, item_id, quantity) VALUES ($user_id, $item_id, $quantity)";
        $conn->query($insert_query);
    }

    header('Location: menu.php'); // Redirect to cart page
    exit();
}
?>

