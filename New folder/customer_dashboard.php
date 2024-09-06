<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['customer_id'])) {
    header('Location: customer_login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Query the database to get the customer data
$sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
$result = $conn->query($sql);
$customer_data = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Customer Dashboard</h1>
    <p>Welcome, <?php echo $customer_data['customer_name']; ?>!</p>
    <p>Your email is: <?php echo $customer_data['customer_email']; ?></p>

    <h2>Order History</h2>
    <?php
    // Query the database to get the customer's order history
    $sql = "SELECT * FROM orders WHERE customer_id = $customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Order ID</th><th>Order Date</th><th>Order Status</th></tr>';
        while($order = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $order['order_id'] . '</td>';
            echo '<td>' . $order['order_date'] . '</td>';
            echo '<td>' . $order['order_status'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No order history';
    }
    ?>

    <?php $conn->close(); ?>
</body>
</html>