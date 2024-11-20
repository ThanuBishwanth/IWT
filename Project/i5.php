<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'events');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date to filter past events
$today = date('Y-m-d');

// Fetch upcoming events from the database (events with a date later than today)
$sql = "SELECT * FROM events WHERE date >= '$today'";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events@PU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }

        nav {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            margin: 0 20px;
        }

        nav ul li {
            flex: 1;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border-radius: 10px;
        }

        nav ul li a:hover {
            background-color: #d7e518;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            padding: 20px;
            color: #3498db;
            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.1);
        }

        .event-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .event-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .event-card:hover {
            transform: scale(1.03);
        }

        .event-card img {
            width: 100%;
            border-radius: 10px;
        }

        .event-info h3 {
            margin: 15px 0 5px;
            color: #3498db;
        }

        .event-info p {
            margin: 0;
            color: #666;
        }

        /* Modal Styles */
        #modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        #modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        #modal-content img {
            max-width: 100%;
            margin-bottom: 20px;
        }

        #modal iframe {
            width: 100%;
            height: 500px;
        }

        #close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#festives"><i class="fas fa-gift"></i> Festives</a></li>
            <li><a href="#events"><i class="fas fa-calendar-alt"></i> Events</a></li>
            <li><a href="#tournaments"><i class="fas fa-trophy"></i> Tournaments</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                <li><a href="add_event.php"><i class="fas fa-plus-circle"></i> Add Event</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="login.html" target="_blank"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>Events@PU</h1>

    <div class="event-cards">
        <?php foreach ($events as $event): ?>
            <div class="event-card" onclick="showDetails('<?= $event['id'] ?>')">
                <img src="<?= $event['card_url'] ?>" alt="<?= $event['name'] ?>">
                <div class="event-info">
                    <h3><?= $event['name'] ?></h3>
                    <p><?= $event['date'] ?></p>
                    <p><?= $event['venue'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal -->
    <div id="modal">
        <div id="modal-content">
            <span id="close-modal">&times;</span>
            <iframe id="broucher" src="" frameborder="0"></iframe>
            <div id="qr-code"></div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const broucherFrame = document.getElementById('broucher');
        const qrCodeDiv = document.getElementById('qr-code');
        const closeModal = document.getElementById('close-modal');

        closeModal.onclick = function() {
            modal.style.display = 'none';
        }

        function showDetails(eventId) {
            fetch('get_event_details.php?id=' + eventId)
            .then(response => response.json())
            .then(data => {
                broucherFrame.src = data.broucher_url;
                qrCodeDiv.innerHTML = data.qr_code_url ? `<img src="${data.qr_code_url}" alt="QR Code for Donations">` : '';
                modal.style.display = 'flex';
            });
        }
    </script>
</body>
</html>
