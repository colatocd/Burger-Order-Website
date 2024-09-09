<?php
include("connection.php");
session_start();

$sql1 = $conn->prepare("SELECT type FROM users WHERE user_name = :username");
$sql1->bindParam(':username', $_SESSION['username']);
$sql1->execute();
$type = $sql1->fetch(PDO::FETCH_ASSOC);

if ((!isset($_SESSION['username'])) || ($type['type'] == "customer")) {
    header("Location: login2.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BRGRS - add drop</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
	<!-- Box Icons and Remix Icons for UI elements -->
	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
</head>
<body>

	<header>
		<a href="admin.php" class="logo">
			<img src="img/logo.png"> <!-- Ensure the logo points to your preferred image -->
		</a>

		<ul class="navbar">
			<li><a href="admin.php">Home</a></li>
			<li><a href="admin_drops.php">Drops</a></li>
		</ul>

		<div class="nav-right">
       <a href="logout.php" class="logout-btn"><i class="ri-logout-box-line"></i></a>
            <!-- Menu icon -->
            <div class="bx bx-menu" id="menu-icon"></div>
		</div>
	</header>
    <div class="form-container">
    <form action="process_add_drop.php" method="POST">
    <h2>Add Drop</h2>
    <div class="form-group">
        <label for="Date">Date:</label>
        <input type="date" id="date" name="date" required>
    </div>
    <div class="form-group">
        <label for="Address">Street Address:</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="Stock">Stock:</label>
        <input type="number" id="stock" name="stock" required min="1">
    </div>
    <div class="form-group">
        <label for="Start">Start Time:</label>
        <input type="time" id="start" name="start" required>
    </div>
    <div class="form-group">
        <label for="End">End Time:</label>
        <input type="time" id="end" name="end" required>
    </div>
    <div class="form-buttons">
    <button type="button" onclick="window.location.href='admin_drops.php'">View All Drops</button>
        <button type="submit">Save</button>
        <button type="button" onclick="window.location.reload();">Discard</button>
    </div>
</form>

    </div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
    let menu = document.querySelector('#menu-icon');
    let navbar = document.querySelector('.navbar');
    let today = new Date().toISOString().substr(0, 10); // Today's date in YYYY-MM-DD
    document.getElementById("date").setAttribute('min', today);

    menu.onclick = () => {
        menu.classList.toggle('bx-x');
        navbar.classList.toggle('open');
    };

        document.querySelector("form").addEventListener("submit", function(event) {
        var startTime = document.getElementById("start").value;
        var endTime = document.getElementById("end").value;
        var dateInput = document.getElementById("date").value;

        if (startTime >= endTime) {
            alert("End time must be after start time.");
            event.preventDefault();
        }

        if (new Date(dateInput) < new Date(today)) {
            alert("The date cannot be in the past.");
            event.preventDefault();
        }
    });
});
	</script>

</body>
</html>
