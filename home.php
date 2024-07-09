<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} 
else {
    
    header("Location: login.php");
    exit;
}
?>

<?php

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
<html>
 <header>
    
    
        
    </button>
</header>
   
    <style>

#header {
            text-align: center;
            padding: 10px;
            margin-left: 50;
            background-color: green;
            color: #fff;
        }

        #header img {
            max-width: 100px;
            vertical-align: middle;
        }

        h1 {
            margin: 10px 0;
        }

        p {
            margin: 10px 0;
            text-align: center;

            font-weight: bold;
        }
            header {
  background-color: #333;
  color: white;
  padding: 0.5rem;
}
       .logout-button {
  background-color: white;
  color: white;
  text-align: right;
  margin-right:10px ;
  margin-left:1250px ;
  padding: 0.5rem;
}
     .home-button {
  background-color: white;
  color: white;
  text-align: left;
  padding-left: 10px;
  padding: 0.5rem;
}
button{
    font-weight: bold;
}

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        #header {
            text-align: center;
            padding: 10px;
            background-color: green;
            color: #fff;
        }

        #header img {
            max-width: 100px;
            vertical-align: middle;
        }

        h1 {
            margin: 10px 0;
        }

        p {
            margin: 10px 0;
            text-align: center;

            font-weight: bold;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .form-group label,
        .form-group input,
        .form-group textarea {
            flex: 1;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        input[type="submit"] {
            display: block;
            margin: 0 auto;
            background-color: green;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: 36;
            width: 150;
        }

        input[type="submit"]:hover {
            background-color: darkred;
            color: white;
            border: none;
            height: 36;
            width: 150;
        }
        .logout-button a span {
    margin-right: 5px; /* Adjust the spacing as needed */
}
.form-group select {
    width: 50%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.form-group select,
.form-group input,
.form-group textarea {
    width: 50%;
    padding: 12px; /* Increased padding for larger size */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px; /* Increased font size */
    font-weight: bold; /* Bold font */
}

input[type="submit"] {
    display: block;
    margin: 0 auto;
    background-color: green;
    color: #fff;
    padding: 12px 20px; /* Increased padding for larger size */
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: darkred;
    color: white;
    border: none;
}
  .sidebar {
            width: 200px;
            height: 100%;
            position: fixed;
            background-color: #333;
            padding-top: 20px;
            padding-left: 10px;
            color: white;
        }

        .sidebar a {
            padding: 8px 8px 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 200px; /* Adjust the margin based on the sidebar width */
            padding: 16px;
        }     
    </style>
    <script>
        // JavaScript function to update selling price based on selected item
        function updateSellingPrice() {
            var itemDropdown = document.getElementById("item");
            var sellingPriceInput = document.getElementById("cost");
            var selectedItem = itemDropdown.value;

            // Fetch the selling price for the selected item
            var sellingPrice = <?php echo json_encode($sellingPrices); ?>[selectedItem];

            // Update the selling price input field
            sellingPriceInput.value = sellingPrice;

            // Call the function to update total and date
            updateSellingPriceAndTotal();
        }

        // JavaScript function to update selling price and calculate total
        function updateSellingPriceAndTotal() {
            var itemDropdown = document.getElementById("item");
            var quantityInput = document.getElementById("quantities");
            var sellingPriceInput = document.getElementById("cost");
            var totalInput = document.getElementById("total");
            var dateInput = document.getElementById("date");

            var selectedItem = itemDropdown.value;
            var quantity = quantityInput.value;
            var sellingPrice = <?php echo json_encode($sellingPrices); ?>[selectedItem];

            // Update the selling price input field
            sellingPriceInput.value = sellingPrice;

            // Calculate and update the total
            var total = quantity * sellingPrice;
            totalInput.value = total.toFixed(2); // Display total with two decimal places

            // Set the current date
            var currentDate = new Date().toISOString().split('T')[0];
            dateInput.value = currentDate;
        }

    </script>
</head>

<body>
    <div class="sidebar">
        <a href="index.php">
            <span>&#128100;</span> <!-- Person icon HTML entity -->
            LOGOUT
        </a>
        <a href="home.php">Dashboard</a>
        
    </div>
    <header>
        <!-- Your existing header -->
    </header>
    <div id="header">
        <h1>SALES RECORD SYSTEM</h1>
    </div>

        <form action="submit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="userid" value="<?php echo isset($user_id) ? $user_id : ''; ?>">

    <div class="form-group">
        <label for="item">ITEM:</label>
        <!-- Dropdown list of items -->
        <select name="item" id="item" onchange="updateSellingPrice()" required>
            <?php foreach ($items as $item) : ?>
                <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantities">QUANTITIES:</label>
        <input type="text" name="quantities" id="quantities" onchange="updateSellingPriceAndTotal()" required>
    </div>
    <div class="form-group">
        <label for="cost">SELLING PRICE:</label>
        <input type="number" name="cost" id="cost" required readonly>
    </div>
    <div class="form-group">
        <label for="total">TOTAL AMOUNT:</label>
        <input type="text" name="total" id="total" required readonly>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" readonly>
    </div>
    <input type="submit" value="Submit">
</form>

</body>
</html>
