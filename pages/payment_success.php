<?php
session_start();
include "../config/database.php"; 

$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    echo "<p class='error-message'>Booking not found.</p>";
    exit;
}

$booking_query = "SELECT * FROM bookings WHERE id = :booking_id";
$stmt = $conn->prepare($booking_query);
$stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
$stmt->execute();
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>Payment Berhasil</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=4.0"> 
</head>
<body>
    <div class="success-container">
        <h1>Berhasil Melakukan Pembayaran</h1>
        <p class="success-message">Selamat bermain!</p>
        <p>PlayStation Type: <?php echo htmlspecialchars($booking['playstation_type']); ?></p>
        
        <div class="button-container">
            <a href="dashboard.php" class="menu-button">Kembali ke Dashboard</a>
        </div>

        <h2>Detail Booking</h2>
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
        <p><strong>Waktu Booking:</strong> <?php echo htmlspecialchars($booking['booking_time']); ?></p>
        <p><strong>Durasi:</strong> <?php echo htmlspecialchars($booking['duration']); ?> jam</p>
        <p><strong>Total Biaya:</strong> Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
    </div>
</body>
</html>