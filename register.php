<?php
require 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!preg_match("/^[a-zA-Z]{5,10}$/", $username)) {
        die("Invalid username");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'customer')");
    if ($stmt->execute([$username, $hashed_password])) {
        echo "Registration successful";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<a href="index.html" >login</a>
