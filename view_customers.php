<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$sql = "SELECT customer_id, customer_name, customer_email FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p>Name: " . htmlspecialchars($row['customer_name']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($row['customer_email']) . "</p>";
        echo "<form action='edit_customer.php' method='POST'>";
        echo "<input type='hidden' name='customer_id' value='" . $row['customer_id'] . "'>";
        echo "<button type='submit'>Edit</button>";
        echo "</form>";
        echo "<form action='delete_customer.php' method='POST'>";
        echo "<input type='hidden' name='customer_id' value='" . $row['customer_id'] . "'>";
        echo "<button type='submit'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No customers found.";
}

$conn->close();
?>
