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


    $user_id = $_POST["user_id"];
    $user_name = $_POST["user_name"];
    $password = $_POST["user_password"];
    $role = $_POST["role"];


    $check_query = "select * from users where user_name = '".$user_name."'";
    $check_result = $conn->query($check_query);
   
    if ($check_result->num_rows > 0) {
        echo "User Already Exist";
    }
    else{
            // Insert values into the order table
            $sql = "INSERT INTO users(user_id, user_name, password, role)
            VALUES ('$user_id', '$user_name', '$password', '$role')";


            if ($conn->query($sql) === TRUE) {
                echo "user added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
   
}
// Display order details
$result = $conn->query("SELECT * FROM users");


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
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" required>


            <label for="user_name">User Name</label>
            <input type="text" id="user_name" name="user_name" required>


            <label for="user_password">Password</label>
            <input type="text" id="user_password" name="user_passwoed" required>


            <label for="role">Role</label>
            <input type="text" id="role" name="role" required>
            <button><a href="dashboard.php">Back</a></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit">Add User</button></br>
        </form>


        <h3 style="text-align:center;">User Details</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Role</th>
               
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
