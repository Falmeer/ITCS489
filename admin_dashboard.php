<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        a {
            display: block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 15px 25px;
            border-radius: 5px;
            text-align: center;
            font-size: 1.2em;
            margin: 10px auto;
            width: 200px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        .container {
            text-align: center;
        }
</style>

</head>
<body>
    <h1>Welcome, Admin</h1>
	<br>
	<br>
    <a href="create_staff.php">Create Staff User</a>
	<br>
	<br>
    <a href="manage_inventory.php">Manage Inventory</a>
	<br>
	<br>
    <a href="logout.php">Logout</a>

</body>
</html>
