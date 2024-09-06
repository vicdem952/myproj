<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['shop_id'])) {
    header("Location: login_shop.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $part_name = $_POST['part_name'];
    $part_description = $_POST['part_description'];
    $part_price = $_POST['part_price'];
    $part_stock_level = $_POST['part_stock_level'];
    $shop_id = $_SESSION['shop_id'];

    $sql = "INSERT INTO spare_parts (part_name, part_description, part_price, part_stock_level, shop_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $part_name, $part_description, $part_price, $part_stock_level, $shop_id);

    if ($stmt->execute()) {
        echo "Spare part added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
