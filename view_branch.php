<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$sql = "SELECT id, branchcode, branchname, branch_description FROM branches";

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
    <script src="https://cdn.tailwindcss.com"></script> <!-- Include Tailwind CSS -->
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content ml-64 p-8">
            <!-- Branch Table -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border-b text-left text-lg font-semibold">BRANCH ID</th>
                            <th class="px-4 py-2 border-b text-left text-lg font-semibold">BRANCH CODE</th>
                            <th class="px-4 py-2 border-b text-left text-lg font-semibold">BRANCH NAME</th>
                            <th class="px-4 py-2 border-b text-left text-lg font-semibold">BRANCH DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-100'>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['id'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['branchcode'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['branchname'] . "</td>";
                                echo "<td class='px-4 py-2 border-b'>" . $row['branch_description'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center py-2'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Add JS for handling interactions if necessary
    </script>

</body>

</html>

<?php
$conn->close();
?>
