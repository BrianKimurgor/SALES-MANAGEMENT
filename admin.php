<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date
$entriesPerPage = isset($_GET['entries']) ? $_GET['entries'] : 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

$sql = "SELECT id, itemcode,item, quantity, sellingprice, totalcost, date, branch FROM formdata";
// Add date filter to the query
$dateFilter = date('Y-m-d', strtotime($selectedDate));
$sql .= " WHERE date = '$dateFilter'";

$sql .= " LIMIT $offset, $entriesPerPage";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html>

<head>
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
        table {
    width: 80%;
    border-collapse: collapse;
    margin-top: 50px;
    margin-left: 300px;
}

th,
td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

button {
    padding: 8px 12px;
    background-color: #008CBA;
    color: white;
    border: none;
    cursor: pointer;
    margin-right: 5px;
}

select {
    padding: 8px;
    margin-left: 50px;
}

.pagination {
    margin-top: 20px;
    justify-content: center;
    margin-right: 100;
}

.pagination a {
    color: #008CBA;
    float: left;
    padding: 8px 16px;
    text-decoration: none;

    border: 1px solid #ddd;
}

.pagination a.active {
    background-color: #008CBA;
    color: white;

}

.pagination a:hover:not(.active) {
    background-color: #ddd;
    justify-content: center;
}
.branch {
            font-weight: bold;
            color: green;
            margin-left: 250px;
            margin-top: 50px;
            font-size: 18px; /* Increased font size for the branch label */
        }
.entries{
    font-weight: bold;
    color: blue;
    margin-left:20px;
}
.logout-button a span {
    margin-right: 5px; /* Adjust the spacing as needed */
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

    <title>SALES MANAGEMENT SYSTEM</title>
<header>
    
</header>
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

    <div class="form-group">
    <label for="date" class="branch">Select Date:</label>
    <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" onchange="changeDate(this.value)">
</div>
    <table>
        <tr>
            <th>ID</th>
            <th>DATE</th>
             <th>ITEM CODE</th>
            <th>ITEM</th>
            
            <th>QUANTITIES</th>
            <th>SELLING PRICE </th>
            <th>TOTAL COST</th>
            <th>BRANCH</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                 echo "<td>" . $row['itemcode'] . "</td>";
                echo "<td>" . $row['item'] . "</td>";
                
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['sellingprice'] . "</td>";
                echo "<td>" . $row['totalcost'] . "</td>";
                echo "<td>" . $row['branch'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found.</td></tr>";
        }
        ?>
    </table>
    <div class="pagination">
    <?php
    $totalRecords = $conn->query("SELECT COUNT(*) as total FROM formdata")->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $entriesPerPage);

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' " . ($page == $i ? 'class="active"' : '') . ">$i</a>";
    }
    ?>
</div>

    <script>
         function changePage(page) {
        window.location.href = `?page=${page}&entries=${document.getElementById('entries').value}${($selectedDate ? "&date=$selectedDate" : "")}`;
    }
        
        // JavaScript functions
        function changeDate(value) {
            window.location.href = '?date=' + value;
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>