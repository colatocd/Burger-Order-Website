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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css2/style.css">
</head>
<body>
<div class="logo-container">
<a href="index.php" class="logo">
<img src="img/logo.png" alt="Logo"> 
		</a>
    </div>
<div class="container">
    <form id="checkoutForm" action="process_checkout.php" method="post">
        <div class="row">
            <div class="col">
                <h3 class="title">Payment</h3>

                <div class="inputBox">
                    <span>Cards accepted :</span>
                    <img src="img/card_img.png" alt="Accepted Credit Cards">
                </div>
                <div class="inputBox">
    <span>Payment Method :</span>
    <select name="payment_method" id="payment_method">
    <option value="default"></option>
        <option value="default">STORED PAYMENT METHOD</option>
        
        <!-- Add more options if necessary -->
    </select>
</div>

                <div class="inputBox">
                    <span>Name on card :</span>
                    <input type="text" name="name_on_card" placeholder="John Doe">
                </div>

                <div class="inputBox">
                    <span>Credit card number :</span>
                    <input type="number" name="card_number" placeholder="xxxx-xxxx-xxxx-xxxx">
                </div>

                <div class="inputBox">
                    <span>Exp month :</span>
                    <input type="text" name="exp_month" placeholder="May">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Exp year :</span>
                        <input type="number" name="exp_year" placeholder="2027">
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" name="cvv" placeholder="xxx">
                    </div>
                    
                </div>
            </div>
        </div>

        <input type="button" value="Pay Now" class="submit-btn" onclick="openPopup()">
    </form>
    <div class="popup" id="popup">
        <img src="img/tick.png">
        <h2>Thank you</h2>
        <p>Your order has been successfully processed. Thanks!</p>
        <button type="button" onclick="submitForm()">Show Orders</button>
    </div>
</div>

<script>
function openPopup() {
    document.getElementById("popup").classList.add("open-popup");
}

function submitForm() {
    document.getElementById("checkoutForm").submit();
}

function closePopup() {
    document.getElementById("popup").classList.remove("open-popup");
}
</script>

</body>
</html>
