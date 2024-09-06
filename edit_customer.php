<?php
include 'db_connection.php';
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $customer_id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_contact = $_POST['customer_contact'];

    // Prepare and execute SQL statement
    $sql = "UPDATE customers SET customer_name = ?, customer_email = ?, customer_contact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $customer_name, $customer_email, $customer_contact, $customer_id);

    if ($stmt->execute()) {
        echo "Customer updated successfully.";
    } else {
        echo "Error updating customer: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $customer_id = $_POST['id'];

    // Prepare and execute SQL statement
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        header("Location: manage_customers.php"); // Redirect after successful delete
        exit();
    } else {
        echo "Error deleting customer: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Ensure ID is set in the GET request
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Customer ID is required.");
    }

    $customer_id = $_GET['id'];

    // Fetch customer data for editing
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Customer not found.");
    }

    $customer = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Customer</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.html">Dashboard</a></li>
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
        <h2>Edit Customer Details</h2>
        <form action="edit_customer.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer['id'] ?? ''); ?>">
            <label for="customer_name">Name:</label>
            <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer['customer_name'] ?? ''); ?>" required>
            <br>
            <label for="customer_email">Email:</label>
            <input type="email" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($customer['customer_email'] ?? ''); ?>" required>
            <br>
            <label for="customer_contact">Phone:</label>
            <input type="text" id="customer_contact" name="customer_contact" value="<?php echo htmlspecialchars($customer['customer_contact'] ?? ''); ?>" required>
            <br>
            <input type="submit" name="action" value="update">
            <input type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this customer?');">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
