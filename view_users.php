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
    <?php include 'includes/header.php'; ?>
    
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
                            echo "<td class='py-2 px-4 text-center space-x-2'>
                                    <button onclick='updateUser(" . $row['user_id'] . ")' 
                                            class='inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200'>
                                        <svg class='w-4 h-4 mr-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button onclick='deleteUser(" . $row['user_id'] . ")' 
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
