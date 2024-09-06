<?php
session_start();
include 'db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.html");
    exit();
}

$customer_email = $_SESSION['customer_email'];

// Fetch profile data
$sql = "SELECT * FROM customers WHERE customer_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile data
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_sql = "UPDATE customers SET customer_phone = ?, customer_address = ? WHERE customer_email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $phone, $address, $customer_email);
    
    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = 'Profile updated successfully!';
    } else {
        $_SESSION['error_message'] = 'Failed to update profile.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Your Profile</h1>
        <nav>
            <!-- Navigation Links -->
        </nav>
    </header>
    <main>
        <form action="profile.php" method="POST">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['customer_phone']); ?>" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($profile['customer_address']); ?></textarea>

            <button type="submit">Update Profile</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
