<?php
session_start();

if (isset($_GET['part_id'])) {
    $part_id = $_GET['part_id'];

    if (isset($_SESSION['cart'][$part_id])) {
        unset($_SESSION['cart'][$part_id]);
    }
}

header("Location: view_cart.php");
exit();
?>
