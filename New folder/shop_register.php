<?php require_once 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Shop Register</h1>
    <form action="shop_register.php" method="post">
        <label for="shop_name">Shop Name:</label>
        <input type="text" id="shop_name" name="shop_name"><br><br>
        <label for="shop_email">Shop Email:</label>
        <input type="email" id="shop_email" name="shop_email"><br><br>
        <label for="shop_password">Shop Password:</label>
        <input type="password" id="shop_password" name="shop_password"><br><br>
        <label for="shop_address">Shop Address:</label>
        <textarea id="shop_address" name="shop_address"></textarea><br><br>
        <input type="submit" value="Register">
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $shop_name = $_POST['shop_name'];
        $shop_email = $_POST['shop_email'];
        $shop_password = $_POST['shop_password'];
        $shop_address = $_POST['shop_address'];

        // Check if the shop email already exists
        $sql = "SELECT * FROM shops WHERE shop_email = '$shop_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo 'Shop email already exists';
        } else {
            // Insert the shop data into the database
            $sql = "INSERT INTO shops (shop_name, shop_email, shop_password, shop_address) VALUES ('$shop_name', '$shop_email', '$shop_password', '$shop_address')";
            if ($conn->query($sql) === TRUE) {
                echo 'Shop registered successfully.';
            } else {
                echo 'Error registering shop: ' . $conn->error;
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>