<?php
session_start(); // Start the session to use session variables
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $shop_email = $_POST['shop_email'];
    $shop_password = $_POST['shop_password'];

    // Check if the email exists
    $check_email_sql = "SELECT shop_password FROM shops WHERE shop_email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $shop_email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $check_stmt->bind_result($hashed_password);
        $check_stmt->fetch();

        // Verify password
        if (password_verify($shop_password, $hashed_password)) {
            $_SESSION['shop_email'] = $shop_email; // Store shop email in session
            header("Location: shop_dashboard.php"); // Redirect to shop dashboard
            exit();
        } else {
            $_SESSION['error_message'] = 'Invalid password. Please try again.';
            header("Location: shop_login.html");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Email not registered. Please check your email or register.';
        header("Location: shop_login.html");
        exit();
    }

    $check_stmt->close();
    $conn->close();
}
?>
