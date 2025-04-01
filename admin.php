<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date
$entriesPerPage = isset($_GET['entries']) ? $_GET['entries'] : 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

$sql = "SELECT id, itemcode, item, quantity, sellingprice, totalcost, date, branch FROM formdata";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>SALES MANAGEMENT SYSTEM</title>
</head>

<body class="bg-gray-100">
    <div class="bg-green-600 text-white text-center py-4">
        <h1 class="text-2xl font-bold">SALES RECORD SYSTEM</h1>
    </div>
    
    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="mb-4">
                <label for="date" class="font-bold text-green-600">Select Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" onchange="changeDate(this.value)" class="border border-gray-300 p-2 rounded">
            </div>
            
            <table class="w-full bg-white shadow-md rounded border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">ID</th>
                        <th class="p-2">DATE</th>
                        <th class="p-2">ITEM CODE</th>
                        <th class="p-2">ITEM</th>
                        <th class="p-2">QUANTITIES</th>
                        <th class="p-2">SELLING PRICE</th>
                        <th class="p-2">TOTAL COST</th>
                        <th class="p-2">BRANCH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>";
                            echo "<td class='p-2'>" . $row['id'] . "</td>";
                            echo "<td class='p-2'>" . $row['date'] . "</td>";
                            echo "<td class='p-2'>" . $row['itemcode'] . "</td>";
                            echo "<td class='p-2'>" . $row['item'] . "</td>";
                            echo "<td class='p-2'>" . $row['quantity'] . "</td>";
                            echo "<td class='p-2'>" . $row['sellingprice'] . "</td>";
                            echo "<td class='p-2'>" . $row['totalcost'] . "</td>";
                            echo "<td class='p-2'>" . $row['branch'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center p-4'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            <div class="mt-4 flex justify-center">
                <?php
                $totalRecords = $conn->query("SELECT COUNT(*) as total FROM formdata")->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $entriesPerPage);

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' class='mx-1 px-4 py-2 border bg-blue-500 text-white rounded hover:bg-blue-700'> $i </a>";
                }
                ?>
            </div>
        </div>
    </div>
    
    <script>
        function changeDate(value) {
            window.location.href = '?date=' + value;
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
