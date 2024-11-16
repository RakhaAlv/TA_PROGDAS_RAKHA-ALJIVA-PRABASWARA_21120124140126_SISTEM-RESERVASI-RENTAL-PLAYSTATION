<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome to the Dashboard</h2>
        <div class="menu">
            <a href="book.php" class="menu-button">Book a PlayStation</a>
            <a href="logout.php" class="menu-button">Logout</a>
        </div>
    </div>
</body>
</html>