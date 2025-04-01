<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemid = $_POST['id'];
    $newitemcode = $_POST['newitemcode'];
    $newdescription = $_POST['newdescription'];
    $newcostprice = $_POST['newcostprice'];
    $newsellingprice = $_POST['newsellingprice'];

    $sql = "UPDATE items SET itemcode = '$newitemcode', description = '$newdescription', costprice = '$newcostprice', sellingprice = '$newsellingprice' WHERE id = $itemid";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Item updated successfully.";
    } else {
        echo "Error updating item: " . $conn->error;
    }
}

$itemid = $_GET['id'];
$sql = "SELECT id, itemcode, description, costprice, sellingprice FROM items WHERE id = $itemid";
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
    <title>Update Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #006799;
        }
    </style>
</head>

<body>
    <form method="post" action="">
        <h2>Update Items</h2>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="newitemcode">New Item code:</label>
        <input type="text" name="newitemcode" value="<?php echo $row['itemcode']; ?>" required>

        <label for="newdescription">New Description:</label>
        <input type="text" name="newdescription" value="<?php echo $row['description']; ?>" required>

        <label for="newcostprice">New Cost price:</label>
        <input type="text" name="newcostprice" value="<?php echo $row['costprice']; ?>" required>
        <label for="newsellingprice">New Selling price:</label>
        <input type="text" name="newsellingprice" value="<?php echo $row['sellingprice']; ?>" required>

        <input type="submit" value="Update Item">
    </form>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "item_view.php";</script>';
    }
    ?>

</body>

</html>