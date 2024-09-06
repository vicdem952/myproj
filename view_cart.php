<?php
session_start();
include 'db_connection.php';

// Check if the customer is logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.html");
    exit();
}

// Retrieve cart items from session and ensure it's an array
$cart_items = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    // Check if $item is an array and has the required keys
    if (is_array($item) && isset($item['part_price'], $item['quantity'])) {
        $total_amount += $item['part_price'] * $item['quantity'];
    }
}

// Remove item from cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $part_id_to_remove = $_POST['part_id'];
    foreach ($cart_items as $index => $item) {
        if (isset($item['part_id']) && $item['part_id'] == $part_id_to_remove) {
            unset($cart_items[$index]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($cart_items); // Update session cart
    header("Location: view_cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="browse_parts.php">Browse Parts</a></li>
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (!empty($cart_items)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['part_name'] ?? ''); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['part_price'] ?? 0, 2)); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity'] ?? 0); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format(($item['part_price'] ?? 0) * ($item['quantity'] ?? 0), 2)); ?></td>
                            <td>
                                <form action="view_cart.php" method="POST">
                                    <input type="hidden" name="part_id" value="<?php echo htmlspecialchars($item['part_id'] ?? ''); ?>">
                                    <button type="submit" name="remove">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total Amount: $<?php echo number_format($total_amount, 2); ?></h3>
            <a href="checkout.php" class="button">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
            <a href="browse_parts.php" class="button">Continue Shopping</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
