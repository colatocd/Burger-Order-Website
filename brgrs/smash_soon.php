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
    <title>BRGRS</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <header>
        <a href="index.php" class="logo">
            <img src="img/logo.png">
        </a>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="drops.php">Drops</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>
        <div class="nav-right">
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>
    </header>
    <section class="hero">
        <div class="hero-img" data-aos="zoom-in" data-aos-duration="2000">
            <img src="img/hero1.png" class="one">
        </div>
        <div class="hero-text">
            <h1 data-aos="fade-right" data-aos-duration="1500">SMASH <br> BURGER</h1>
            <p data-aos="flip-down" data-aos-duration="1400" data-aos-delay="200">The most delicious burger you will ever try in your life</p>
            <h5 data-aos="zoom-in" data-aos-duration="1400" data-aos-delay="300">$5.00</h5>
            <div class="hero-btnn" data-aos="flip-down" data-aos-duration="1400" data-aos-delay="400">
            <a href="#" class="btn">Coming Soon</a>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="box" data-aos="zoom-in-right" data-aos-duration="1200" data-aos-delay="100">
            <li><a href="smash_soon.php"><img src="img/hero1.png"></a></li>
        </div>
        <div class="box" data-aos="zoom-in-right" data-aos-duration="1300" data-aos-delay="200">
            <li><a href="ulti-meatum_soon.php"><img src="img/hero2.png"></a></li>
        </div>
    </div>
    <script type="text/javascript">
        function slider(anything){
            document.querySelector('.one').src = anything;
        };
        let menu = document.querySelector('#menu-icon');
        let navbar = document.querySelector('.navbar');
        menu.onclick = () => {
            menu.classList.toggle('bx-x');
            navbar.classList.toggle('open')
        }
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 1
        });
    </script>
</body>
</html>
