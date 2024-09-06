<?php
// Include the database connection file
require_once 'db_connection.php';

// Initialize error variable
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_email = $_POST["admin_email"];
    $admin_password = $_POST["admin_password"];

    // Validate input
    if (empty($admin_email) || empty($admin_password)) {
        $error = "Please fill in all fields.";
    } else {
        // Query to check if admin exists
        $query = "SELECT * FROM admins WHERE admin_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin_data = $result->fetch_assoc();
            $hashed_password = $admin_data["admin_password"];

            // Verify password using password_verify()
            if (password_verify($admin_password, $hashed_password)) {
                // Password is correct, log them in
                session_start();
                $_SESSION["admin_id"] = $admin_data["admin_id"];
                $_SESSION["admin_name"] = $admin_data["admin_name"];
                header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="forms.css">
</head>
<body>
    <?php include 'navvbar.php'; ?>

    <h1>Admin Login</h1>
    <main>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="admin_email">Email:</label>
            <input type="email" id="admin_email" name="admin_email"><br><br>
            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password"><br><br>
            <input type="submit" value="Login">
        </form>
    </main>

    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>