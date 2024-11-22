<?php
session_start();

function redirectToDashboard() {
    header("Location: pages/dashboard.php");
    exit;
}

function displayButtons() {
    echo '<div class="button-container">';
    echo '<a href="pages/login.php" class="welcome-button">Login</a>';
    echo '<a href="pages/register.php" class="welcome-button">Register</a>';
    echo '</div>';
}

if (isset($_SESSION['user_id'])) {
    redirectToDashboard();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="Design/style.css?v=5.0"> 
</head>
<body>
    <div class="welcome-container">
        <h1>SELAMAT DATANG DI WAROENG PLAYSTATION </h1>
        <?php displayButtons(); ?>
    </div>
</body>
</html>