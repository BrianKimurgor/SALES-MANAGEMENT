<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADD ITEM</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <?php include 'includes/header.php'; ?>

  <div class="flex w-full">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Content -->
    <div class="flex-1 p-8">
      <h2 class="text-2xl font-semibold text-center mb-8">ADD ITEMS</h2>
      <form action="item_add.php" method="POST" class="max-w-xl mx-auto bg-white p-6 rounded shadow-md space-y-4">
        <label for="itemcode" class="block text-lg font-medium text-gray-700">ITEM CODE:</label>
        <input type="text" id="itemcode" name="itemcode" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600">

        <label for="description" class="block text-lg font-medium text-gray-700">ITEM DESCRIPTION:</label>
        <input type="text" id="description" name="description" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600">

        <label for="costprice" class="block text-lg font-medium text-gray-700">COST PRICE:</label>
        <input type="text" id="costprice" name="costprice" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600">

        <label for="sellingprice" class="block text-lg font-medium text-gray-700">SELLING PRICE:</label>
        <input type="text" id="sellingprice" name="sellingprice" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600">

        <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-md shadow hover:bg-green-700 transition duration-300">
          Add Item
        </button>
      </form>
    </div>
  </div>
</body>
</html>
