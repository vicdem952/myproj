<?php require_once 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Customer Login</h1>
    <form action="customer_login.php" method="post">
        <label for="customer_email">Email:</label>
        <input type="email" id="customer_email" name="customer_email"><br><br>
        <label for="customer_password">Password:</label>
        <input type="password" id="customer_password" name="customer_password"><br><br>
        <input type="submit" value="Login">
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $customer_email = $_POST['customer_email'];
        $customer_password = $_POST['customer_password'];

        // Query the database to check if the customer email and password match
        $sql = "SELECT * FROM customers WHERE customer_email = '$customer_email' AND customer_password = '$customer_password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $customer_data = $result->fetch_assoc();
            session_start();
            $_SESSION['customer_id'] = $customer_data['customer_id'];
            header('Location: customer_dashboard.php');
            exit;
        } else {
            echo 'Invalid email or password';
        }
    }

    $conn->close();
    ?>
</body>
</html>