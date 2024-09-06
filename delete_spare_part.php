<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['shop_id'])) {
    header("Location: login_shop.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $part_id = $_POST['part_id'];

    $sql = "DELETE FROM spare_parts WHERE part_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $part_id);

    if ($stmt->execute()) {
        echo "Spare part deleted successfully.";
    } else {
        echo "Error deleting spare part.";
    }

    $stmt->close();
    $conn->close();
}
?>
