<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();

$error_message = "";
$sql = "SELECT user_id, username, password, branch FROM login_data";
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
    <title>Sales Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="bg-green-600 text-white text-center py-4 text-xl font-bold">
        SALES RECORD SYSTEM
    </div>
    
    <div class="flex w-full">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4">User ID</th>
                        <th class="py-2 px-4">Username</th>
                        <th class="py-2 px-4">Password</th>
                        <th class="py-2 px-4">Branch</th>
                        <th class="py-2 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>";
                            echo "<td class='py-2 px-4'>" . $row['user_id'] . "</td>";
                            echo "<td class='py-2 px-4'>" . $row['username'] . "</td>";
                            echo "<td class='py-2 px-4'>" . $row['password'] . "</td>";
                            echo "<td class='py-2 px-4'>" . $row['branch'] . "</td>";
                            echo "<td class='py-2 px-4 text-center'>
                                    <button class='bg-blue-500 text-white px-4 py-1 rounded' onclick='updateUser(" . $row['user_id'] . ")'>Update</button>
                                    <button class='bg-red-500 text-white px-4 py-1 rounded' onclick='deleteUser(" . $row['user_id'] . ")'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-4'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    
    <script>
        function updateUser(userId) {
            window.location.href = 'update_user.php?user_id=' + userId;
        }
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = 'delete_user.php?user_id=' + userId;
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
