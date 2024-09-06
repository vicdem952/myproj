<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['shop_id'])) {
    header("Location: login_shop.php");
    exit();
}

$shop_id = $_SESSION['shop_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Shop Dashboard</h1>
    
    <div class="dashboard-section">
        <h2>Manage Inventory</h2>
        <a href="view_spare_parts.php">View and Edit Spare Parts</a>
        <a href="add_spare_part.php">Add New Spare Part</a>
    </div>

    <div class="dashboard-section">
        <h2>Sales Analytics</h2>
        <a href="view_sales_reports.php">View Sales Reports</a>
    </div>

    <a href="logout.php">Logout</a>
</body>
</html>
