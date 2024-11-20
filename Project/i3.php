<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'events');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            color: #333;
        }
        
        nav {
            background-color: #2c3e50;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 40px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        nav ul li a:hover {
            background-color: #3498db;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
            font-size: 3em;
            color: #34495e;
            letter-spacing: 2px;
        }

        .section-title {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Event Card Container */
        .event-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        /* Event Card Styling */
        .event-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 320px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
        }

        .event-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-info {
            padding: 20px;
        }

        .event-info h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .event-info p {
            margin: 0;
            color: #7f8c8d;
        }

        /* Modal Styling */
        #modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #modal-content {
            background-color: #fff;
            padding: 30px;
            width: 60%;
            max-width: 900px;
            border-radius: 15px;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        #close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5em;
            cursor: pointer;
            color: #e74c3c;
        }

        iframe {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        #qr-code img {
            margin-top: 20px;
            max-width: 150px;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="#festives">Festives</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="#tournaments">Tournaments</a></li>
            <li><a href="#seminars">Seminars</a></li>
            <li><a href="add_event.php">Add Event</a></li>
        </ul>
    </nav>

    <h1>Events@PU</h1>

    <section id="festives">
        <h2 class="section-title">Festives</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'festive'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>')">
                        <img src="<?= $event['card_url'] ?>" alt="<?= $event['name'] ?>">
                        <div class="event-info">
                            <h3><?= $event['name'] ?></h3>
                            <p><?= $event['date'] ?></p>
                            <p><?= $event['venue'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="events">
        <h2 class="section-title">Events</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'event'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>')">
                        <img src="<?= $event['card_url'] ?>" alt="<?= $event['name'] ?>">
                        <div class="event-info">
                            <h3><?= $event['name'] ?></h3>
                            <p><?= $event['date'] ?></p>
                            <p><?= $event['venue'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Add other sections similarly (Tournaments, Seminars) -->

    <div id="modal">
        <div id="modal-content">
            <span id="close-modal">&times;</span>
            <iframe id="broucher"></iframe>
            <div id="qr-code"></div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Pondicherry University Events. All rights reserved.</p>
    </footer>

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
