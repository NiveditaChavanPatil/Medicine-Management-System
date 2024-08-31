<?php
error_reporting(0);
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_management";


$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get values from the form
$medicine_id = isset($_POST["medicine_id"]) ? $_POST["medicine_id"] : "";
$medicine_name = isset($_POST["med_name"]) ? $_POST["med_name"] : "";
$category = isset($_POST["category"]) ? $_POST["category"] : "";
$manufacturer = isset($_POST["manufacturer"]) ? $_POST["manufacturer"] : "";
$unit_price = isset($_POST["unit_price"]) ? $_POST["unit_price"] : "";
$quantity_available = isset($_POST["quantity_available"]) ? $_POST["quantity_available"] : "";
$expiry_date = isset($_POST["expiry_date"]) ? $_POST["expiry_date"] : "";


// Insert values into the database
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "INSERT INTO medicine (medicine_id, medicine_name, category, manufacturer, unit_price, quantity_available, expiry_dates)
    VALUES ($medicine_id, '$medicine_name', '$category', '$manufacturer', '$unit_price', '$quantity_available', '$expiry_dates' )";
   


    if ($conn->query($sql) === TRUE) {
         echo "New Medicine Added successfully...</br>";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $last_updated = date('Y-m-d');


    $sql = "INSERT INTO stock_availability (medicine_id, quantity_available, last_updated)
            VALUES ('$medicine_id', '$quantity_available', '$last_updated')";


    if ($conn->query($sql) === TRUE) {
        echo "Stock Added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}




// Fetch and display data from the medicine table
$sql_select = "SELECT * FROM medicine";
$result = $conn->query($sql_select);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Medicine</title>
</head>
<body>
    <h2>Medicine Management</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Corrected input names -->
        <label for="medicine_id">Medicine ID:</label>
        <input type="text" name="medicine_id" required>
       


        <label for="med_name">Medicine Name:</label>
        <input type="text" name="med_name" required>


        <label for="category">Category:</label>
        <input type="text" name="category" required>


        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" required>


        <label for="unit_price">Unit Price:</label>
        <input type="text" name="unit_price" required>


        <label for="quantity_available">Quantity Available:</label>
        <input type="text" name="quantity_available" required>


        <label for="expiry_date">Expiry Date:</label>
        <input type="date" name="expiry_date" required>


        <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add Medicine</button></br>
       
    </form>


    <h3>Medicine Table</h3>
    <table>
        <tr>
            <br><th>Medicine ID</th></br>
            <th>Medicine Name</th>
            <th>Category</th>
            <th>Manufacturer</th>  
            <th>Unit Price</th>
            <th>Quantity Available</th>
            <th>Expiry Date</th>
        </tr>


        <?php
        // Display data from the medicine table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["medicine_id"] . "</td>";
                echo "<td>" . $row["medicine_name"] . "</td>"; // Corrected column name
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["manufacturer"] . "</td>";
                echo "<td>" . $row["unit_price"] . "</td>";
                echo "<td>" . $row["quantity_available"] . "</td>";
                echo "<td>" . $row["expiry_date"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No medicine found</td></tr>";
        }
        ?>
    </table>
</body>
<footer>  
  <p>Author: Nivedita</p>
  <p><a href="mailto:hege@example.com">hege@example.com</a></p>
</footer>
</html>


<?php
$conn->close();
?>
