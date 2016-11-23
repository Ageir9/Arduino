<!DOCTYPE html>
<html>
    <head>
    <title>/iVjLZDDc</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="dist/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="ct.css">
    </head>
    <body>
        <h1>Values</h1>
        <table id="t101">
        <tr>
            <th>Date</th>
            <th>Temperature (°C)</th>
            <th>Humidity (%)</th> 
            <th>CO level (ppm)</th>
        </tr>
        <tr>
            <?php
            $db_server = "tsuts.tskoli.is";
            $db_username = "2411972479";
            $db_password = "mypassword";
            $db_name = "2411972479_rob";

            // Connect to database server
            $link = mysqli_connect($db_server, $db_username, $db_password, $db_name);
            if (!$link) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            // SQL connect
            $con = mysqli_connect($db_server, $db_username, $db_password, $db_name);

            // Execute the query (the recordset $rs contains the result)
            $result = mysqli_query($con, "SELECT * FROM value");

            //Búa til töflu
            echo "<tr>";

            // Loop the recordset $result
            // Each row will be made into an array ($row) using mysql_fetch_array
            while($row = mysqli_fetch_array($result)) {

               // Write the value of the column 'id' (which is now in the array $row)
              echo "<td>" . $row['id'] . "</td>";
            }
            //loka töflunni
            echo "</tr>";

            // Close the database connection
            mysqli_close($con);
            ?>
        </tr>
        </table>
        <canvas id="myChart" width="400" height="400"></canvas>
        <script type="text/javascript" src="main.js"></script>
    </body>
</html>
