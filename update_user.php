<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    $newBranch = $_POST['new_branch'];

    $sql = "UPDATE login_data SET username = '$newUsername', password = '$newPassword', branch = '$newBranch' WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "User updated successfully.";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$user_id = $_GET['user_id'];
$sql = "SELECT user_id, username, password, branch FROM login_data WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="post" action="" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Update User</h2>

        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

        <div class="mb-4">
            <label for="new_username" class="block text-gray-700 text-sm font-medium mb-2">New Username:</label>
            <input type="text" name="new_username" value="<?php echo $row['username']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="new_password" class="block text-gray-700 text-sm font-medium mb-2">New Password:</label>
            <input type="password" name="new_password" value="<?php echo $row['password']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label for="new_branch" class="block text-gray-700 text-sm font-medium mb-2">New Branch:</label>
            <input type="text" name="new_branch" value="<?php echo $row['branch']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update User
            </button>
        </div>

    </form>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "view_users.php";</script>';
    }
    ?>

</body>

</html>
