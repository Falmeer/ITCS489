<?php
session_start();
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit;
}

require 'db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory</title>
	<style>
	     body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 1em;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li form {
            display: flex;
            align-items: center;
        }

        input[type="number"] {
            width: 60px;
            margin-right: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Manage Inventory</h1>
    <a href="add_product.php">Add New Product</a>
	<a href="admin_dashboard.php" >Back Home Page</a>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= $product['name'] ?> - <?= $product['quantity'] ?>
                <form method="POST" action="update_product.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="<?= $product['quantity'] ?>" required>
                    <button type="submit">Update</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
	

</body>
</html>
