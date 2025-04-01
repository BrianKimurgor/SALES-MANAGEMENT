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
                                    <button class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600' onclick='updateUser(" . $row['id'] . ")'>Update</button>
                                    <button class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
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
