<!DOCTYPE html>
<html>
<head>
  <title>ADD BRANCH</title>
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
      max-width: 500px;
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
            <a href="view_branch.php">View Branches</a>
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
        <a href="">STOCK</a>
        <div class="submenu-content">
            <a href="stock.php">Available stock</a>
            <a href="soldstock.php">Sold stock</a>
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
  <h2>ADD BRANCH</h2>
  <form action="branch_add.php" method="POST">
    <label for="branchcode">BRANCH CODE:</label>
     <input type="text" id="branchcode" name="branchcode" required><br><br>
      <label for="branchname">BRANCH NAME:</label>
     <input type="text" id="branchname" name="branchname" required><br><br>
     <label for="branch_description">BRANCH DESCRIPTION:</label>
    <input type="text" id="branch_description" name="branch_description" required><br><br>
    
    <input type="submit" value="Add">
  </form>
</body>
</html>
