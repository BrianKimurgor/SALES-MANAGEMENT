<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $sql = "DELETE FROM items WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Item deleted successfully.";
    } else {
        echo "Error deleting Item: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>

<body>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "item_view.php";</script>';
    }
    ?>

</body>

</html>
