<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['customer_email'];
    $password = $_POST['customer_password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT customer_password FROM customers WHERE customer_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify credentials
    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION['customer_email'] = $email;
        header("Location: customer_dashboard.php");
    } else {
        $_SESSION['error_message'] = 'Invalid email or password.';
        header("Location: customer_login.php");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
