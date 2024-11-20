<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$department = $_POST['department'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = md5($password); // Consider using password_hash() in production

// Insert the student data into the database
$sql = "INSERT INTO users (student_id, name, department, email, password) 
        VALUES ('$student_id', '$name', '$department', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    // Registration successful, redirect to login page
    header("Location: login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
