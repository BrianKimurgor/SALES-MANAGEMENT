<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

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
// Calculate Grand Total for the chosen date
$grandTotalQuery = "SELECT SUM(totalcost) AS grandTotal FROM formdata WHERE date = '$dateFilter'";
$grandTotalResult = $conn->query($grandTotalQuery);
$grandTotal = $grandTotalResult->fetch_assoc()['grandTotal'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SALES MANAGEMENT SYSTEM</title>
    <!-- Include TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div id="header" class="bg-green-500 text-white text-center py-4">
        <h1 class="text-2xl">SALES RECORD SYSTEM</h1>
    </div>

    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <div class="content flex-grow p-8">
            <div class="form-group mb-6">
                <label for="date" class="text-lg font-semibold text-green-600">Select Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" onchange="changeDate(this.value)" class="mt-2 p-2 border rounded-md">
            </div>

            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">BRANCH</th>
                        <th class="px-4 py-2 bg-gray-100">ITEM CODE</th>
                        <th class="px-4 py-2 bg-gray-100">DESCRIPTION</th>
                        <th class="px-4 py-2 bg-gray-100">QUANTITIES</th>
                        <th class="px-4 py-2 bg-gray-100">UNIT COST</th>
                        <th class="px-4 py-2 bg-gray-100">TOTAL COST</th>
                        <th class="px-4 py-2 bg-gray-100">DATE</th>
                        <th class="px-4 py-2 bg-gray-100">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='px-4 py-2'>{$row['branch']}</td>";
                            echo "<td class='px-4 py-2'>{$row['itemcode']}</td>";
                            echo "<td class='px-4 py-2'>{$row['item']}</td>";
                            echo "<td class='px-4 py-2'>{$row['quantity']}</td>";
                            echo "<td class='px-4 py-2'>{$row['sellingprice']}</td>";
                            echo "<td class='px-4 py-2'>{$row['totalcost']}</td>";
                            echo "<td class='px-4 py-2'>{$row['date']}</td>";
                            echo "<td class='px-4 py-2'>
                                    <button class='px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600' onclick='updateUser({$row['id']})'>Update</button>
                                    <button class='px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600' onclick='deleteUser({$row['id']})'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center py-4'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="pagination mt-6">
                <?php
                $totalRecords = $conn->query("SELECT COUNT(*) as total FROM formdata")->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $entriesPerPage);

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' class='px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 " . ($page == $i ? 'bg-blue-700' : '') . "'>$i</a>";
                }
                ?>
            </div>

            <div class="mt-4 text-center">
                <p class="font-bold text-xl">Grand Total for <?php echo $selectedDate; ?>: Ksh <?php echo number_format($grandTotal, 2); ?></p>
            </div>
        </div>
    </div>

    <script>
        function updateUser(id) {
            window.location.href = 'update_list.php?id=' + id;
        }

        function deleteUser(id) {
            var confirmDelete = confirm("Are you sure you want to delete this item?");
            if (confirmDelete) {
                window.location.href = 'delete_list.php?id=' + id;
            }
        }

        function changeDate(value) {
            window.location.href = '?date=' + value;
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
