<!DOCTYPE html>
<html>
<head>
    <title>PDF Form</title>
    <style>
        /* Add CSS styles for your PDF form here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-top: 20px;
        }
        .logo {
            max-width: 100px;
        }
        h1 {
            margin: 10px 0;
        }
        .form-data {
            margin: 20px 0;
            border-collapse: collapse;
        }
        .form-data th, .form-data td {
            border: 1px solid #000;
            padding: 5px;
        }
        .confirmation {
            width: 100%;
            margin-top: 20px;
        }
        .confirmation th, .confirmation td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Logo" class="logo">
            <h1>Form Title</h1>
        </div>

        <table class="form-data">
            <tr>
                <th>Department</th>
                <td>Department Data</td>
            </tr>
            <tr>
                <th>Officer</th>
                <td>Officer Data</td>
            </tr>
            <tr>
                <th>Designation</th>
                <td>Designation Data</td>
            </tr>
            <tr>
                <th>ID</th>
                <td>ID Data</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>Amount Data</td>
            </tr>
            <tr>
                <th>Purpose</th>
                <td>Purpose Data</td>
            </tr>
            <tr>
                <th>Activity</th>
                <td>Activity Data</td>
            </tr>
            <tr>
                <th>Justification</th>
                <td>Justification Data</td>
            </tr>
        </table>

        <table class="confirmation">
            <tr>
                <th>Confirmation</th>
                <th>Finance Manager</th>
                <th>MD</th>
            </tr>
            <tr>
                <td>Signature</td>
                <td>Finance Manager Name</td>
                <td>MD Name</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>Signature Date</td>
                <td>MD Date</td>
            </tr>
        </table>
    </div>
</body>
</html>
