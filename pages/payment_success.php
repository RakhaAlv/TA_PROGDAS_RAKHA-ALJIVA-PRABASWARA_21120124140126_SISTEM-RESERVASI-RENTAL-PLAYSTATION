<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil informasi booking dari session atau query string (booking_id)
$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    echo "<p class='error-message'>Booking not found.</p>";
    exit;
}

// Ambil detail booking untuk menampilkan informasi kepada pengguna
$booking_query = "SELECT * FROM bookings WHERE id = $booking_id";
$booking_result = $conn->query($booking_query);
$booking = $booking_result->fetch_assoc();

if (!$booking) {
    echo "<p class='error-message'>Booking not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="success-container">
        <h1>Berhasil Melakukan Pembayaran</h1>
        <p class="success-message">Selamat bermain!</p>
        <p>PlayStation Type: <?php echo $booking['playstation_type']; ?></p>
        
        <div class="button-container">
            <a href="dashboard.php" class="menu-button">Kembali ke Dashboard</a>
        </div>

        <h2>Detail Booking</h2>
        <p><strong>Booking ID:</strong> <?php echo $booking['id']; ?></p>
        <p><strong>Waktu Booking:</strong> <?php echo $booking['booking_time']; ?></p>
        <p><strong>Durasi:</strong> <?php echo $booking['duration']; ?> jam</p>
        <p><strong>Total Biaya:</strong> Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
    </div>
</body>
</html>