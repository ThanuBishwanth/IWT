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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
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

        .event-section {
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            margin: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
        }

        .event-section h2 {
            text-align: center;
            color: #3498db;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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

        /* Sidebar Styles */
        #sidebar {
            position: fixed;
            top: 0;
            right: -300px; /* Hide the sidebar initially */
            width: 300px;
            height: 100%;
            background-color: white;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
            padding: 20px;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        #sidebar.active {
            right: 0; /* Slide in when active */
        }

        #sidebar h2 {
            margin-top: 0;
            color: #3498db;
        }

        #sidebar img {
            max-width: 100%;
            border-radius: 10px;
        }

        #sidebar p {
            margin: 10px 0;
        }

        #close-sidebar {
            cursor: pointer;
            font-size: 20px;
            color: #3498db;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#festives"><i class="fas fa-gift"></i> Festives</a></li>
            <li><a href="#events"><i class="fas fa-calendar-alt"></i> Events</a></li>
            <li><a href="#tournaments"><i class="fas fa-trophy"></i> Tournaments</a></li>
            <li><a href="#seminars"><i class="fas fa-microphone-alt"></i> Seminars</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                <li><a href="add_event.php"><i class="fas fa-plus-circle"></i> Add Event</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="login.html" target="_blank"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>Events@PU</h1>

    <!-- Festive Section -->
    <section id="festives" class="event-section">
        <h2>Festives</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'festive'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>', '<?= $event['broucher_url'] ?>')">
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

    <!-- Events Section -->
    <section id="events" class="event-section">
        <h2>Events</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'event'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>', '<?= $event['broucher_url'] ?>')">
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

    <!-- Tournaments Section -->
    <section id="tournaments" class="event-section">
        <h2>Tournaments</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'tournament'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>', '<?= $event['broucher_url'] ?>')">
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

    <!-- Seminars Section -->
    <section id="seminars" class="event-section">
        <h2>Seminars</h2>
        <div class="event-cards">
            <?php foreach ($events as $event): ?>
                <?php if ($event['type'] == 'seminar'): ?>
                    <div class="event-card" onclick="showDetails('<?= $event['id'] ?>', '<?= $event['broucher_url'] ?>')">
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

    <!-- Sidebar for QR Code -->
    <div id="sidebar">
        <span id="close-sidebar">&times; Close</span>
        <h2>Use QR to Donate</h2>
        <div id="qr-code"></div>
    </div>

    <script>
    const sidebar = document.getElementById('sidebar');
    const qrCodeDiv = document.getElementById('qr-code');
    const closeSidebar = document.getElementById('close-sidebar');

    closeSidebar.onclick = function() {
        removeSidebar();
    }

    function showDetails(eventId, brochureUrl) {
        // Open the brochure in a new tab
        window.open(brochureUrl, '_blank');

        // Fetch event details for QR code
        fetch('get_event_details.php?id=' + eventId)
        .then(response => response.json())
        .then(data => {
            qrCodeDiv.innerHTML = data.qr_code_url ? `<img src="${data.qr_code_url}" alt="QR Code for Donations">` : '<p>No QR Code available.</p>';
            sidebar.classList.add('active'); // Show the sidebar
            sidebar.style.display = 'block'; // Ensure the sidebar is displayed when opened
        });
    }

    function removeSidebar() {
        sidebar.classList.remove('active'); // Hide the sidebar
        // Remove sidebar from DOM after a short delay for smoother transition
        setTimeout(() => {
            sidebar.style.display = 'none'; // Hides the sidebar completely
        }, 300); // Duration should match the CSS transition time
    }
</script>

</body>
</html>
