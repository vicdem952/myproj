<?php
include 'db_connection.php';

// Fetch spare parts
$sql = "SELECT * FROM spare_parts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Spare Parts</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="catalog.css">
</head>
<body>
    <header>
        <h1>Browse Spare Parts</h1>
        <nav>
            <!-- Navigation Links -->
            <ul>
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <li><a href="view_cart.php">View Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="spare-parts">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="spare-part">
                    <h2><?php echo htmlspecialchars($row['part_name'] ?? ''); ?></h2>
                    <p><?php echo htmlspecialchars($row['description'] ?? ''); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price'] ?? ''); ?></p>
                    <p>In Stock: <?php echo htmlspecialchars($row['stock_quantity'] ?? ''); ?></p>
                    <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
