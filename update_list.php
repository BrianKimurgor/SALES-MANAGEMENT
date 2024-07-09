<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $successMessage = "list updated successfully.";
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
    <title>Update list</title>
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
        <h2>Update list</h2>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="newitemcode">New Item code:</label>
        <input type="text" name="newitemcode" value="<?php echo $row['itemcode']; ?>" required>

        <label for="newdescription">New Description:</label>
        <input type="text" name="newdescription" value="<?php echo $row['item']; ?>" required>

        <label for="newquantity">New quantity:</label>
        <input type="text" name="newquantity" value="<?php echo $row['quantity']; ?>" required>
        <label for="newsellingprice">New Selling price:</label>
        <input type="text" name="newsellingprice" value="<?php echo $row['sellingprice']; ?>" required>
<label for="newtotal">New total cost:</label>
        <input type="text" name="newtotal" value="<?php echo $row['totalcost']; ?>" required>
        <input type="submit" value="Update list">
    </form>

    <?php
    if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '"); window.location.href = "report.php";</script>';
    }
    ?>

</body>

</html>