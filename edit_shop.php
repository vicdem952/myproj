<?php
include 'db_connection.php';
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $shop_id = $_POST['id'];
        
        if ($_POST['action'] == 'update') {
            // Handle update
            $shop_name = $_POST['shop_name'];
            $shop_email = $_POST['shop_email'];
            $shop_address = $_POST['shop_address'];
            $shop_phone = $_POST['shop_phone'];

            // Prepare and execute SQL statement
            $sql = "UPDATE shops SET shop_name = ?, shop_email = ?, address = ?, phone = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $shop_name, $shop_email, $shop_address, $shop_phone, $shop_id);

            if ($stmt->execute()) {
                echo "Shop updated successfully.";
            } else {
                echo "Error updating shop: " . $stmt->error;
            }

            $stmt->close();
        } elseif ($_POST['action'] == 'delete') {
            // Handle delete
            $shop_id = $_POST['id'];

            // Prepare and execute SQL statement
            $sql = "DELETE FROM shops WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $shop_id);

            if ($stmt->execute()) {
                header("Location: manage_shops.php"); // Redirect after successful delete
                exit();
            } else {
                echo "Error deleting shop: " . $stmt->error;
            }

            $stmt->close();
        } elseif ($_POST['action'] == 'approve') {
            // Handle approve
            $shop_id = $_POST['id'];

            // Prepare and execute SQL statement
            $sql = "UPDATE shops SET shop_approved = 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $shop_id);

            if ($stmt->execute()) {
                echo "Shop approved successfully.";
            } else {
                echo "Error approving shop: " . $stmt->error;
            }

            $stmt->close();
        } elseif ($_POST['action'] == 'reject') {
            // Handle reject
            $shop_id = $_POST['id'];

            // Prepare and execute SQL statement
            $sql = "UPDATE shops SET shop_approved = 0 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $shop_id);

            if ($stmt->execute()) {
                echo "Shop rejected successfully.";
            } else {
                echo "Error rejecting shop: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    $conn->close();
} else {
    // Ensure ID is set in the GET request
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Shop ID is required.");
    }

    $shop_id = $_GET['id'];

    // Fetch shop data for editing
    $sql = "SELECT * FROM shops WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $shop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Shop not found.");
    }

    $shop = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Shop</h1>
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
        <h2>Edit Shop Details</h2>
        <form action="edit_shop.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($shop['id'] ?? ''); ?>">
            <label for="shop_name">Shop Name:</label>
            <input type="text" id="shop_name" name="shop_name" value="<?php echo htmlspecialchars($shop['shop_name'] ?? ''); ?>" required>
            <br>
            <label for="shop_email">Email:</label>
            <input type="email" id="shop_email" name="shop_email" value="<?php echo htmlspecialchars($shop['shop_email'] ?? ''); ?>" required>
            <br>
            <label for="shop_address">Address:</label>
            <input type="text" id="shop_address" name="shop_address" value="<?php echo htmlspecialchars($shop['address'] ?? ''); ?>" required>
            <br>
            <label for="shop_phone">Phone:</label>
            <input type="text" id="shop_phone" name="shop_phone" value="<?php echo htmlspecialchars($shop['phone'] ?? ''); ?>" required>
            <br>
            <input type="submit" name="action" value="update">
            <input type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this shop?');">
            <?php if ($shop['shop_approved']) { ?>
                <input type="submit" name="action" value="reject" onclick="return confirm('Are you sure you want to reject this shop?');">
            <?php } else { ?>
                <input type="submit" name="action" value="approve" onclick="return confirm('Are you sure you want to approve this shop?');">
            <?php } ?>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
