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

if (isset($_GET['date'])) {
    $date = urldecode($_GET['date']); // Decode the URL-encoded date

    $stmt = $conn->prepare("DELETE FROM Drops WHERE date = ?");
    $stmt->execute([$date]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "Drop removed successfully.";
    } else {
        $_SESSION['error'] = "Failed to remove drop or drop does not exist.";
    }

    header("Location: admin_drops.php");
    exit();
}
?>
