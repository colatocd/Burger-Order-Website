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
    <title>BRGRS - Account</title>
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
            <li><a href="account.php" class="active">Account</a></li>
            <li><a href="drops.php">Drops</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>

        <div class="nav-right">
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <div class="form-container">
        <form action="add_payment.php" method="POST">
            <h2>Add Card Details</h2>
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="creditCardNumber">Credit Card Number:</label>
                <input type="text" id="creditCardNumber" name="creditCardNumber" required>
            </div>
            <div class="form-group">
                <label for="ccv">CCV:</label>
                <input type="text" id="ccv" name="ccv" required>
            </div>
            <div class="form-group">
                <label for="expirationDate">Expiration Date:</label>
                <input type="date" id="expirationDate" name="expirationDate" required placeholder="MM/YYYY">
            </div>
            <div class="form-buttons">
            <button type="button" onclick="window.location.href='account.php'">Edit Account Details</button>
            <button type="submit">Save Changes</button>
            <button type="button" onclick="window.location.reload();">Discard Changes</button>
        </div>
    </form>
</div>

<!-- Logout Button outside the form-container -->
<div class="logout-container">
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
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

<?php

$stmt = $conn->prepare("SELECT first_name, last_name, card_number, exp_date, CCV FROM Payment WHERE user_name = :username");
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$payment_info = $stmt->fetch(PDO::FETCH_ASSOC); // You should fetch the actual user data from your database here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // TODO: Update user details based on form input
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
    $creditCardNumber1 = filter_input(INPUT_POST, "creditCardNumber", FILTER_SANITIZE_SPECIAL_CHARS);
    $creditCardNumber = password_hash($creditCardNumber1, PASSWORD_DEFAULT);
    $expirationDate = $_POST['expirationDate'];
    $ccv = filter_input(INPUT_POST, "ccv", FILTER_SANITIZE_NUMBER_INT);

    // Check if input data is not empty
    if (!empty($creditCardNumber) && !empty($expirationDate) && !empty($ccv)) {
        // Prepare and execute update query
        $sql = "INSERT INTO Payment (user_name, card_number, first_name, last_name, exp_date, CCV) VALUES (:username, :creditCardNumber, :firstName, :lastName, :expirationDate, :ccv)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':creditCardNumber', $creditCardNumber);
        $stmt->bindParam(':expirationDate', $expirationDate);
        $stmt->bindParam(':ccv', $ccv);

        if($stmt->execute()) {
            // Fetch payment info
            $stmt1 = $conn->prepare("SELECT first_name, last_name, card_number, exp_date, CCV FROM Payment WHERE user_name = :username");
            $stmt1->bindParam(':username', $_SESSION['username']);
            $stmt1->execute();
            $payment_info = $stmt1->fetch(PDO::FETCH_ASSOC);
            
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    }

?>