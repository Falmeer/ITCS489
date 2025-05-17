<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("UPDATE products SET quantity = ? WHERE id = ?");
    if ($stmt->execute([$quantity, $id])) {
        header("Location: manage_inventory.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
