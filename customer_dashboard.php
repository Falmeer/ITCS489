<?php
session_start();
require 'db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

header {
    background: #333;
    color: #fff;
    padding-top: 20px;
    min-height: 70px;
    border-bottom: #262626 3px solid;
}

header #branding {
    float: left;
}

header #branding h1 {
    margin: 0;
}

header nav {
    float: right;
    margin-top: 10px;
}

header nav ul {
    list-style: none;
}

header nav ul li {
    display: inline;
    margin-right: 20px;
}

header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
}

#showcase {
    background: #333;
    color: #fff;
    padding-top: 100px;
    padding-bottom: 100px;
    text-align: center;
}

#showcase h1 {
    font-size: 36px;
}

#orders {
    margin-top: 20px;
}

#orders h2 {
    margin-bottom: 20px;
}

#orders ul {
    list-style: none;
}

#orders ul li {
    padding: 10px;
    background: #fff;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

footer {
    background: #333;
    color: #fff;
    padding: 20px 0;
    margin-top: 20px;
}

footer p {
    margin: 0;
}

	</style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Supermarket</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="customer_dashboard.php" class="current">Dashboard</a></li>
					 <li><a href="products.php">products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                   
                    <form method="GET" action="products.php">
                    <input type="text" name="search" placeholder="Search products...">
                    <button type="submit">Search</button>
                    </form>
                </ul>
            </nav>
        </div>
        <?php
            require 'db.php';

            $search = '';
            $sql = "SELECT * FROM products";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = htmlspecialchars($_GET['search']);
                $sql .= " WHERE name LIKE :search";
            }

            $stmt = $pdo->prepare($sql);

            if (!empty($search)) {
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }

            $stmt->execute();
            $products = $stmt->fetchAll();
        ?>
    </header>

    <section id="showcase">
        <div class="container">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <p>Here's your dashboard. You can view your orders below.</p>
        </div>
    </section>

    <section id="orders" class="container">
        <h2>Your Orders</h2>
        <?php if (count($orders) > 0): ?>
            <ul>
                <?php foreach ($orders as $order): ?>
                    <li>
                        Order ID: <?php echo $order['id']; ?> - Total: $<?php echo $order['total_price']; ?> - Status: <?php echo $order['status']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </section>

    <footer>
    </footer>
</body>
</html>
