<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 
$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : 'all';
$entriesPerPage = isset($_GET['entries']) ? $_GET['entries'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage; 
$sql = "SELECT branch, SUM(quantity) AS total_quantity, SUM(totalcost) AS grand_total FROM formdata";
if ($selectedBranch !== 'all') {
    $sql .= " WHERE branch = '$selectedBranch'";
}
$sql .= " GROUP BY branch LIMIT $offset, $entriesPerPage";
$result = $conn->query($sql);
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
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
.branch{
    font-weight: bold;
    color: green;
    margin-right:0px;
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

<header>
    <button class="home-button"><a href="analysis.php">HOME</a></button>
    <button class="logout-button">
        <a href="login.php">
            <span>&#128100;</span> <!-- Person icon HTML entity -->
            LOGOUT
        </a>
    </button>
</header>
    <div id="header">
        
        <h1>SALES RECORD ANALYSIS ON BRANCHES</h1>

    </div>

<body>
    <label for="branch" class="branch">Select Branch:</label>
    <select id="branch"class="branch" name="branch" onchange="changeBranch(this.value)">
        <option value="all" <?php echo ($selectedBranch == 'all') ? 'selected' : ''; ?>>All Branches</option>
        <option value="branch1" <?php echo ($selectedBranch == 'branch1') ? 'selected' : ''; ?>>Branch 1</option>
        <option value="branch2" <?php echo ($selectedBranch == 'branch2') ? 'selected' : ''; ?>>Branch 2</option>
    </select>
    

    <table>
        <tr>
            
             <th>BRANCH</th>
            <th>QUANTITIES OF ITEM SOLD</th>
            <th>TOTAL SALES</th>
           
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['branch'] . "</td>";
                 echo "<td>" . $row['total_quantity'] . "</td>";
                echo "<td>" . $row['grand_total'] . "</td>";
               
               
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found.</td></tr>";
        }
        ?>
        
    </table>

    <script>
        function changeEntries(value) {
            window.location.href = '?page=1&entries=' + value;
        }
        
        function changeBranch(value) {
            window.location.href = '?page=1&entries=' + document.getElementById('entries').value + '&branch=' + value;
        }

        function changeEntries(value) {
            window.location.href = '?page=1&entries=' + value + '&branch=' + document.getElementById('branch').value;
        }
    
    </script>
</body>

</html>

<?php
$conn->close();
?>
