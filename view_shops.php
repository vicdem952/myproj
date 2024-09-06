<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$sql = "SELECT shop_id, shop_name, shop_email, shop_approved FROM shops";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p>Name: " . htmlspecialchars($row['shop_name']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($row['shop_email']) . "</p>";
        echo "<p>Approved: " . ($row['shop_approved'] ? "Yes" : "No") . "</p>";
        echo "<form action='approve_shop.php' method='POST'>";
        echo "<input type='hidden' name='shop_id' value='" . $row['shop_id'] . "'>";
        echo "<button type='submit'>Approve</button>";
        echo "</form>";
        echo "<form action='edit_shop.php' method='POST'>";
        echo "<input type='hidden' name='shop_id' value='" . $row['shop_id'] . "'>";
        echo "<button type='submit'>Edit</button>";
        echo "</form>";
        echo "<form action='delete_shop.php' method='POST'>";
        echo "<input type='hidden' name='shop_id' value='" . $row['shop_id'] . "'>";
        echo "<button type='submit'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No shops found.";
}

$conn->close();
?>
