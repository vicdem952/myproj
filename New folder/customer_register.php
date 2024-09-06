<?php require_once 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Customer Registration</h1>
    <form action="customer_register.php" method="post">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name"><br><br>
        <label for="customer_email">Customer Email:</label>
        <input type="email" id="customer_email" name="customer_email"><br><br>
        <label for="customer_password">Customer Password:</label>
        <input type="password" id="customer_password" name="customer_password"><br><br>
        <label for="customer_address">Customer Address:</label>
        <input type="text" id="customer_address" name="customer_address"><br><br>
        <input type="submit" value="Register">
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_password = $_POST['customer_password'];
        $customer_address = $_POST['customer_address'];

        // Query the database to check if the customer email already exists
        $sql = "SELECT * FROM customers WHERE customer_email = '$customer_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo 'Customer email already exists';
        } else {
            // Insert the customer data into the database
            $sql = "INSERT INTO customers (customer_name, customer_email, customer_password, customer_address) VALUES ('$customer_name', '$customer_email', '$customer_password', '$customer_address')";
            if ($conn->query($sql) === TRUE) {
                echo 'Customer registered successfully. You can now login.';
            } else {
                echo 'Error registering customer: ' . $conn->error;
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>