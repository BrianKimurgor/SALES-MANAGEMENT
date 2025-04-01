<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 
$sqlbranch = "SELECT branchname FROM branches";
$resultbranch = $conn->query($sqlbranch);

$branch = [];
if ($resultbranch->num_rows > 0) {
    while ($row = $resultbranch->fetch_assoc()) {
        $branch[] = $row['branchname'];
    }
}
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
        header("Location: register.php?success=" . urlencode($successMessage));
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'includes/header.php'; ?>
    
    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <h2 class="text-2xl font-bold text-center mb-5">Create User Account</h2>
            
            <?php if (!empty($successMessage)) : ?>
                <div class="bg-green-500 text-white p-3 mb-4 text-center rounded"> <?= $successMessage; ?> </div>
            <?php endif; ?>

            <form action="register2.php" method="POST" class="bg-white p-6 shadow-md rounded-lg max-w-lg mx-auto">
                <label class="block text-gray-700 font-bold mb-2" for="username">Username:</label>
                <input type="text" id="username" name="username" required class="w-full p-2 border border-gray-300 rounded mb-4">
                
                <label class="block text-gray-700 font-bold mb-2" for="branch">Branch:</label>
                <select name="branch" id="branch" required class="w-full p-2 border border-gray-300 rounded mb-4">
                    <?php foreach ($branch as $branchname) : ?>
                        <option value="<?= $branchname; ?>"><?= $branchname; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label class="block text-gray-700 font-bold mb-2" for="password">Password:</label>
                <input type="password" id="password" name="password" required class="w-full p-2 border border-gray-300 rounded mb-4">
                
                <label class="block text-gray-700 font-bold mb-2" for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-2 border border-gray-300 rounded mb-4">
                
                <input type="submit" value="Register" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
            </form>
        </div>
    </div>
</body>
</html>
