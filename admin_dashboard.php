<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

include 'navvbaradmin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <main>
        <div class="dashboard-section">
            <h2>Manage Shops</h2>
            <a href="manage_shops.php">View and Edit Shops</a>
        </div>

        <div class="dashboard-section">
            <h2>Manage Customers</h2>
            <a href="manage_customers.php">View and Edit Customers</a>
        </div>

        <div class="dashboard-section">
            <h2>Manage Spare Parts</h2>
            <a href="manage_spare_parts.php">View and Edit Spare Parts</a>
        </div>

        <div class="dashboard-section">
            <h2>Sales Reports and Analytics</h2>
            <a href="view_sales_reports.php">View Sales Reports</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>