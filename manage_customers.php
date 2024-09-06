<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Retrieve all customers from the database
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Customers</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_shops.php">Manage Shops</a></li>
                <li><a href="manage_spare_parts.php">Manage Spare Parts</a></li>
                <li><a href="manage_customers.php">Manage Customers</a></li>
                <li><a href="view_sales_orders.php">View Sales Orders</a></li>
                <li><a href="view_sales_reports.php">View Sales Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Customers List</h2>
        <div class="customers-list">
            <?php while ($customer = mysqli_fetch_assoc($result)) { ?>
            <div class="customer">
                <h3>Customer Name: <?php echo htmlspecialchars($customer['customer_name']); ?></h3>
                <p>Email: <?php echo htmlspecialchars($customer['customer_email']); ?></p>
                <form action="edit_customer.php" method="get">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer['id']); ?>">
                    <input type="submit" value="Edit">
                </form>
            </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
