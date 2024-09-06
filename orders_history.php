<?php
session_start();
include 'db_connection.php';

// Fetch order history for the logged-in customer
$customer_email = $_SESSION['customer_email'];
$sql = "SELECT * FROM sales WHERE customer_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="orders.css">
</head>
<body>
    <header>
        <h1>Order History</h1>
        <nav>
            <!-- Navigation Links -->
        </nav>
    </header>
    <main>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['sale_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['sale_total']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
