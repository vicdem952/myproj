<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['shop_id'])) {
    header("Location: login_shop.php");
    exit();
}

$shop_id = $_SESSION['shop_id'];

$sql = "SELECT part_id, part_name, part_description, part_price, part_stock_level FROM spare_parts WHERE shop_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shop_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p>Name: " . htmlspecialchars($row['part_name']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($row['part_description']) . "</p>";
        echo "<p>Price: $" . htmlspecialchars($row['part_price']) . "</p>";
        echo "<p>Stock: " . htmlspecialchars($row['part_stock_level']) . "</p>";
        echo "<form action='edit_spare_part.php' method='POST'>";
        echo "<input type='hidden' name='part_id' value='" . $row['part_id'] . "'>";
        echo "<button type='submit'>Edit</button>";
        echo "</form>";
        echo "<form action='delete_spare_part.php' method='POST'>";
        echo "<input type='hidden' name='part_id' value='" . $row['part_id'] . "'>";
        echo "<button type='submit'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No spare parts found.";
}

$stmt->close();
$conn->close();
?>
