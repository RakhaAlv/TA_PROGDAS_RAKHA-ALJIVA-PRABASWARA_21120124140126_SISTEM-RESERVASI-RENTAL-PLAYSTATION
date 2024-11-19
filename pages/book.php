<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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


    $price_per_hour = $prices[$playstation_type];
    $total_amount = $price_per_hour * $duration;

    $insert_booking_query = "INSERT INTO bookings (user_id, playstation_type, booking_time, duration, total_amount) VALUES ('$user_id', '$playstation_type', '$booking_time', '$duration', '$total_amount')";
    
    if ($conn->query($insert_booking_query) === TRUE) {
        $booking_id = $conn->insert_id; 
        echo "<p class='success-message'>Booking successful! Total amount: Rp " . number_format($total_amount, 0, ',', '.') . ". Please proceed to payment.</p>";
        echo "<a href='payment.php?booking_id=$booking_id' class='futuristic-button'>Proceed to Payment</a>";
    } else {
        echo "<p class='error-message'>Error: " . $insert_booking_query . "<br>" . $conn->error . "</p>";
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