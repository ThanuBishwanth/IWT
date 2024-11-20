<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'events');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $event_date = $_POST['event_date'];
    $event_venue = $_POST['event_venue'];

    // File upload paths
    $target_dir = "uploads/";
    
    // Upload event card image
    $card_image_name = basename($_FILES["card_image"]["name"]);
    $card_image_path = $target_dir . $card_image_name;
    move_uploaded_file($_FILES["card_image"]["tmp_name"], $card_image_path);

    // Upload brochure
    $broucher_name = basename($_FILES["broucher"]["name"]);
    $broucher_path = $target_dir . $broucher_name;
    move_uploaded_file($_FILES["broucher"]["tmp_name"], $broucher_path);

    // Upload QR code if provided
    $qr_code_path = null;
    if (!empty($_FILES["qr_code"]["name"])) {
        $qr_code_name = basename($_FILES["qr_code"]["name"]);
        $qr_code_path = $target_dir . $qr_code_name;
        move_uploaded_file($_FILES["qr_code"]["tmp_name"], $qr_code_path);
    }

    // Insert event data into database
    $sql = "INSERT INTO events (name, type, date, venue, card_url, broucher_url, qr_code_url)
            VALUES ('$event_name', '$event_type', '$event_date', '$event_venue', '$card_image_path', '$broucher_path', '$qr_code_path')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Event Registered Succesfully")</script>';
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 20px;
        }

        form {
            background-color: white;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
            display: block;
            font-size: 1.1rem;
        }

        input[type="text"],
        input[type="date"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.file-group {
            display: flex;
            align-items: center;
        }

        .form-group.file-group label {
            flex: 1;
        }

        .form-group.file-group input {
            flex: 2;
            padding: 6px;
        }

        .input-description {
            font-size: 0.85rem;
            color: #888;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }

            input[type="submit"] {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <form action="add_event.php" method="POST" enctype="multipart/form-data">
        <h1>Add New Event</h1>

        <div class="form-group">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>
        </div>

        <div class="form-group">
            <label for="event_type">Event Type:</label>
            <select id="event_type" name="event_type" required>
                <option value="festive">Festive</option>
                <option value="event">Event</option>
                <option value="tournament">Tournament</option>
                <option value="seminar">Seminar</option>
            </select>
        </div>

        <div class="form-group">
            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>
        </div>

        <div class="form-group">
            <label for="event_venue">Event Venue:</label>
            <input type="text" id="event_venue" name="event_venue" required>
        </div>

        <div class="form-group file-group">
            <label for="card_url">Event Card Image (Dimensions: 400x250px):</label>
            <input type="file" id="card_url" name="card_image" accept="image/*" required>
            <p class="input-description">Recommended: JPEG or PNG</p>
        </div>

        <div class="form-group file-group">
            <label for="broucher_url">Brochure (PDF/Image):</label>
            <input type="file" id="broucher_url" name="broucher" accept="image/*,application/pdf" required>
            <p class="input-description">Upload a PDF or Image</p>
        </div>

        <div class="form-group file-group">
            <label for="qr_code_url">QR Code (Optional for Donations):</label>
            <input type="file" id="qr_code_url" name="qr_code" accept="image/*">
        </div>

        <input type="submit" value="Add Event">
    </form>

</body>
</html>
