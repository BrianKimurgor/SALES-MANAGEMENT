<!DOCTYPE html>
<html>
<head>
  <title>ADD BRANCH</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <div class="bg-green-600 text-white py-4 text-center">
    <h1 class="text-2xl font-bold">SALES RECORD SYSTEM</h1>
  </div>

  <div class="flex w-full">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-64 p-8 w-full">
      <h2 class="text-2xl font-bold text-center mb-8">ADD BRANCH</h2>
      
      <form action="branch_add.php" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
          <label for="branchcode" class="block text-gray-700 font-bold mb-2">BRANCH CODE:</label>
          <input type="text" id="branchcode" name="branchcode" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
          <label for="branchname" class="block text-gray-700 font-bold mb-2">BRANCH NAME:</label>
          <input type="text" id="branchname" name="branchname" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-6">
          <label for="branch_description" class="block text-gray-700 font-bold mb-2">BRANCH DESCRIPTION:</label>
          <input type="text" id="branch_description" name="branch_description" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-300">
          Add Branch
        </button>
      </form>
    </div>
  </div>
</body>
</html>
