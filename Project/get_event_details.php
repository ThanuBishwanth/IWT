<?php
$conn = new mysqli('localhost', 'root', '', 'events');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM events WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    echo json_encode($event);
} else {
    echo json_encode([]);
}

$conn->close();
?>
