<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Contact Us</h1>
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
        <form action="process_contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
