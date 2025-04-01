<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date
$entriesPerPage = isset($_GET['entries']) ? $_GET['entries'] : 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

$sql = "SELECT id, regno FROM formdata";
//Add date filter to the query
$dateFilter = date('Y-m-d', strtotime($selectedDate));

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
           header {
  background-color: #333;
  color: white;
  padding: 0.5rem;
}
       .logout-button {
  background-color: white;
  color: white;
  text-align: right;
  margin-right:10px ;
  margin-left:1250px ;
  padding: 0.5rem;
}
     .home-button {
  background-color: white;
  color: white;
  text-align: left;
  padding-left: 10px;
  padding: 0.5rem;
}
button{
    font-weight: bold;
}
#header {
            text-align: center;
            padding: 10px;
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
    margin-left: 100px;
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
            margin-right: 10px;
            margin-top: 10px;
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
        
    </style>

    <title>TRACKING REPORT SYSTEM</title>
<header>
    <button class="home-button"><a href="admin.php">HOME</a></button>
    <button class="home-button"><a href="register.php">ADD USER</a></button>
    <button class="home-button"><a href="item.php">ADD ITEMS</a></button>
    <button class="home-button"><a href="branch.php">ADD BRANCH</a></button>
    <button class="logout-button">
        <a href="login.php">
            <span>&#128100;</span> <!-- Person icon HTML entity -->
            LOGOUT
        </a>
    </button>
</header>
    <div id="header">
        
        <h1>TRACKING REPORT SYSTEM</h1>
       
    </div>
<body>
    <!-- Filter Section -->
    <label for="date" class="branch">Select Date:</label>
    <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" onchange="changeDate(this.value)">

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