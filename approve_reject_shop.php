<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_shops.php");
    exit();
}

$id = $_GET['id'];

// Retrieve shop details from database
$query = "SELECT * FROM shops WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$shop = mysqli_fetch_assoc($result);

mysqli_free_result($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        $sql = "UPDATE shops SET shop_approved = 1 WHERE id = '$id'";
        $message = "Shop approved successfully.";
    } elseif (isset($_POST['reject'])) {
        $sql = "UPDATE shops SET shop_approved = 0 WHERE id = '$id'";
        $message = "Shop rejected successfully.";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect with a success message
        header("Location: manage_shops.php?message=" . urlencode($message));
    } else {
        // Redirect with an error message
        header("Location: manage_shops.php?message=" . urlencode("Error updating shop approval status."));
    }

    mysqli_close($conn);
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve/Reject Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Approve/Reject Shop</h1>
    </header>
    <main>
        <h2>Shop Name: <?php echo htmlspecialchars($shop['shop_name']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($shop['shop_email']); ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="submit" name="approve" value="Approve">
            <input type="submit" name="reject" value="Reject">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Spare Parts Management System</p>
    </footer>
</body>
</html>
