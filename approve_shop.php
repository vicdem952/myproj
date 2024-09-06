<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_id = $_POST['shop_id'];

    $sql = "UPDATE shops SET shop_approved = 1 WHERE shop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $shop_id);

    if ($stmt->execute()) {
        echo "Shop approved successfully.";
    } else {
        echo "Error approving shop.";
    }

    $stmt->close();
    $conn->close();
}
?>
