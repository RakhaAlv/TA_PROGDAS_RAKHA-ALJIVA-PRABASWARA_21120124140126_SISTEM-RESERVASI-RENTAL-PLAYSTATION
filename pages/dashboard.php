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
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=2.0">
</head>
<body>
    <div class="dashboard-container">
        <h2>Selamat Datang Di Dashboard</h2>
        <div class="menu">
            <a href="book.php" class="menu-button">Booking PlayStation</a>
            <a href="logout.php" class="menu-button">Logout</a>
        </div>
    </div>
</body>
</html>