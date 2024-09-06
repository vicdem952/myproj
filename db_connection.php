<?php
// Database connection settings
$servername = "localhost";
$username = "victordb";
$password = "12345678";
$database = "spares";


// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>