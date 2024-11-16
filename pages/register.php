<?php
session_start();
include "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_user_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        echo "<p class='error-message'>Username already exists.</p>";
    } else {
        $insert_user_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_user_query) === TRUE) {
            header("Location: login.php");
            exit;
        } else {
            echo "<p class='error-message'>Error: " . $insert_user_query . "<br>" . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="register-container">
        <h2>Create an Account</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>