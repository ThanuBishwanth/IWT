<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'events');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$student_id = $_POST['student_id'];
$password = $_POST['password'];

// Hash the password for comparison
$hashed_password = md5($password); // Ensure to hash the password

// Query the database to check if the student ID and password match
$sql = "SELECT * FROM users WHERE student_id = '$student_id' AND password = '$hashed_password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User exists, set session variable
    $_SESSION['logged_in'] = true;
    $_SESSION['student_id'] = $student_id;
    header("Location: index.php");
} else {
    echo "Invalid student ID or password.";
    echo "<br><a href='login.html'>Try Again</a>";
}

$conn->close();
?>
