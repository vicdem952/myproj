<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.html");
    exit();
}

// Fetch cart items from session
$cart_items = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    if (is_array($item) && isset($item['part_price'], $item['quantity'])) {
        $total_amount += $item['part_price'] * $item['quantity'];
    }
}

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_email = $_SESSION['customer_email'];
    $sale_date = date('Y-m-d H:i:s');

    // Insert into sales table
    $sales_sql = "INSERT INTO sales (sale_date, total_amount, customer_id) VALUES (?, ?, ?)";
    $sales_stmt = $conn->prepare($sales_sql);
    $sales_stmt->bind_param("sds", $sale_date, $total_amount, $customer_email);

    if ($sales_stmt->execute()) {
        $sale_id = $sales_stmt->insert_id;

        // Insert each cart item into sale_items table
        $sale_item_sql = "INSERT INTO sale_items (sale_id, part_id, quantity) VALUES (?, ?, ?)";
        $sale_item_stmt = $conn->prepare($sale_item_sql);

        foreach ($cart_items as $item) {
            if (is_array($item) && isset($item['part_id'], $item['quantity'])) {
                $part_id = $item['part_id'];
                $quantity = $item['quantity'];
                $sale_item_stmt->bind_param("iii", $sale_id, $part_id, $quantity);
                $sale_item_stmt->execute();
            }
        }

        // Clear cart
        unset($_SESSION['cart']);

        // Redirect to order confirmation page
        header("Location: order_confirmation.php?sale_id=$sale_id");
        exit();
    } else {
        echo "Error during checkout: " . $conn->error;
    }

    $sales_stmt->close();
    $sale_item_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
        <nav>
            <!-- Navigation Links -->
        </nav>
    </header>
    <main>
        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item) {
                    if (is_array($item) && isset($item['part_name'], $item['quantity'], $item['part_price'])) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['part_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['part_price'], 2)); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['part_price'] * $item['quantity'], 2)); ?></td>
                        </tr>
                    <?php } 
                } ?>
            </tbody>
        </table>
        <h3>Total Amount: $<?php echo htmlspecialchars(number_format($total_amount, 2)); ?></h3>
        
        <form action="checkout.php" method="POST">
            <button type="submit">Confirm Order</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
