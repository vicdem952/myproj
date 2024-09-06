<?php
session_start(); // Start the session to access session variables
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the error message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="forms.css">
</head>
<body>
    <header>
        <h1>Customer Registration</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about_us.html">About Us</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="contact_us.html">Contact Us</a></li>
            <li><a href="customer_registration.html">Customer Registration</a></li>
            <li><a href="shop_registration.php">Shop Registration</a></li>
            <li><a href="customer_login.html">Customer Login</a></li>
            <li><a href="admin_login.html">Admin Login</a></li>
            <li><a href="shop_login.html">Shop Owner Login</a></li>

        </ul>
    </nav>
    </header>
    <main>
        <?php if ($error_message): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="register_customer.php" method="POST">
            <label for="customer_name">Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="customer_email">Email:</label>
            <input type="email" id="customer_email" name="customer_email" required>

            <label for="customer_password">Password:</label>
            <input type="password" id="customer_password" name="customer_password" required>

            <label for="customer_contact">Contact:</label>
            <input type="text" id="customer_contact" name="customer_contact" required>

            <label for="customer_address">Address:</label>
            <textarea id="customer_address" name="customer_address" rows="4" required></textarea>

            <button type="submit">Register</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
