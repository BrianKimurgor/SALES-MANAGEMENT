<?php

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "salesrecord";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
