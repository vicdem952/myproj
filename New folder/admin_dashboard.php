<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require_once 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['admin_id']; ?>!</p>
    <ul>
        <li><a href="add_product.php">Add Product</a></li>
        <li><a href="view_products.php">View Products</a></li>
        <li><a href="view_customers.php">View Customers</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>