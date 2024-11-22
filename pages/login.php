<?php
session_start();
include "../config/User.php";

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $user->validateUser ($username, $password);

    if ($result->rowCount() > 0) {
        $userData = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $userData['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red;'> username atau password Invalid.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PlayStation</title>
    <link rel="stylesheet" type="text/css" href="../Design/style.css?v=2.0">
</head>
<body>
    <div class="container">
        <h2>Login Waroeng PlayStation</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required><br>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Tidak Punya Akun? <a href="register.php">Register Disini</a></p>
    </div>
</body>
</html>