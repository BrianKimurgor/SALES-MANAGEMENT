<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 
$sqlItems = "SELECT description FROM items WHERE status='available'";
$resultItems = $conn->query($sqlItems);

$items = [];
if ($resultItems->num_rows > 0) {
    while ($row = $resultItems->fetch_assoc()) {
        $items[] = $row['description'];
    }
}

$sqlPrices = "SELECT description, sellingprice FROM items";
$resultPrices = $conn->query($sqlPrices);

$sellingPrices = [];
if ($resultPrices->num_rows > 0) {
    while ($row = $resultPrices->fetch_assoc()) {
        $sellingPrices[$row['description']] = $row['sellingprice'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Record System</title>
    <script>
        function updateSellingPrice() {
            var itemDropdown = document.getElementById("item");
            var sellingPriceInput = document.getElementById("cost");
            var selectedItem = itemDropdown.value;

            var sellingPrice = <?php echo json_encode($sellingPrices); ?>[selectedItem];

            sellingPriceInput.value = sellingPrice;

            updateSellingPriceAndTotal();
        }

        function updateSellingPriceAndTotal() {
            var itemDropdown = document.getElementById("item");
            var quantityInput = document.getElementById("quantities");
            var sellingPriceInput = document.getElementById("cost");
            var totalInput = document.getElementById("total");
            var dateInput = document.getElementById("date");

            var selectedItem = itemDropdown.value;
            var quantity = quantityInput.value;
            var sellingPrice = <?php echo json_encode($sellingPrices); ?>[selectedItem];

            sellingPriceInput.value = sellingPrice;

            var total = quantity * sellingPrice;
            totalInput.value = total.toFixed(2);

            var currentDate = new Date().toISOString().split('T')[0];
            dateInput.value = currentDate;
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 p-4">
            <a href="home.php" class="text-white text-xl font-semibold block mb-4">
                <span>&#128100;</span> Dashboard
            </a>
            <a href="index.php" class="text-white text-xl font-semibold block mb-4">
                <span>&#128100;</span> Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <header class="text-center mb-6">
                <h1 class="text-3xl font-bold text-green-600">SALES RECORD SYSTEM</h1>
            </header>

            <form action="submit.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
                <input type="hidden" name="userid" value="<?php echo isset($user_id) ? $user_id : ''; ?>">

                <!-- Item Selection -->
                <div class="mb-4">
                    <label for="item" class="block text-lg font-medium text-gray-700">Item:</label>
                    <select name="item" id="item" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" onchange="updateSellingPrice()" required>
                        <?php foreach ($items as $item) : ?>
                            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Quantity Input -->
                <div class="mb-4">
                    <label for="quantities" class="block text-lg font-medium text-gray-700">Quantity:</label>
                    <input type="text" name="quantities" id="quantities" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" onchange="updateSellingPriceAndTotal()" required>
                </div>

                <!-- Selling Price Input -->
                <div class="mb-4">
                    <label for="cost" class="block text-lg font-medium text-gray-700">Selling Price:</label>
                    <input type="number" name="cost" id="cost" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required readonly>
                </div>

                <!-- Total Amount Input -->
                <div class="mb-4">
                    <label for="total" class="block text-lg font-medium text-gray-700">Total Amount:</label>
                    <input type="text" name="total" id="total" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required readonly>
                </div>

                <!-- Date Input -->
                <div class="mb-4">
                    <label for="date" class="block text-lg font-medium text-gray-700">Date:</label>
                    <input type="date" name="date" id="date" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" readonly>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <input type="submit" value="Submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>
