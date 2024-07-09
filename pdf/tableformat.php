<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Retrieve data from the database tables (assuming you already have established the database connection)
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "customer";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the tables
$sql1 = "SELECT name, phone FROM customer_details";
$result1 = $conn->query($sql1);

$sql2 = "SELECT price1, price2, price3 FROM estimation";
$result2 = $conn->query($sql2);

// Generate the PDF content
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo {
            max-width: 200px;
            height: auto;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            margin-bottom: 10px;
        }
        
        .section p {
            margin-bottom: 5px;
        }
        
        .introduction {
            background-color: lightblue;
            color: blue;
            padding: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="/doompdf/pictures/klblogo.PNG" alt="logo" class="logo">
    </div>
    
    <div class="section">
        <div class="section introduction">
            <h2>KENYA LITERATURE BUREAU</h2>
            <h2>HEAD OFFICE AND PRINTING PRESS</h2>
            <p>KLB ROAD,OFF POPO ROAD</p>
            <p>P.O.BOX 30022-00100 GPO,NAIROBI</p>
            <p>TEL:+254(20) 354 1196/7, +254(20) 204 8136</p>
            <p>TEL:+254711 318 188, +254732 344 599</p>
            <p>EMAIL:info@klb.co.ke | website:www.klb.co.ke</p>
            <p>Thank you for choosing KLB, we value you our customer:</p>
        </div>

        <h2>Customer Details</h2>
        
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
            </tr>';

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $html .= '
            <tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row['phone'] . '</td>
            </tr>';
    }
} else {
    $html .= '
            <tr>
                <td colspan="2">No customer details found.</td>
            </tr>';
}

$html .= '</table>
        
        <h2>Estimation Details</h2>
        
        <table>
            <tr>
                <th>Price 1</th>
                <th>Price 2</th>
                <th>Price 3</th>
                <th>Sum</th>
            </tr>';

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $sum = $row['price1'] + $row['price2'] + $row['price3'];
        $html .= '
            <tr>
                <td>' . $row['price1'] . '</td>
                <td>' . $row['price2'] . '</td>
                <td>' . $row['price3'] . '</td>
                <td>' . $sum . '</td>
            </tr>';
    }
} else {
    $html .= '
            <tr>
                <td colspan="4">No estimation details found.</td>
            </tr>';
}

$html .= '</table>

    </div>
</body>
</html>';
$dompdf->loadHtml($html);

// Set the paper size and orientation (optional)
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to the browser
$dompdf->stream("customer_estimation.pdf", array("Attachment" => false));
// ...
