<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_id = $_POST['shop_id'];

    $sql = "DELETE FROM shops WHERE shop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $shop_id);

    if ($stmt->execute()) {
        echo "Shop deleted successfully.";
    } else {
        echo "Error deleting shop.";
    }

    $stmt->close();
    $conn->close();
}
?>
