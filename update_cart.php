<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $part_id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$part_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$part_id]);
        }
    }
}

header("Location: view_cart.php");
exit();
?>
