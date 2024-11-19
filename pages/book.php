<?php
session_start();
include "../config/Booking.php";
include "../config/user.php"; // Pastikan ini untuk mengimpor koneksi database

$database = new Database();
$conn = $database->getConnection(); // Inisialisasi koneksi database

$booking = new Booking();

$prices = [
    "PS3" => 6000,
    "PS4" => 12000,
    "PS4 Pro" => 15000,
    "PS5" => 25000,
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playstation_type = $_POST['playstation_type'];
    $booking_time = $_POST['booking_time'];
    $duration = $_POST['duration'];
    $user_id = $_SESSION['user_id'];

    // Menghitung total biaya
    $total_amount = $prices[$playstation_type] * $duration;

    // Menggunakan prepared statement untuk menghindari SQL injection
    $insert_booking_query = "INSERT INTO bookings (user_id, playstation_type, booking_time, duration, total_amount) VALUES (:user_id, :playstation_type, :booking_time, :duration, :total_amount)";
    $stmt = $conn->prepare($insert_booking_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':playstation_type', $playstation_type);
    $stmt->bindParam(':booking_time', $booking_time);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':total_amount', $total_amount);

    if ($stmt->execute()) {
        $booking_id = $conn->lastInsertId(); 

        echo "<p class='success-message'>Booking successful! Total amount: Rp " . number_format($total_amount, 0, ',', '.') . ". Please proceed to payment.</p>";
        echo "<a href='payment.php?booking_id=$booking_id' class='futuristic-button'>Proceed to Payment</a>";
    } else {
        echo "<p class='error-message'>Error: " . htmlspecialchars($stmt->errorInfo()[2]) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book a PlayStation</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=1.0">
</head>
<body>
    <div class="booking-container">
        <h2>Book a PlayStation</h2>
        <form method="POST" action="">
            <select name="playstation_type" required>
            <?php
                foreach ($prices as $type => $price) {
                    echo "<option value='$type'>$type - Rp " . number_format($price, 0, ',', '.') . " per hour</option>";
                }
                ?>
            </select><br>
            <input type="datetime-local" name="booking_time" required><br>
            <input type="number" name="duration" placeholder="Duration (hours)" required><br>
            <button type="submit">Book</button>
        </form>
    </div>
</body>
</html>