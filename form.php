<?php
require_once __DIR__ . '/db/config/db_config.php';
$conn = getDBConnection();    // Get the database connection

$error_message = ""; 

// Define a query to retrieve data (customize it based on your database structure)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM formdata WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Assign the data to $row
    }
} else {
    echo "No data found.";
    exit; // Terminate script if ID is not provided.
}
// Determine the approver from the database
$approver = $row["approver"];

// Fetch the corresponding signature from the "signatures" table
$querySignature = "SELECT sign FROM signatures WHERE approver = '$approver'";
$resultSignature = $conn->query($querySignature); // Use the $conn object

if ($resultSignature && $rowSignature = $resultSignature->fetch_assoc()) {
    $signatureImage = $rowSignature["sign"];
} else {
    // If no matching signature is found, you can set a default or handle it accordingly
    $signatureImage = 'path/to/default-signature-image.png';
}
// Include DomPDF
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new Dompdf instance
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Create an HTML string with the form data
$html = "
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Requisition Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        #header {
            text-align: center;
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        #header img {
            max-width: 100px;
            vertical-align: middle;
        }

        h1 {
            margin: 10px 0;
        }

        table {
            max-width: 500px;
            margin: 20px auto; /* Center the table on the page */
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 1px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table td {
            padding: 10px;
            border: 1px solid #ccc; /* Add borders to table cells */
        }

        table td:first-child {
            font-weight: bold; /* Make the first column text bold */
            width: 30%; /* Adjust the width as needed */
            font-size:15px; 
        }
        p{
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan='2' id='header'>
                <img src='data:image/png;base64,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' alt='Logo'>
                <h1> PURCHASE REQUISITION FORM</h1>
            </td>
        </tr>
        <tr>
            <td>Department:</td>
            <td>";
            // Display data from the database for the department
            $html .= $row["department"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Officer:</td>
            <td>";
            // Display data from the database for the officer
            $html .= $row["officer"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Designation:</td>
            <td>";
            // Display data from the database for the designation
            $html .= $row["designation"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>ID:</td>
            <td>";
            // Display data from the database for the ID
            $html .= $row["id"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>";
            // Display data from the database for the amount
            $html .= $row["amount"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Purpose of Requisition:</td>
            <td>";
            // Display data from the database for the purpose
            $html .= $row["purpose"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Activity:</td>
            <td>";
            // Display data from the database for the activity
            $html .= $row["activity"];
            $html .= "
            </td>
        </tr>
        <tr>
            <td>Justification:</td>
            <td>";
            // Display data from the database for the justification
            $html .= $row["justification"];
            $html .= "
            </td>
        </tr>
        
        <tr>
            <td>Date of Requisition:</td>
            <td>";
            // Display data from the database for the date
            $html .= $row["date"];
            $html .= "
            </td>
        </tr>
  
       
    <p colspan='2' style=' font-weight: bold;'>APPROVED BY:</p>



<tr>
    <td>Confirmed by:</td>
    <td>";
            // Display data from the database for the date
            $html .= $row["approver"];
            $html .= "
            </td>
</tr>
<tr>
    <td>Signature:</td>
    <td>
        <img src='$signatureImage' alt='Signature' style='max-width: 100px; max-height: 100px;'>
    </td>
</tr>
<tr>
    <td>Date:</td>
     <td>";
            // Display data from the database for the date
            $html .= $row["dateapproved"];
            $html .= "
            </td>
</tr>

    </table>
</body>
</html>
";

$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF as a file
$filename = "purchase_requisition_form.pdf";
$dompdf->stream($filename, array("Attachment" => false));
