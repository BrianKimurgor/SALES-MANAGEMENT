<!DOCTYPE html>
<html>
<head>
    <title>Customer Details Form</title>
</head>
<body>
    <h2>Customer Details</h2>
    <form method="POST" action="insert.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
