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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert data into the database
    $burger = "Smash Burger";
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO Orders (user_name, burger, date) VALUES (:username, :burger, :date)");
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->bindParam(':burger', $burger);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    // After insertion, redirect to another page
    header("Location: orders.php");
    exit();
}
?>
