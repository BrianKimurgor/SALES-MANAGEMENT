<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$sql = "SELECT id, itemcode, description, costprice, sellingprice, status FROM items";

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <div class="content w-full p-8 ml-6 pt-0">
            <h2 class="text-xl font-bold mb-6 text-center">Items List</h2>
            <table class="min-w-full table-auto border-collapse shadow-lg bg-white rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-2 border-b">ITEM ID</th>
                        <th class="px-4 py-2 border-b">ITEM CODE</th>
                        <th class="px-4 py-2 border-b">DESCRIPTION</th>
                        <th class="px-4 py-2 border-b">COST PRICE</th>
                        <th class="px-4 py-2 border-b">SELLING PRICE</th>
                        <th class="px-4 py-2 border-b">STATUS</th>
                        <th class="px-4 py-2 border-b">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b  mt-0'>";
                            echo "<td class='px-4 py-1'>" . $row['id'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['itemcode'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['description'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['costprice'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['sellingprice'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['status'] . "</td>";
                            echo "<td class='px-4 py-2'>
                                    <button class='bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600' onclick='updateUser(" . $row['id'] . ")'>Update</button>
                                    <button class='bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-2'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="pagination flex justify-center mt-4">
                <!-- Example Pagination (can be dynamic based on your database) -->
                <a href="#" class="px-4 py-2 mx-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">1</a>
                <a href="#" class="px-4 py-2 mx-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">2</a>
                <a href="#" class="px-4 py-2 mx-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">3</a>
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
