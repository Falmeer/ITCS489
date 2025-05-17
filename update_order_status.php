<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $id])) {
        header("Location: manage_orders.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
