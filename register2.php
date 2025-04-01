<?php

require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 
$conn->set_charset("utf8");

$successMessage = ""; // Initialize an empty success message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $branch = $_POST['branch'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Password and confirm password do not match.";
        exit;
    }

    $sql = "INSERT INTO login_data (username, password, branch) VALUES ('$username', '$password', '$branch')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "User registration successful."; // Set the success message

        // Redirect to the registration page with the success message as a query parameter
        header("Location: view_users.php?success=" . urlencode($successMessage));
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>