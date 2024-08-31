<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_management";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $supplier_id = isset($_POST["supplier_id"]) ? $_POST["supplier_id"] : "";
    $supplier_name = isset($_POST["supplier_name"]) ? $_POST["supplier_name"] : "";
    $phone_no = isset($_POST["phone_no"]) ? $_POST["phone_no"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";


    // Insert values into the database
    $sql = "INSERT INTO supplier (supplier_id, supplier_name, phone_no, email, address)
            VALUES ('$supplier_id', '$supplier_name', '$phone_no', '$email', '$address')";


    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Fetch and display data from the supplier table
$sql_select = "SELECT * FROM supplier";
$result = $conn->query($sql_select);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Supplier</title>
</head>
<body>
    <h2>Supplier Management</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="supplier_id">Supplier ID:</label>
        <input type="text" name="supplier_id" required>


        <label for="supplier_name">Supplier Name:</label>
        <input type="text" name="supplier_name" required>


        <label for="phone_no">Contact Number:</label>
        <input type="text" name="phone_no" required>


        <label for="email">Email:</label>
        <input type="text" name="email" required>


        <label for="address">Address:</label>
        <input type="text" name="address" required>


        <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add Medicine</button></br>
    </form>


    <h3>Supplier Table</h3>
    <table>
        <tr>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Address</th>
        </tr>


        <?php
        // Display data from the supplier table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["supplier_id"] . "</td>";
                echo "<td>" . $row["supplier_name"] . "</td>";
                echo "<td>" . $row["phone_no"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No supplier found</td></tr>";
        }
        ?>
    </table>
</body>
</html>


<?php
$conn->close();
?>
