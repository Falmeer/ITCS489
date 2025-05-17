<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("UPDATE products SET quantity = ? WHERE id = ?");
    if ($stmt->execute([$quantity, $id])) {
      header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
