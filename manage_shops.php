<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Retrieve all shops from the database
$query = "SELECT * FROM shops";
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
    <title>Manage Shops</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Shops</h1>
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
        <h2>Shops List</h2>
        <div class="shops-list">
            <?php while ($shop = mysqli_fetch_assoc($result)) { ?>
            <div class="shops">
                <h3>Shop Name: <?php echo htmlspecialchars($shop['shop_name']); ?></h3>
                <p>Email: <?php echo htmlspecialchars($shop['shop_email']); ?></p>
                <p>Approved: <?php echo htmlspecialchars($shop['shop_approved']) ? 'Yes' : 'No'; ?></p>
                <form action="approve_reject_shop.php" method="get">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($shop['id']); ?>">
                    <input type="submit" name="approve" value="Approve">
                    <input type="submit" name="reject" value="Reject">
                </form>
                <form action="edit_shop.php" method="get">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($shop['id']); ?>">
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
