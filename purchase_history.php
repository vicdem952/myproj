<?php
require 'db_connection.php';
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login_customer.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch purchase history
$sql = "SELECT sales.sale_id, sales.sale_date, sales.sale_total, 
        sale_items.quantity, spare_parts.part_name, spare_parts.part_price 
        FROM sales 
        JOIN sale_items ON sales.sale_id = sale_items.sale_id 
        JOIN spare_parts ON sale_items.part_id = spare_parts.part_id 
        WHERE sales.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$purchases = [];
while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}

$stmt->close();
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
    </header>
    <main>
        <h2>Purchase History</h2>
        <?php if (!empty($purchases)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Sale Date</th>
                        <th>Part Name</th>
                        <th>Quantity</th>
                        <th>Part Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchases as $purchase): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($purchase['sale_date']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['part_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($purchase['part_price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars(number_format($purchase['quantity'] * $purchase['part_price'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No purchase history available.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
