<?php
include 'db_connection.php'; // Ensure this file contains your database connection code

// Array of image filenames mapped to their corresponding IDs
$images = [
    1 => 'engine.jpg',
    2 => 'brakepad.jpg',
    3 => 'spark_plug.jpg',
    4 => 'gearbox.jpg',
    5 => 'tyre.jpg',
    6 => 'battery.jpg',
    7 => 'oil_filter.jpg',
    8 => 'air_filter.jpg',
    9 => 'alternator.jpg',
    10 => 'radiator.jpg',
    11 => 'timing_belt.jpg',
    12 => 'fuel_injector.jpg',
    13 => 'headlight.jpg',
    14 => 'clutch_kit.jpg',
    15 => 'exhaust_system.jpg',
    16 => 'turbocharger.jpg'
];

// Loop through each image and update the database
foreach ($images as $id => $image) {
    $sql = "UPDATE spare_parts SET image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $image, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Image updated for ID $id to $image.<br>";
    } else {
        echo "Error updating image for ID $id: " . mysqli_error($conn) . "<br>";
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
