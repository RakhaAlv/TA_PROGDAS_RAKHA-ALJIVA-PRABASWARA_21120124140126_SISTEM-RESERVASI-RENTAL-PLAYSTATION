<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['booking_id'])) {
    header("Location: login.php");
    exit;
}

$booking_id = $_GET['booking_id'];

// Ambil detail booking untuk menampilkan informasi kepada pengguna
$booking_query = "SELECT * FROM bookings WHERE id = $booking_id";
$booking_result = $conn->query($booking_query);
$booking = $booking_result->fetch_assoc();

if (!$booking) {
    echo "<p class='error-message'>Booking not found.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount']; // Ambil jumlah yang dimasukkan pengguna
    $total_amount = $booking['total_amount']; // Ambil total_amount dari booking

    // Periksa apakah jumlah yang dimasukkan sesuai dengan total_amount
    if ($amount == $total_amount) {
        // Simpan informasi pembayaran ke database
        $insert_payment_query = "INSERT INTO payments (booking_id, amount, payment_status) VALUES ('$booking_id', '$amount', 'completed')";
        if ($conn->query($insert_payment_query) === TRUE) {
            // Alihkan ke halaman sukses pembayaran
            header("Location: payment_success.php?booking_id=$booking_id");
            exit;
        } else {
            echo "<p class='error-message'>Error: " . $conn->error . "</p>";
        }
    } else {
        // Jika jumlah tidak sesuai, batalkan booking
        $delete_booking_query = "DELETE FROM bookings WHERE id = $booking_id";
        $conn->query($delete_booking_query);
        echo "<p class='error-message'>Payment failed! Amount does not match. Your booking has been canceled.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="payment-container">
        <h2>Payment for Booking ID: <?php echo $booking_id; ?></h2>
        <p>PlayStation Type: <?php echo $booking['playstation_type']; ?></p>
        <p>Booking Time: <?php echo $booking['booking_time']; ?></p>
        <p>Duration: <?php echo $booking['duration']; ?> hours</p>
        <p>Total Amount: Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
        
        <form method="POST" action="">
            <input type="number" name="amount" placeholder="Enter amount" required><br>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>