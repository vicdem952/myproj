<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Retrieve all spare parts from the database, including the image column
$query = "SELECT * FROM spare_parts";
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
    <title>Manage Spare Parts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Spare Parts</h1>
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
        <h2>Spare Parts List</h2>
        <div class="spare-parts-list">
            <?php while ($spare_part = mysqli_fetch_assoc($result)) { ?>
            <div class="spare-part">
                <h3>Part Number: <?php echo htmlspecialchars($spare_part['part_number']); ?></h3>
                <p>Description: <?php echo htmlspecialchars($spare_part['description']); ?></p>
                <p>Price: <?php echo htmlspecialchars($spare_part['price']); ?></p>
                <p>Stock Quantity: <?php echo htmlspecialchars($spare_part['stock_quantity']); ?></p>
                <?php if (!empty($spare_part['image'])) { ?>
                    <img src="images/<?php echo htmlspecialchars($spare_part['image']); ?>" alt="<?php echo htmlspecialchars($spare_part['description']); ?>" style="max-width: 150px; max-height: 150px;">
                <?php } else { ?>
                    <p>No image available</p>
                <?php } ?>
                <form action="edit_spare_part.php" method="get">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($spare_part['id']); ?>">
                    <input type="submit" value="Edit">
                </form>
                <form action="delete_spare_part.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($spare_part['id']); ?>">
                    <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this spare part?');">
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
