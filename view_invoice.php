<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['shop_id'])) {
    header("Location: login.php");
    exit();
}

$sale_id = $_GET['sale_id'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Invoice</h1>

    <?php
    if ($sale_id) {
        $sql = "SELECT s.sale_id, s.sale_date, s.sale_total, sp.part_name, sp.part_price, si.quantity
                FROM sales s
                JOIN sale_items si ON s.sale_id = si.sale_id
                JOIN spare_parts sp ON si.part_id = sp.part_id
                WHERE s.sale_id = ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sale_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Order Details</h2>";
            echo "<table><tr><th>Part Name</th><th>Price</th><th>Quantity</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['part_name']) . "</td><td>$" . htmlspecialchars($row['part_price']) . "</td><td>" . htmlspecialchars($row['quantity']) . "</td></tr>";
            }
            echo "<tr><td colspan='2'>Total</td><td>$" . htmlspecialchars($row['sale_total']) . "</td></tr>";
            echo "</table>";
        } else {
            echo "No details found for this invoice.";
        }

        $stmt->close();
    } else {
        echo "Invalid sale ID.";
    }

    $conn->close();
    ?>

    <a href="view_sales_orders.php">Back to Orders</a>
</body>
</html>
