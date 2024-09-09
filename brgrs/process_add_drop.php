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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $stock = $_POST['stock'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Prepare SQL statement to insert the drop
    $stmt = $conn->prepare("INSERT INTO Drops (date, address, start_time, end_time) VALUES (:date, :address, :start, :end)");
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $stmt1 = $conn->prepare("INSERT INTO Stock (date, number_of_items) VALUES (:date, :stock)");
    $stmt1->bindParam(':date', $date);
    $stmt1->bindParam(':stock', $stock);
    $stmt1->execute();


    // Redirect back to the admin_drops.php page
    header("Location: admin_drops.php");
    exit();
}
?>
