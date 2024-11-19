<?php
session_start();
include "../config/user.php"; // Pastikan ini diimpor
include "../config/booking.php"; // Jika Anda menggunakan kelas Booking

$database = new Database();
$conn = $database->getConnection(); // Inisialisasi koneksi database

if (!isset($_SESSION['user_id']) || !isset($_GET['booking_id'])) {
    header("Location: login.php");
    exit;
}

// Mengambil booking_id dari parameter GET
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null; // Menggunakan ternary operator untuk menghindari error
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
    // Pastikan untuk memvalidasi dan membersihkan input
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0; // Menggunakan floatval untuk memastikan nilai numerik
    $total_amount = $booking['total_amount']; 

    // Periksa apakah jumlah yang dimasukkan sesuai dengan total_amount
    if ($amount == $total_amount) {
        $insert_payment_query = "INSERT INTO payments (booking_id, amount, payment_status) VALUES (:booking_id, :amount, 'completed')";
        $stmt_payment = $conn->prepare($insert_payment_query);
        $stmt_payment->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt_payment->bindParam(':amount', $amount, PDO::PARAM_STR); // Menggunakan PARAM_STR untuk jumlah

        if ($stmt_payment->execute()) {
            header("Location: payment_success.php?booking_id=$booking_id");
            exit;
        } else {
            $errorInfo = $stmt_payment->errorInfo(); 
            echo "<p class='error-message'>Error: " . htmlspecialchars($errorInfo[2]) . "</p>";
        }
    } else {
        echo "<p class='error-message'>Payment failed! Amount does not match. Please enter the correct amount.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=1.0">
</head>
<body>
    <div class="payment-container">
        <h2>Payment for Booking ID: <?php echo htmlspecialchars($booking_id); ?></h2>
        <p>PlayStation Type: <?php echo htmlspecialchars($booking['playstation_type']); ?></p>
        <p>Booking Time: <?php echo htmlspecialchars($booking['booking_time']); ?></p>
        <p>Duration: <?php echo htmlspecialchars($booking['duration']); ?> hours</p>
        <p>Total Amount: Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
        
        <form method="POST" action="">
            <input type="number" name="amount" placeholder="Enter amount" required><br>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>