<?php
session_start(); // Start the session to use session variables
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_password = password_hash($_POST['customer_password'], PASSWORD_BCRYPT);
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    // Check if the email already exists
    $check_email_sql = "SELECT customer_email FROM customers WHERE customer_email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $customer_email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Set error message in session and redirect
        $_SESSION['error_message'] = 'Email already registered. Please use a different email address.';
        header("Location: customer_registration.php");
        exit();
    } else {
        // Insert new customer data
        $sql = "INSERT INTO customers (customer_name, customer_email, customer_password, customer_contact, customer_address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $customer_name, $customer_email, $customer_password, $customer_contact, $customer_address);

        if ($stmt->execute()) {
            // Redirect to homepage on success
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
