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
    <title>Sales Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Sales Reports</h1>

    <?php
    $sql = $shop_id 
        ? "SELECT sale_date, total_amount FROM sales WHERE shop_id = ?"
        : "SELECT s.shop_id, SUM(s.total_amount) as total_sales FROM sales s JOIN shops sh ON s.shop_id = sh.id GROUP BY s.shop_id";

    $stmt = $conn->prepare($sql);
    if ($shop_id) {
        $stmt->bind_param("i", $shop_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Date</th><th>Total Sales</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['sale_date']) . "</td><td>$" . htmlspecialchars($row['sale_total']) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No sales data available.";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
