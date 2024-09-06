<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['id'];

    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        echo "Customer deleted successfully.";
        header("Location: manage_customers.php"); // Redirect after successful delete
        exit();
    } else {
        echo "Error deleting customer.";
    }

    $stmt->close();
    $conn->close();
}
?>
