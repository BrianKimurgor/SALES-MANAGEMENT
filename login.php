<?php
session_start(); 
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$conn->set_charset("utf8");

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
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen p-4">

  <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-center text-2xl font-semibold mb-6">Login</h2>
    
    <?php if (!empty($error_message)) : ?>
      <p class="text-red-600 text-center font-semibold mb-4"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">
      <div>
        <label for="username" class="block text-gray-700 font-semibold">Username</label>
        <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
      </div>
      
      <div>
        <label for="password" class="block text-gray-700 font-semibold">Password</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
      </div>

      <div class="flex justify-between items-center">
        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Login
        </button>
      </div>
    </form>

    <!-- Optional Register Button (Uncomment if needed) -->
    <!-- <div class="mt-4 text-center">
      <button class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition duration-200">
        <a href="register.php" class="block">Register</a>
      </button>
    </div> -->
  </div>
</body>
</html>
