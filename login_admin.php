<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    $sql = "SELECT admin_id, admin_password FROM admins WHERE admin_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($admin_password, $hashed_password)) {
            $_SESSION['admin_id'] = $admin_id;
            header("Location: admin_dashboard.html");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
