<?php require_once 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Login</h1>
    <form action="admin_login.php" method="post">
        <label for="admin_email">Admin Email:</label>
        <input type="email" id="admin_email" name="admin_email"><br><br>
        <label for="admin_password">Admin Password:</label>
        <input type="password" id="admin_password" name="admin_password"><br><br>
        <input type="submit" value="Login">
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $admin_email = $_POST['admin_email'];
        $admin_password = $_POST['admin_password'];

        // Query the database to check if the admin email and password match
        $sql = "SELECT * FROM admins WHERE admin_email = '$admin_email' AND admin_password = '$admin_password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $admin_data = $result->fetch_assoc();
            session_start();
            $_SESSION['admin_id'] = $admin_data['admin_id'];
            header('Location: admin_dashboard.php');
            exit;
        } else {
            echo 'Invalid admin email or password';
        }
    }

    $conn->close();
    ?>
</body>
</html>