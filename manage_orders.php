<?php
session_start();
if ($_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit;
}

require 'db.php';

$stmt = $pdo->query("SELECT orders.id, users.username, orders.status, orders.total_price FROM orders JOIN users ON orders.user_id = users.id");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
	<style>
	body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: #fff;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    max-width: 600px;
    width: 100%;
}

h1 {
    text-align: center;
    color: #333;
}

.order-list {
    list-style-type: none;
    padding: 0;
}

.order-item {
    background: #f9f9f9;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.order-info {
    font-size: 16px;
}

.order-form {
    display: flex;
    align-items: center;
}

.status-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.update-button {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

.update-button:hover {
    background: #218838;
}
</style>
</head>
<body>
    <h1>Manage Orders</h1>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                Order #<?= $order['id'] ?> by <?= $order['username'] ?> - <?= $order['total_price'] ?>
                <form method="POST" action="update_order_status.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $order['id'] ?>">
                    <select name="status">
                        <option value="acknowledged" <?= $order['status'] == 'acknowledged' ? 'selected' : '' ?>>Acknowledged</option>
                        <option value="in process" <?= $order['status'] == 'in process' ? 'selected' : '' ?>>In Process</option>
                        <option value="in transit" <?= $order['status'] == 'in transit' ? 'selected' : '' ?>>In Transit</option>
                        <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <button type="submit">Update</button>
						<br>
						<br>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>						
	<a href="employee.php">Back Home Page</a>

</body>
</html>
