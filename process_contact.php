<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate and sanitize input
    $name = htmlspecialchars(strip_tags($name));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags($subject));
    $message = htmlspecialchars(strip_tags($message));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Insert data into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Your message has been sent successfully!";
        header("Location: index.html");
    } else {
        echo "Failed to send your message: " . $stmt->error;
        header("Location: index.html");
    }

    $stmt->close();
    $conn->close();
}
?>
