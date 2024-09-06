<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_email = $_POST['shop_email'];
    $shop_password = $_POST['shop_password'];

    $sql = "SELECT shop_id, shop_password, shop_approved FROM shops WHERE shop_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $shop_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($shop_id, $hashed_password, $shop_approved);
        $stmt->fetch();

        if ($shop_approved && password_verify($shop_password, $hashed_password)) {
            $_SESSION['shop_id'] = $shop_id;
            header("Location: shop_dashboard.html");
            exit();
        } elseif (!$shop_approved) {
            echo "Your account is not yet approved.";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
