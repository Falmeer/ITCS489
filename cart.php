<?php
session_start();
require 'db.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
	<style>
	/* Reset default browser styles */
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
    background: #82c2e2 ;
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
    background: #82c2e2 ;
    color: #fff;
    text-align: center;
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
                    <li><a href="customer_dashboard.php">Dashboard</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="cart.php" class="current">Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="showcase">
        <div class="container">
            <h1>Your Cart</h1>
            <ul>
                <?php foreach ($cart as $product_id => $quantity): ?>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    $total_price += $product['price'] * $quantity;
                    ?>
                    <li>
                        <?= $product['name'] ?> (<?= $quantity ?> x <?= $product['price'] ?>) = <?= $product['price'] * $quantity ?>
                        <form method="post" action="remove_from_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="remove" class="remove-button">Remove</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Total Price: <?= $total_price ?></p>
            <a href="checkout.php" class="button">Checkout</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Supermarket &copy; 2024</p>
        </div>
    </footer>
</body>

</html>
