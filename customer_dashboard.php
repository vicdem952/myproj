<?php
session_start();
include 'db_connection.php';

// Ensure the customer is logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_email = $_SESSION['customer_email'];

// Fetch customer ID from email
$customer_stmt = $conn->prepare("SELECT id FROM customers WHERE customer_email = ?");
$customer_stmt->bind_param("s", $customer_email);
$customer_stmt->execute();
$customer_stmt->bind_result($customer_id);
$customer_stmt->fetch();
$customer_stmt->close();

// Fetch purchase history
$purchase_stmt = $conn->prepare("
    SELECT sales.id, sales.sale_date, sales.total_amount, shops.shop_name AS shop_name
    FROM sales
    JOIN shops ON sales.shop_id = shops.id
    WHERE sales.customer_id = ?
    ORDER BY sales.sale_date DESC
");
$purchase_stmt->bind_param("i", $customer_id);
$purchase_stmt->execute();
$purchase_result = $purchase_stmt->get_result();

// Fetch spare parts
$spare_parts_stmt = $conn->prepare("
    SELECT id, part_number, description, price, stock_quantity
    FROM spare_parts
    WHERE stock_quantity > 0
");
$spare_parts_stmt->execute();
$spare_parts_result = $spare_parts_stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Customer Dashboard</h1>
        <nav>
            <ul>
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="purchase_history.php">Purchase History</a></li>
                <li><a href="browse_parts.php">Browse Spare Parts</a></li>
                <li><a href="view_cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Purchase History</h2>
            <?php if ($purchase_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Sale Date</th>
                            <th>Shop</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $purchase_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($row['sale_total'], 2)); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No purchase history available.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Browse Spare Parts</h2>
            <?php if ($spare_parts_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($part = $spare_parts_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($part['part_number']); ?></td>
                                <td><?php echo htmlspecialchars($part['description']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($part['price'], 2)); ?></td>
                                <td><?php echo htmlspecialchars($part['stock_quantity']); ?></td>
                                <td>
                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="part_id" value="<?php echo $part['id']; ?>">
                                        <button type="submit">Add to Cart</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No spare parts available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
