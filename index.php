<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="welcome-container">
        <h1>SELAMAT DATANG WAROENG PLAYSTATION </h1>
        <div class="button-container">
            <a href="pages/login.php" class="futuristic-button">Login</a>
            <a href="pages/register.php" class="futuristic-button">Register</a>
        </div>
    </div>
</body>
</html>