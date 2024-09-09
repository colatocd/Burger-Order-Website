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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRGRS - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Box Icons and Remix Icons for UI elements -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: url('img/bg.png') no-repeat center center fixed; 
        background-size: cover; /* Cover the entire page */
        color: var(--text-color);
        font-family: 'Afacad', sans-serif;
    }
    .welcome {
        font-size: 4em;
        animation: fadeInScale 1.5s ease-out forwards;
    }
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

</head>
<body>
    <header>
        <a href="admin.php" class="logo">
            <img src="img/logo.png">
        </a>
        <ul class="navbar">
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin_drops.php">Drops</a></li>
        </ul>
        <div class="nav-right">
            <a href="logout.php" class="logout-btn"><i class="ri-logout-box-line"></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>
    <div class="welcome">Welcome, Admin</div>
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
