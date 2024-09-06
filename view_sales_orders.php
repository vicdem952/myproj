<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['shop_id'])) {
    header("Location: login.php");
    exit();
}

$shop_id = isset($_SESSION['shop_id']) ? $_SESSION['shop_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Sales Orders</h1>

    <?php
    $sql = $shop_id 
        ? "SELECT * FROM sales WHERE shop_id = ?"
        : "SELECT * FROM sales";

    $stmt = $conn->prepare($sql);
    if ($shop_id) {
        $stmt->bind_param("i", $shop_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Order ID</th><th>Date</th><th>Total</th><th>Customer ID</th><th>Shop ID</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['sale_id']) . "</td><td>" . htmlspecialchars($row['sale_date']) . "</td><td>$" . htmlspecialchars($row['sale_total']) . "</td><td>" . htmlspecialchars($row['customer_id']) . "</td><td>" . htmlspecialchars($row['shop_id']) . "</td>";
            echo "<td><a href='view_invoice.php?sale_id=" . $row['sale_id'] . "'>View Invoice</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No sales orders found.";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
