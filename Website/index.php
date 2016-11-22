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
            // Connect to database server
            $link = mysql_connect($db_server, $db_username, $db_password);
            if (!$link) {
                die('Could not connect: ' . mysql_error());
            }

            // Select database
            mysql_select_db("2411972479_rob") or die(mysql_error());

            // SQL query
            $querySQL = "SELECT * FROM value";

            // Execute the query (the recordset $rs contains the result)
            $rs = mysql_query($querySQL);

            // Loop the recordset $rs
            // Each row will be made into an array ($row) using mysql_fetch_array
            while($row = mysql_fetch_array($rs)) {

               // Write the value of the column FirstName (which is now in the array $row)
              echo $row['FirstName'] . "<br />";
              }

            // Close the database connection
            mysql_close();
            $CO_value = 14;
            $TEMP_value = 13;
            $HUMIDITY_value = 12;
            echo "<tr><td>" . $Date . "</td> 
                  <td>" . $TEMP_value . "</td> 
                  <td>" . $HUMIDITY_value . "</td>
                  <td>" . $CO_value . "</td></tr>";
            ?>
        </tr>
        </table>
    </body>
</html>
