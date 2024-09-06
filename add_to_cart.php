<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Initialize cart if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add part to cart or update quantity if it already exists
        if (array_key_exists($id, $_SESSION['cart'])) {
            $_SESSION['cart'][$id] += 1;
        } else {
            $_SESSION['cart'][$id] = 1;
        }

        // Redirect to view cart page
        header("Location: view_cart.php");
        exit();
    } else {
        // Redirect back to parts page with an error if part_id is not set
        header("Location: browse_parts.php");
        exit();
    }
} else {
    // Redirect back to parts page if not a POST request
    header("Location: browse_parts.php");
    exit();
}
?>
