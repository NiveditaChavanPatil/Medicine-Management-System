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
    $order_id = $_POST["order_id"];
    $user_id = $_POST["user_id"];
    $order_date = $_POST["order_date"];
    $otal_cost = $_POST["total_cost"];
    $q_ordered = $_POST["q_ordered"];


    // Insert values into the order table
    $sql = "INSERT INTO orders (order_id, user_id, order_date, total_cost, q_ordered)
            VALUES ('$order_id', '$user_id', '$order_date', '$total_cost','$q_ordered')";
           
    if ($conn->query($sql) === TRUE) {
        echo "Order added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Display order details
$result = $conn->query("SELECT * FROM orders");


?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Order</title>
</head>


<body>
    <div class="order-container">
        <h2>Order Management</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="order_id">Order ID</label>
            <input type="text" id="order_id" name="order_id" required>


            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" required>


            <label for="order_date">Order Date</label>
            <input type="date" id="order_date" name="order_date" required>


            <label for="total_cost">Total Cost</label>
            <input type="text" id="total_cost" name="total_cost" required>


            <label for="q_ordered">Quantity Ordered</label>
            <input type="text" id="q_ordered" name="q_ordered" required>


            <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add Medicine</button></br>
        </form>


        <h3 style="text-align:center;">Order Details</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Order Date</th>
                <th>Total Cost</th>
                <th>Quantity Ordered</th>
            </tr>


            <?php
            // Display data from the order table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td>" . $row["total_cost"] . "</td>";
                    echo "<td>" . $row["q_ordered"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>


</html>


<?php
$conn->close();
?>
