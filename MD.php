<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "form_data";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Number of entries to display
$rowsPerPage = isset($_GET['entries']) ? $_GET['entries'] : 10;

// Calculate the current page based on the query string
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting point for the SQL query
$startFrom = ($currentPage - 1) * $rowsPerPage;

// SQL query to fetch records where approver is "MD" with pagination
$sql = "SELECT id, department, amount, officer, purpose, designation, status, attachment FROM formdata WHERE approver = 'MD' LIMIT $startFrom, $rowsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <style>
             header {
  background-color: #333;
  color: #fff;
  text-align: right;
  padding: 0.5rem;
}
button{
    font-weight: bold;
    background-color: red;
}
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 50px;
            margin-left: 100px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            background-color: #008CBA;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            text-decoration: none;
            color: #008CBA;
            border: 1px solid #008CBA;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .pagination .active a {
            background-color: #008CBA;
            color: white;
        }

        select {
            padding: 5px;
        }
    </style>

    <title>MANAGING DIR</title>
    <header>
   
    <button><a href="userlogin.php">LOGOUT</a></button>
  </header>
</head>

<body>
    <label for="entries">Show entries:</label>
    <select id="entries" name="entries" onchange="changeEntries(this.value)">
        <option value="10" <?php echo ($rowsPerPage == 10) ? 'selected' : ''; ?>>10</option>
        <option value="20" <?php echo ($rowsPerPage == 20) ? 'selected' : ''; ?>>20</option>
        <option value="50" <?php echo ($rowsPerPage == 50) ? 'selected' : ''; ?>>50</option>
    </select>

    <table>
        <tr>
            <th>ID/P.No</th>
            <th>Name of officer</th>
            <th>Purpose of Requisition</th>
            <th>Designation</th>
            <th>Amount Requested Ksh</th>
            <th>Department</th>
            <th>Attachment</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['officer'] . "</td>";
                echo "<td>" . $row['purpose'] . "</td>";
                echo "<td>" . $row['designation'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td><a href='#' onclick='viewPDF(\"" . $row['attachment'] . "\")'>View PDF</a></td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>";
                if ($row['status'] === 'pending') {
                    echo "<button onclick='approve(" . $row['id'] . ")'>Approve</button>";
                    echo "<button onclick='disapprove(" . $row['id'] . ")'>Disapprove</button>";
                } else {
                    echo "N/A";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No records found.</td></tr>";
        }
        ?>
    </table>

    <ul class="pagination">
        <?php
        // Calculate the number of pages
        $sql = "SELECT COUNT(*) AS total FROM formdata WHERE approver = 'MD'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $totalRows = $row['total'];
        $totalPages = ceil($totalRows / $rowsPerPage);

        // Create pagination links
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            echo "<li class='$activeClass'><a href='?page=$i&entries=$rowsPerPage'>$i</a></li>";
        }
        ?>
    </ul>

    <script>
        function changeEntries(value) {
            window.location.href = '?page=1&entries=' + value;
        }

        function approve(id) {
            // Make an AJAX request to update the status in the database
            fetch('update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id,
                        action: 'approve'
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // After a successful update, disable the approve button
                        const approveButton = document.querySelector(`button[data-id="${id}"][data-action="approve"]`);
                        approveButton.disabled = true;
                        // Update the status in the table
                        const statusCell = approveButton.parentElement.previousElementSibling;
                        statusCell.textContent = "approved";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function disapprove(id) {
            // Make an AJAX request to update the status in the database
            fetch('update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id,
                        action: 'disapprove'
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // After a successful update, disable the disapprove button
                        const disapproveButton = document.querySelector(`button[data-id="${id}"][data-action="disapprove"]`);
                        disapproveButton.disabled = true;
                        // Update the status in the table
                        const statusCell = disapproveButton.parentElement.previousElementSibling;
                        statusCell.textContent = "disapproved";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function viewPDF(attachmentURL) {
            // Open the PDF in a new tab
            window.open(attachmentURL, '_blank');
        }
    </script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
