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


    $medicine_id = $_POST["medicine_id"];
    $expiry_date = $_POST["expiry_date"];
    $alter_date = $_POST["alter_date"];
    $alert_id = $_POST["alert_id"];


    $check_query = "select * from users where user_name = '".$user_name."'";
    $check_result = $conn->query($check_query);
   
    if ($check_result->num_rows > 0) {
        echo "Expiry Alerts";
    }
    else{
            // Insert values into the order table
            $sql = "INSERT INTO expiry_alter(medicine_id, expiry_date, alter_date, alert_id)
            VALUES ('$medicine_id', '$expiry_date', '$alter_date', '$alert_idole')";


            if ($conn->query($sql) === TRUE) {
                echo "expiey imformation added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
   
}
// Display order details
$result = $conn->query("SELECT * FROM expiry_alters");


?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>User</title>
</head>


<body>
    <div class="user-container">
        <h2>User Management</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="medicine_id">Medicine ID</label>
            <input type="text" id="medicine_id" name="medicine_id" required>


            <label for="expiry_date">Expiry Date</label>
            <input type="date" id="expiry_date" name="expiry_date" required>


            <label for="alter_date">Alter Date</label>
            <input type="date" id="alter_date" name="alter_date" required>


            <label for="alert_id">Alert ID</label>
            <input type="text" id="alert_id" name="alert_id" required>
            <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add User</button></br>
        </form>


        <h3 style="text-align:center;">User Details</h3>
        <table>
            <tr>
                <th>Medcine ID</th>
                <th>Expiry Date</th>
                <th>Alter Date</th>
                <th>Alter ID</th>
               
            </tr>


            <?php
            // Display data from the order table
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row["user_name"] . "</td>";
                    echo "<td>" . $row["role"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No user found</td></tr>";
            }
       
            ?>
        </table>
    </div>
</body>


</html>


<?php
$conn->close();
?>
