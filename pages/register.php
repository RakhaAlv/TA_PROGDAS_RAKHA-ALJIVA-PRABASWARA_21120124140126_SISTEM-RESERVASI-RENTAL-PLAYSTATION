<?php
session_start();
include "../config/User.php";

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->isUsernameTaken($username)) {
        echo "<p class='error-message'>Username sudah ada.</p>";
    } else {
        if ($user->registerUser($username, $password)) {
            header("Location: login.php");
            exit;
        } else {
            echo "<p class='error-message'>Error: Could not register user.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PlayStation</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=2.0"> 
</head>
<body>
    <div class="container">
        <h2>Silahkan Registrasi Akun Waroeng Playstation</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required><br>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Sudah Punya Akun? <a href="login.php">Login Disini</a></p>
    </div>
</body>
</html>