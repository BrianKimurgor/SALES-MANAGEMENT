<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['user_id'];

    $sql = "DELETE FROM login_data WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>

<body>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "view_users.php";</script>';
    }
    ?>

</body>

</html>
