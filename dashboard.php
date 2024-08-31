<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_management";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>


    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: url("medicine.jpg") center/cover no-repeat fixed;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            color: #fff;
        }


        .dashboard-container {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: rgba(173, 216, 230, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
            text-align: center;
            position: relative;
        }


        h2 {
            color: #2c3e50;
        }


        .menu {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            background: linear-gradient(rgba(93, 173, 226, 1), rgba(52, 152, 219, 1));
            border-radius: 5px;
            padding: 15px 0;
            margin-bottom: 20px;
            box-shadow: none;
        }


        .menu a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 18px;
            font-weight: bold;
            margin: 0 10px;
        }


        .menu a:hover {
            background-color: rgba(41, 128, 185, 0.7);
        }


        .med-image {
            width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            opacity: 0.6;
        }


        .widget-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }


        .widget {
            width: 60%;
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            opacity: 0.8;
            transition: transform 0.3s ease;
        }


        .widget:hover {
            transform: scale(1.02);
        }


        .search-widget, .stock-widget {
            width: 60%;
            background-color: #fff;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            opacity: 0.8;
        }


        .search-bar {
            width: 100%;
            padding: 10px;
            border: none;
            font-size: 16px;
            outline: none;
            border-radius: 5px;
        }


        .stock-widget h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }


        .stock-content {
            color: #555;
        }
    </style>
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome to the Dashboard</h1>
        <div class="menu">
            <a href="medicines.php">Medicines</a>
            <a href="supplier.php">Suppliers</a>
            <a href="users.php">Users</a>
            <a href="order.php">Orders</a>
            <a href="stock.php">Stock Available</a>
            <a href="expiry.php">Expiry Alerts</a>
        </div>


        <div class="widget-container">


            <div class="stock-widget widget">
                <div id="myPlot" style="width:100%;max-width:700px"></div>


                <script>
                    <?php
                        $sql = "SELECT * FROM medicine";
                        //echo $sql; exit;
                        $result = $conn->query($sql);


                        $med_name_array = array();
                        $med_quantity_array = array();


                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                    $medicine_name = strtoupper($row['medicine_name']);
                                    $medicine_quantity = $row['quantity_available'];
                                    array_push($med_name_array,$medicine_name);  
                                    array_push($med_quantity_array,$medicine_quantity);
                            }
                        }
                         
                           $xArrayJSON = json_encode($med_name_array);
                           $yArrayJSON = json_encode($med_quantity_array);
                           $yArrayJSON = str_replace('"',"",$yArrayJSON);




                        ?>
                    const xArray = <?php echo $xArrayJSON; ?>;
                    const yArray = <?php echo $yArrayJSON; ?>;




                const data = [{
                x:xArray,
                y:yArray,
                type:"bar",
                orientation:"v",
                marker: {color:"rgba(0, 0, 0, 1)"}
                }];


                const layout = {title:"Stock Available"};


                Plotly.newPlot("myPlot", data, layout);
                </script>      
            </div>
        </div>
    </div>
</body>
</html>
