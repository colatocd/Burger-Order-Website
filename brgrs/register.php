<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
    <a href="#" class="logo">
			<img src="img/logo.png"> <!-- Ensure the logo points to your preferred image -->
		</a>
</header>

    <div class="form-container">
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="register">Register</button>
            <button onclick="location.href='login2.php'">Back to Login</button>
        </form>
        <div class="form-buttons">
</div>
    </div>

    <script>
        // Add any JavaScript here if needed
    </script>
</body>
</html>

<?php

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $phoneNumber = filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_NUMBER_INT);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $type = "customer";

        $sql = "INSERT INTO users(user_name, first_name, last_name, phone, password, type) VALUES (:username, :firstName, :lastName, :phoneNumber, :password, :type)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':type', $type);

        if($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

    }

    $conn = null;
?>
