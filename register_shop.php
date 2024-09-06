<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_name = $_POST['shop_name'];
    $shop_email = $_POST['shop_email'];
    $shop_password = password_hash($_POST['shop_password'], PASSWORD_BCRYPT);
    $shop_address = $_POST['shop_address'];
    $shop_phone = $_POST['shop_phone'];

    // Check if the email already exists
    $check_email_sql = "SELECT shop_email FROM shops WHERE shop_email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $shop_email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        header('Location: index.html');
        exit;
    } else {
        // Insert new shop record
        $sql = "INSERT INTO shops (shop_name, shop_email, shop_password, address, phone, shop_approved) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $shop_name, $shop_email, $shop_password, $shop_address, $shop_phone);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! Please wait for approval.";
            header('Location: index.html');
            exit;
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            header('Location: index.html');
            exit;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>