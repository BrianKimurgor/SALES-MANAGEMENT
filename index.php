<?php
session_start(); 
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login_data WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        echo "Login successful!";
        $user_data = $result->fetch_assoc();

        $_SESSION['user_id'] = $user_data['user_id'];
        if ($username == 'Admin') {
            header("Location: admin.php");
            exit;
        } else {
            header("Location: home.php"); 
            exit;
        }
    } else {
        $error_message = "Invalid Details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="min-h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
      <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Login</h2>

      <?php if (!empty($error_message)) : ?>
        <p class="text-red-500 text-center mb-4"><?php echo $error_message; ?></p>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
          <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="flex justify-between items-center">
          <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300">Login</button>
        </div>
      </form>

      <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
      </div>
    </div>
  </div>

</body>
</html>
