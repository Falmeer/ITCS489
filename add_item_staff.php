<?php
session_start();
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit;
}

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, category, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $description, $category, $price, $quantity, $image])) {
            echo "Product added successfully";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Failed to upload image";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
	   <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"], 
        input[type="number"], 
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <form method="POST" action="add_product.php" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br>
        Description: <input type="text" name="description" required><br>
        Category: <input type="text" name="category" required><br>
        Price: <input type="number" name="price" step="0.01" required><br>
        Quantity: <input type="number" name="quantity" required><br>
        Image: <input type="file" name="image" accept="image/*" required><br>
        <button type="submit">Add</button>
		<a href="employee.php" >Back Home Page</a>
    </form>
</body>
</html>
