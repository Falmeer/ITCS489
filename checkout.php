<?php
session_start();
require 'db.php';

// Redirect to login page if not logged in or cart is empty
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    $total_price += $product['price'] * $quantity;
}

// Insert into checkout table
$stmt = $pdo->prepare("INSERT INTO checkout (user_id, total_price) VALUES (?, ?)");
$stmt->execute([$user_id, $total_price]);
$checkout_id = $pdo->lastInsertId();

// Insert into orders table
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->execute([$user_id, $total_price]);
$order_id = $pdo->lastInsertId();

// Insert into order_items table
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM products WHERE id = ?))");
    $stmt->execute([$order_id, $product_id, $quantity, $product_id]);
}

// Clear the cart
unset($_SESSION['cart']);

// Redirect to order confirmation page
header("Location: customer_dashboard.php");
exit;
?>
