<?php
error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_management";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $stock_id = $_POST["stock_id"];
    $medicine_id = $_POST["medicine_id"];
    $quantity_available = $_POST["quantity_available"];
    $last_updated = $_POST["last_updated"];
    // Insert values into the order table
    $sql = "INSERT INTO stock_availability (medicine_id, quantity_available, last_updated)
            VALUES ('$medicine_id', '$quantity_available', '$last_updated')";


    if ($conn->query($sql) === TRUE) {
        echo "Stock added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Display order details
$result = $conn->query("SELECT * FROM stock_availability");


?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Stock</title>
</head>


<body>
    <div class="stock-container">
        <h2>Stock Management</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="stock_id">Stock ID</label>
            <input type="text" id="stock_id" name="stock_id" required>


            <label for="medicine_id">Medicine ID</label>
            <input type="text" id="medicine_id" name="medicine_id" required>


            <label for="quantity_available">Quantity Available</label>
            <input type="text" id="quantity_available" name="quantity_available" required>


            <label for="last_updated">Last Updated</label>
            <input type="date" id="last_updated" name="last_updated" required>
            <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add Stock</button></br>
        </form>


        <h3 style="text-align:center;">Stock Details</h3>
        <table>
            <tr>
                <th>Stock ID</th>
                <th>Medicine ID</th>
                <th>Quantity Available</th>
                <th>Last Updated</th>
            </tr>


            <?php
            // Display data from the order table
            if ($result !== false) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["stock_id"] . "</td>";
                        echo "<td>" . $row["medicine_id"] . "</td>";
                        echo "<td>" . $row["quantity_available"] . "</td>";
                        echo "<td>" . $row["last_updated"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No stock found</td></tr>";
                }
            } else {
                // Handle database query error
                echo "Error executing query: " . $conn->error;
            }
           
            ?>
        </table>
    </div>
</body>


</html>


<?php
$conn->close();
?>
