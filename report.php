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
    <?php include 'includes/header.php'; ?>

    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <div class="content flex-grow p-8">
            <div class="form-group mb-6">
                <label for="date" class="text-lg font-semibold text-green-600">Select Date:</label>
                <div class="relative">
                    <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" onchange="changeDate(this.value)" 
                           class="mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <button onclick="changeDate(document.getElementById('date').value)" 
                            class="absolute right-0 top-0 mt-2 mr-2 inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BRANCH</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ITEM CODE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DESCRIPTION</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QUANTITIES</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UNIT COST</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL COST</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50 transition-colors duration-150'>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['branch']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['itemcode']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['item']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['quantity']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['sellingprice']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['totalcost']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['date']}</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2'>
                                        <button onclick='updateUser({$row['id']})' 
                                                class='inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>
                                            <svg class='w-4 h-4 mr-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                                            </svg>
                                            Edit
                                        </button>
                                        <button onclick='deleteUser({$row['id']})' 
                                                class='inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200'>
                                            <svg class='w-4 h-4 mr-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                                            </svg>
                                            Delete
                                        </button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='px-6 py-4 text-center text-sm text-gray-500'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination mt-6 flex justify-center space-x-2">
                <?php
                $totalRecords = $conn->query("SELECT COUNT(*) as total FROM formdata")->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $entriesPerPage);

                // Previous page button
                if ($page > 1) {
                    echo "<a href='?page=" . ($page - 1) . "&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' 
                            class='inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>
                            <svg class='w-4 h-4 mr-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 19l-7-7 7-7'/>
                            </svg>
                            Previous
                          </a>";
                }

                // Page numbers
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' 
                            class='inline-flex items-center px-3 py-1.5 " . 
                            ($page == $i ? 'bg-green-600' : 'bg-green-500 hover:bg-green-600') . 
                            " text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>$i</a>";
                }

                // Next page button
                if ($page < $totalPages) {
                    echo "<a href='?page=" . ($page + 1) . "&entries=$entriesPerPage" . ($selectedDate ? "&date=$selectedDate" : "") . "' 
                            class='inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>
                            Next
                            <svg class='w-4 h-4 ml-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5l7 7-7 7'/>
                            </svg>
                          </a>";
                }
                ?>
            </div>

            <div class="mt-4 text-center">
                <p class="font-bold text-xl text-green-600">Grand Total for <?php echo $selectedDate; ?>: Ksh <?php echo number_format($grandTotal, 2); ?></p>
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
