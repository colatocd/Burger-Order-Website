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
    <title>BRGRS - Recent Orders</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <!-- Box Icons, Remix Icons, and Google Fonts -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <a href="index.php" class="logo"><img src="img/logo.png"></a>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="drops.php">Drops</a></li>
            <li><a href="orders.php" class="active">Orders</a></li>
        </ul>
        <div class="nav-right">
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <div class="orders-container">
        <h1>Recent Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Burger</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT o.order_ID, o.burger, o.date, b.price FROM Orders AS o JOIN Burgers AS b ON o.burger = b.name WHERE user_name = :username ORDER BY o.order_ID ASC";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $_SESSION['username']);
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($orders) {
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>{$order['order_ID']}</td>";
                        echo "<td>{$order['date']}</td>";
                        echo "<td>{$order['burger']}</td>";
                        echo "<td>$" . number_format($order['price'], 2) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No orders found.</td></tr>";
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
