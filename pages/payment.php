<?php
session_start();
include "../config/user.php"; 

$database = new Database();
$conn = $database->getConnection(); 

if (!isset($_SESSION['user_id']) || !isset($_GET['booking_id'])) {
    header("Location: login.php");
    exit;
}

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null; 
if (!$booking_id) {
    echo "<p class='error-message'>Booking ID tidak valid.</p>";
    exit;
}

$booking_query = "SELECT * FROM bookings WHERE id = :booking_id"; 
$stmt = $conn->prepare($booking_query);
$stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $booking = $stmt->fetch(PDO::FETCH_ASSOC); 
    if (!$booking) {
        echo "<p class='error-message'>Booking not found.</p>";
        exit;
    }
} else {
    $errorInfo = $stmt->errorInfo();
    echo "<p class='error-message'>Query failed: " . htmlspecialchars($errorInfo[2]) . "</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0; 
    $total_amount = $booking['total_amount']; 

    if ($amount == $total_amount) {
        $insert_payment_query = "INSERT INTO payments (booking_id, amount, payment_status) VALUES (:booking_id, :amount, 'completed')";
        $stmt_payment = $conn->prepare($insert_payment_query);
        $stmt_payment->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt_payment->bindParam(':amount', $amount, PDO::PARAM_STR); 

        if ($stmt_payment->execute()) {
            header("Location: payment_success.php?booking_id=$booking_id");
            exit;
        } else {
            $errorInfo = $stmt_payment->errorInfo(); 
            echo "<p class='error-message'>Error: " . htmlspecialchars($errorInfo[2]) . "</p>";
        }
    } else {
        echo "<p class='error-message'>Pembayaran Gagal! Nominal biaya yang dimasukkan tidak sesuai. Mohon untuk memasukkan nominal biaya yang sesuai.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=4.0">
</head>
<body>
    <div class="payment-container">
        <h2>Pembayaran Booking ID: <?php echo htmlspecialchars($booking_id); ?></h2>
        <p>PlayStation Type: <?php echo htmlspecialchars($booking['playstation_type']); ?></p>
        <p>Waktu Booking: <?php echo htmlspecialchars($booking['booking_time']); ?></p>
        <p>Durasi: <?php echo htmlspecialchars($booking['duration']); ?> hours</p>
        <p>Total Biaya: Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
        
        <form method="POST" action="">
            <input type="number" name="amount" placeholder="Masukkan Total Biaya" required><br>
            <button type="submit">Bayar Sekarang</button>
        </form>
    </div>
</body>
</html>