<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemid = $_POST['id'];
    $newitemcode = $_POST['newitemcode'];
    $newdescription = $_POST['newdescription'];
    $newquantity = $_POST['newquantity'];
    $newsellingprice = $_POST['newsellingprice'];
    $newtotal = $_POST['newtotal'];


    $sql = "UPDATE formdata SET itemcode = '$newitemcode', item = '$newdescription', quantity = '$newquantity', sellingprice = '$newsellingprice', totalcost=' $newtotal' WHERE id = $itemid";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "List updated successfully.";
    } else {
        echo "Error updating list: " . $conn->error;
    }
}

$itemid = $_GET['id'];
$sql = "SELECT id, itemcode, item, quantity, sellingprice,totalcost FROM formdata WHERE id = $itemid";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="post" action="" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Update List</h2>

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="mb-4">
            <label for="newitemcode" class="block text-gray-700 text-sm font-medium mb-2">New Item Code:</label>
            <input type="text" name="newitemcode" value="<?php echo $row['itemcode']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="newdescription" class="block text-gray-700 text-sm font-medium mb-2">New Description:</label>
            <input type="text" name="newdescription" value="<?php echo $row['item']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="newquantity" class="block text-gray-700 text-sm font-medium mb-2">New Quantity:</label>
            <input type="text" name="newquantity" value="<?php echo $row['quantity']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="newsellingprice" class="block text-gray-700 text-sm font-medium mb-2">New Selling Price:</label>
            <input type="text" name="newsellingprice" value="<?php echo $row['sellingprice']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label for="newtotal" class="block text-gray-700 text-sm font-medium mb-2">New Total Cost:</label>
            <input type="text" name="newtotal" value="<?php echo $row['totalcost']; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Update List
            </button>
        </div>
    </form>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "report.php";</script>';
    }
    ?>

</body>

</html>
