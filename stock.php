<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$sql = "SELECT id, itemcode,description,costprice,sellingprice,status FROM items WHERE status='available'";

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
    <title>SALES MANAGEMENT SYSTEM</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-gray-600">ITEM CODE</th>
                        <th class="px-6 py-3 text-left text-gray-600">DESCRIPTION</th>
                        <th class="px-6 py-3 text-left text-gray-600">COST PRICE</th>
                        <th class="px-6 py-3 text-left text-gray-600">SELLING PRICE</th>
                        <th class="px-6 py-3 text-left text-gray-600">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>";
                            echo "<td class='px-6 py-3'>" . $row['itemcode'] . "</td>";
                            echo "<td class='px-6 py-3'>" . $row['description'] . "</td>";
                            echo "<td class='px-6 py-3'>" . $row['costprice'] . "</td>";
                            echo "<td class='px-6 py-3'>" . $row['sellingprice'] . "</td>";
                            echo "<td class='px-6 py-3'>
                                    <button onclick='updateUser(" . $row['id'] . ")' 
                                            class='inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>
                                        <svg class='w-4 h-4 mr-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button onclick='deleteUser(" . $row['id'] . ")' 
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
                        echo "<tr><td colspan='5' class='px-6 py-3 text-center text-gray-500'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="mt-6">
                <script>
                    function updateUser(id) {
                        window.location.href = 'update_items.php?id=' + id;
                    }

                    function deleteUser(id) {
                        var confirmDelete = confirm("Are you sure you want to delete this item?");
                        if (confirmDelete) {
                            window.location.href = 'delete_item.php?id=' + id;
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
