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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sales Record Analysis</title>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <a href="analysis.php" class="bg-white text-gray-800 px-4 py-2 rounded font-bold">HOME</a>
        <a href="login.php" class="bg-white text-gray-800 px-4 py-2 rounded font-bold flex items-center">
            <span class="mr-2">&#128100;</span> LOGOUT
        </a>
    </header>
    
    <div class="text-center bg-green-600 text-white p-6">
        <h1 class="text-2xl font-bold">SALES RECORD ANALYSIS ON BRANCHES</h1>
    </div>
    
    <div class="p-6 max-w-4xl mx-auto">
        <label for="branch" class="block font-bold text-green-600">Select Branch:</label>
        <select id="branch" name="branch" class="mt-2 p-2 border rounded w-full" onchange="changeBranch(this.value)">
            <option value="all" <?php echo ($selectedBranch == 'all') ? 'selected' : ''; ?>>All Branches</option>
            <option value="branch1" <?php echo ($selectedBranch == 'branch1') ? 'selected' : ''; ?>>Branch 1</option>
            <option value="branch2" <?php echo ($selectedBranch == 'branch2') ? 'selected' : ''; ?>>Branch 2</option>
        </select>
        
        <table class="mt-6 w-full border-collapse border border-gray-300 shadow-md bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="border p-2">BRANCH</th>
                    <th class="border p-2">QUANTITIES OF ITEM SOLD</th>
                    <th class="border p-2">TOTAL SALES</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='border'>";
                        echo "<td class='border p-2 text-center'>" . $row['branch'] . "</td>";
                        echo "<td class='border p-2 text-center'>" . $row['total_quantity'] . "</td>";
                        echo "<td class='border p-2 text-center'>" . $row['grand_total'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='p-4 text-center text-red-500'>No records found.</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function changeBranch(value) {
            window.location.href = '?page=1&entries=' + document.getElementById('entries')?.value + '&branch=' + value;
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
