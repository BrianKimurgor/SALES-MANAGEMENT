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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #006799;
        }
    </style>
</head>

<body>
    <form method="post" action="">
        <h2>Update User</h2>
        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" value="<?php echo $row['username']; ?>" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" value="<?php echo $row['password']; ?>" required>

        <label for="new_branch">New Branch:</label>
        <input type="text" name="new_branch" value="<?php echo $row['branch']; ?>" required>

        <input type="submit" value="Update User">
    </form>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "view_users.php";</script>';
    }
    ?>

</body>

</html>