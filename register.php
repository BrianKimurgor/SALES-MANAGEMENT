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
<html>
<head>
  <title>Register user</title>
  <style>
    #header {
            text-align: center;
            padding: 10px;
            margin-left: 50;
            background-color: green;
            color: #fff;
        }

        #header img {
            max-width: 100px;
            vertical-align: middle;
        }

        h1 {
            margin: 10px 0;
        }

        p {
            margin: 10px 0;
            text-align: center;

            font-weight: bold;
        }
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
      width: 100%;
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
      font-size: 16px;
      transition: color 0.3s;
    }

    .form-container a:hover {
      color: #777;
    }
     .sidebar {
            width: 200px;
            height: 100%;
            position: fixed;
            background-color: #333;
            padding-top: 20px;
            padding-left: 10px;
            color: white;
        }

        .sidebar a {
            padding: 8px 8px 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 200px; /* Adjust the margin based on the sidebar width */
            padding: 16px;
        } 
        .submenu {
    padding: 8px 8px 8px 16px;
    text-decoration: none;
    font-size: 18px;
    color: white;
    display: block;
    position: relative;
}

.submenu-content {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: #333;
    min-width: 160px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.submenu:hover .submenu-content {
    display: block;
}

.submenu-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.submenu-content a:hover {
    background-color: #555;
}  
.form-group select {
    width: 50%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}  
.form-group select,
.form-group input,
.form-group textarea {
    width: 50%;
    padding: 12px; /* Increased padding for larger size */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px; /* Increased font size */
    font-weight: bold; /* Bold font */
}
  </style>
</head>
<div id="header">
        
        <h1>SALES RECORD SYSTEM</h1>
       
    </div>

<body>

  <div class="sidebar">
    <a href="login.php">
        <span>&#128100;</span> 
        LOGOUT
    </a>
    <a href="admin.php">Dashboard</a>
    <div class="submenu">
        <a href="">Manage Users</a>
        <div class="submenu-content">
            <a href="register.php">Register User</a>
            <a href="view_users.php">View User</a>
        </div>
    </div>
    <div class="submenu">
        <a href="">Manage Branches</a>
        <div class="submenu-content">
            <a href="branch.php">Register branch</a>
            <a href="branches_view.php">View Branches</a>
        </div>
    </div>
    <div class="submenu">
        <a href="">Manage Items</a>
        <div class="submenu-content">
            <a href="item.php">Add items</a>
            <a href="item_view.php">View Items</a>
        </div>
    </div>
<div class="submenu">
        <a href="">Sales</a>
        <div class="submenu-content">
            <a href="report.php">sales details</a>
            <!--a href="item_view.php">View Items</a-->
        </div>
    </div>
    
</div>
  <h2>Create user Account</h2>
  <?php
    if (!empty($successMessage)) {
        echo '<div class="success-message">' . $successMessage . '</div>';
    }
    ?>
  <form action="register2.php" method="POST">
    
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <div class="form-group">
     <label for="item">BRANCH:</label>
        <!-- Dropdown list of items -->
        <select name="branch" id="branch" onchange="updateSellingPrice()" required>
            <?php foreach ($branch as $branchname) : ?>
                <option value="<?php echo $branchname; ?>"><?php echo $branchname; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
   

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

    <input type="submit" value="Register">
  </form>
</body>
</html>

