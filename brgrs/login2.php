<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
</head>
<header>
		<a href="#" class="logo">
			<img src="img/logo.png"> <!-- Ensure the logo points to your preferred image -->
		</a>
</header>
<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-buttons">
                <input type="submit" value="Login" class="btn">
                <button type="button" onclick="window.location.href='register.php';" class="btn">Register</button>
            </div>
        </form>
    </div>
</body>
</html>


<?php

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $conn->prepare("SELECT user_name, password, type FROM users WHERE user_name = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user["type"]=="customer"){

            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;

            if(password_verify($password, $user['password'])){
                header("location:index.php");
            }
            else{
                echo "incorrect password";
            }
        }
        elseif($user["type"]=="admin"){

            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            
            if(password_verify($password, $user['password'])){
                header("location:admin.php");
            }
            else{
                echo "incorrect password";
            }
        }
        else{
            echo "user doesn't exist";
        }
        
    }

    
    $conn = null;
?>
