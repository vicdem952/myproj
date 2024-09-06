<?php
include 'db_connection.php';
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        // Handle update
        $spare_part_id = $_POST['id'];
        $part_number = $_POST['part_number'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];
        $image = $_POST['image'];

        // Prepare and execute SQL statement
        $sql = "UPDATE spare_parts SET part_number = ?, description = ?, price = ?, stock_quantity = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $part_number, $description, $price, $stock_quantity, $image, $spare_part_id);

        if ($stmt->execute()) {
            echo "Spare part updated successfully.";
        } else {
            echo "Error updating spare part: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Handle delete
        $spare_part_id = $_POST['id'];

        // Prepare and execute SQL statement
        $sql = "DELETE FROM spare_parts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $spare_part_id);

        if ($stmt->execute()) {
            header("Location: manage_spare_parts.php"); // Redirect after successful delete
            exit();
        } else {
            echo "Error deleting spare part: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    // Ensure ID is set in the GET request
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Spare Part ID is required.");
    }

    $spare_part_id = $_GET['id'];

    // Fetch spare part data for editing
    $sql = "SELECT * FROM spare_parts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $spare_part_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Spare part not found.");
    }

    $spare_part = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spare Part</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Spare Part</h1>
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
        <h2>Edit Spare Part Details</h2>
        <form action="edit_spare_part.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($spare_part['id'] ?? ''); ?>">
            <label for="part_number">Part Number:</label>
            <input type="text" id="part_number" name="part_number" value="<?php echo htmlspecialchars($spare_part['part_number'] ?? ''); ?>" required>
            <br>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($spare_part['description'] ?? ''); ?>" required>
            <br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($spare_part['price'] ?? ''); ?>" step="0.01" required>
            <br>
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo htmlspecialchars($spare_part['stock_quantity'] ?? ''); ?>" required>
            <br>
            <label for="image">Image:</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($spare_part['image'] ?? ''); ?>" placeholder="Image filename (e.g., image.jpg)">
            <br>
            <input type="submit" name="action" value="update">
            <input type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this spare part?');">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
