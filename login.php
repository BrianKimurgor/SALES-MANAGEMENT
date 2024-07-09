<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
<html>
<head>
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      display: block;
      width:100%;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .form-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-container a {
      text-decoration: none;
      color: #333;
      font-size: 12px;
      transition: color 0.3s;
    }

    .form-container a:hover {
      color: #777;
    }

    p.error-message {
      color: red;
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
    }
    button.register-button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-align: center;
      margin-top: 10px; /* Adjust as needed */
    }

    button.register-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <script>
    function submitRegisterForm() {
      document.getElementById("register-form").submit();
    }
  </script>
  <h2>Login</h2>
  <?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo $error_message; ?></p>
  <?php endif; ?>

  <form action="" method="POST"> 
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <div class="form-container">
        <input type="submit" value="LOGIN">
        <!--p><button class="register-button"> <a href="register.php" class="register-link">REGISTER</a></button></p-->
    </div>
  </form>
</body>
</html>
