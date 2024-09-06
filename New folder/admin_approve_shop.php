<?php require_once 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Approve Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Approve Shop</h1>

    <?php
    // Query the database to get all unapproved shops
    $sql = "SELECT * FROM shops WHERE shop_approved = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Shop Name</th><th>Shop Email</th><th>Actions</th></tr>';
        while($shop = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $shop['shop_name'] . '</td>';
            echo '<td>' . $shop['shop_email'] . '</td>';
            echo '<td><a href="admin_approve_shop.php?shop_id=' . $shop['shop_id'] . '&approve=1">Approve</a> | <a href="admin_approve_shop.php?shop_id=' . $shop['shop_id'] . '&approve=0">Reject</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No shops to approve';
    }

    // Check if the approve or reject link has been clicked
    if (isset($_GET['shop_id']) && isset($_GET['approve'])) {
        $shop_id = $_GET['shop_id'];
        $approve = $_GET['approve'];

        if ($approve == 1) {
            $sql = "UPDATE shops SET shop_approved = 1 WHERE shop_id = $shop_id";
            if ($conn->query($sql) === TRUE) {
                echo 'Shop approved successfully.';
            } else {
                echo 'Error approving shop: ' . $conn->error;
            }
        } else {
            $sql = "UPDATE shops SET shop_approved = 0 WHERE shop_id = $shop_id";
            if ($conn->query($sql) === TRUE) {
                echo 'Shop rejected successfully.';
            } else {
                echo 'Error rejecting shop: ' . $conn->error;
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>