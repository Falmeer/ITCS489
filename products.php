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
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
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
            background: #82c2e2;
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
                    <li><a href="products.php" class="current">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <form method="GET" action="products.php">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>
                </ul>
            </nav>

        </div>
    </header>

    <section id="showcase">
        <div class="container">
            <h1>Products</h1>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <img src="images/<?php echo $product['image']?>">
                        <br>
                        <a href="product_detail.php?id=<?= $product['id'] ?>"><?= $product['name'] ?></a>
                        (<?= $product['price'] ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Supermarket &copy; 2024</p>
        </div>
    </footer>
</body>
</html>
