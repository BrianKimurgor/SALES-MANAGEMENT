<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$sql = "SELECT id, itemcode, description, costprice, sellingprice, status FROM items WHERE status='sold'";

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
        <div class="flex-1 p-8">
            <div class="mt-8">
                <table class="min-w-full table-auto bg-white border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left border-b">Item Code</th>
                            <th class="px-4 py-2 text-left border-b">Description</th>
                            <th class="px-4 py-2 text-left border-b">Cost Price</th>
                            <th class="px-4 py-2 text-left border-b">Selling Price</th>
                            <th class="px-4 py-2 text-left border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['itemcode'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['description'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['costprice'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['sellingprice'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>
                                        <button class='bg-blue-500 text-white px-4 py-2 mr-2 rounded hover:bg-blue-700' onclick='updateUser(" . $row['id'] . ")'>Update</button>
                                        <button class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-4 py-2 border-b text-center'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
</body>
</html>

<?php
$conn->close();
?>
