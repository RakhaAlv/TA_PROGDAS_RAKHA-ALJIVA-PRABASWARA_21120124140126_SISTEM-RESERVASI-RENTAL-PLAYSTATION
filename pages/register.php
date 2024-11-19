<?php
session_start();
include "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_user_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        echo "<p class='error-message'>Username sudah ada.</p>";
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="register-container">
        <h2>Buat Akun</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required><br>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>
</body>
</html>