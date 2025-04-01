<?php

require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$conn->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $itemcode = $_POST['itemcode'];
  $description = $_POST['description'];
  $costprice = $_POST['costprice'];
  $sellingprice = $_POST['sellingprice'];

  $sql = "INSERT INTO items (itemcode, description,costprice,sellingprice,status) VALUES ( '$itemcode',  '$description','$costprice','$sellingprice','available')";

  if ($conn->query($sql) === TRUE) {
  
     echo '<div class="success-message">Item added successfully.</div><button id="okButton">OK</button>';
      header("Location: Admin.php");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
