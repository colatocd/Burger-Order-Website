<?php
include("connection.php");
session_start();

$sql1 = $conn->prepare("SELECT type FROM users WHERE user_name = :username");
$sql1->bindParam(':username', $_SESSION['username']);
$sql1->execute();
$type = $sql1->fetch(PDO::FETCH_ASSOC);

if ((!isset($_SESSION['username'])) || ($type['type'] !== "customer")) {
    header("Location: login2.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BRGRS - Drops</title>
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
        <a href="index.php" class="logo">
            <img src="img/logo.png">
        </a>

        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="drops.php" class="active">Drops</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>
        <div class="nav-right">
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <div class="drops-container">
    <h1>Upcoming Burger Drops</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Address</th>
                <th>Stock</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT d.date, d.address, d.start_time, d.end_time, s.number_of_items FROM Drops AS d JOIN Stock AS s ON d.date = s.date ORDER BY d.date ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $drops = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($drops) {
               
foreach ($drops as $drop) {
    // Assuming $drop['start_time'] and $drop['end_time'] are fetched from the database in 24-hour format
    $startTime = date("g:i A", strtotime($drop['start_time'])); // Converts to 12-hour format with AM/PM
    $endTime = date("g:i A", strtotime($drop['end_time'])); // Converts to 12-hour format with AM/PM

    echo "<tr>";
    echo "<td>{$drop['date']}</td>";
    echo "<td><a href='smash_soon.php?address={$drop['address']}'>{$drop['address']}</a></td>";
    echo "<td>{$drop['number_of_items']}</td>";
    echo "<td>{$startTime}</td>";
    echo "<td>{$endTime}</td>";
    echo "</tr>";
}

            } else {
                echo "<tr><td colspan='5'>No upcoming drops.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


    <script>
        let menu = document.querySelector('#menu-icon');
        let navbar = document.querySelector('.navbar');

        menu.onclick = () => {
            menu.classList.toggle('bx-x');
            navbar.classList.toggle('open');
        }
    </script>

</body>
</html>
