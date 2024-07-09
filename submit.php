<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$item = $_POST['item'];
$quantities = $_POST['quantities'];
$cost = $_POST['cost'];
$total = $_POST['total'];
$date = $_POST['date'];
$userid = $_POST['userid'];

$branch = ''; 
$itemcode = '';

// Retrieve branch from login_data
$branchQuery = "SELECT branch FROM login_data WHERE user_id = '$userid'";
$branchResult = $conn->query($branchQuery);

if ($branchResult->num_rows == 1) {
    $row = $branchResult->fetch_assoc();
    $branch = $row['branch'];
}

// Retrieve itemcode from items based on the provided item description
$itemcodeQuery = "SELECT itemcode FROM items WHERE description = '$item'";
$itemcodeResult = $conn->query($itemcodeQuery);

if ($itemcodeResult->num_rows == 1) {
    $row = $itemcodeResult->fetch_assoc();
    $itemcode = $row['itemcode'];
}

$sql = "INSERT INTO formdata (item, itemcode, quantity, sellingprice, totalcost, date, user_id, branch)
        VALUES ('$item', '$itemcode', '$quantities', '$cost', '$total', '$date', '$userid', '$branch')";

if ($conn->query($sql) === TRUE) {
    // Update the status column in the items table
    $updateStatusQuery = "UPDATE items SET status = 'sold' WHERE itemcode = '$itemcode'";
    if ($conn->query($updateStatusQuery) === FALSE) {
        echo "Error updating status: " . $conn->error;
    }

    echo '<div class="success-message">Your sales record has been submitted successfully.</div><button id="okButton">OK</button>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<style>
.success-message {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
}

button#okButton {
    background-color: #008CBA;
    color: white;
    padding: 10px 20px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    display: block;
    margin: 0 auto; /* Center the button horizontally */
}
</style>

<script>
document.getElementById("okButton").addEventListener("click", function() {
    window.location.href = "home.php";
});
</script>
