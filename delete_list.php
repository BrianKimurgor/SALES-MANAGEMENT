<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $sql = "DELETE FROM formdata WHERE id = $id";

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
    <title>Delete list</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>

<body>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "report.php";</script>';
    }
    ?>

</body>

</html>
