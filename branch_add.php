<?php

require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

$conn->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $branchcode = $_POST['branchcode'];
  $branchname = $_POST['branchname'];
  $branch_description = $_POST['branch_description'];
  

  $sql = "INSERT INTO branches (branchcode, branchname,branch_description) VALUES ( ' $branchcode',  '$branchname','$branch_description')";

  if ($conn->query($sql) === TRUE) {
  
     echo '<div class="success-message">Branch added successfully.</div><button id="okButton">OK</button>';
      header("Location: view_branch.php");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
