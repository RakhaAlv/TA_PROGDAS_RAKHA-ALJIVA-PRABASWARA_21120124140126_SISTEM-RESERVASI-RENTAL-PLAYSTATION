<?php
include_once 'Database.php';

class Booking {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function saveBooking($user_id, $playstation_type, $booking_time, $duration, $total_amount) {
        $query = "INSERT INTO bookings (user_id, playstation_type, booking_time, duration, total_amount) VALUES (:user_id, :playstation_type, :booking_time, :duration, :total_amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':playstation_type', $playstation_type);
        $stmt->bindParam(':booking_time', $booking_time);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':total_amount', $total_amount);
        return $stmt->execute();
    }
}
?>