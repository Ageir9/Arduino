<!DOCTYPE html>
<html>
    <head>
    <title>/iVjLZDDc</title>
        <meta charset="utf-8">
        <meta name="theme-color" content="#ffffff">
        <!--favicon-->
        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <link rel="favicon" type="image/png" href="favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="manifest.json">
        <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
        <!--libraries-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="ct.css">
    </head>
    <body>
        <?php
            $db_server = "tsuts.tskoli.is";
            $db_username = "2411972479";
            $db_password = "mypassword";
            $db_name = "2411972479_rob";
        
            // SQL connect
            $con = mysqli_connect($db_server, $db_username, $db_password, $db_name);
            
            if (!$con) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            
            //Býr til töflu í db ef hún er ekki til
            $createtable = "CREATE TABLE IF NOT EXISTS `value` (
              `CO` int(4) NOT NULL,
              `TEMP` int(4) NOT NULL,
              `HUMIDITY` int(4) NOT NULL,
              `Date` datetime DEFAULT NULL,
              `id` int(10) NOT NULL AUTO_INCREMENT,
              PRIMARY KEY (`id`)
            )";
            $crtable = mysqli_query($con, $createtable);
            if ($crtable === TRUE){
                echo '<script type="text/javascript">console.log("New table created");</script>';
            } else {
                echo '<script type="text/javascript">console.log("Table already exists");</script>';
            }
            
            // Keyrir query. $sqlresult geymir nidurstoduna
            $sqlresult = mysqli_query($con, "SELECT * FROM value");
            // Hvert row verður gert að array ($row) í gegnum mysql_fetch_array
            while($row = mysqli_fetch_array($sqlresult)) {
                foreach($sqlresult as $value){
                 }
            }
        //Birtir nyjustu gildin efst a sidunni
        ?>
        <div id="container-current">
            <h1>Current values</h1>
            <table id="t2" align="center">
                <tr>
                    <th>Last check</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th id="coval">CO</th>
                </tr>
                <tr>
                    <?php
                    echo "<th>" . substr($value['Date'], 0 , -3) . "</th><th>" . $value['TEMP'] . "</th><th>" . $value['HUMIDITY'] . "</th><th>" . $value['CO'] . "</th>";
                    ?>
                </tr>
            </table>
        </div>
        
        
        <h3>Recent values</h3>
        <table id="t101">
        <tr>
            <th>Date</th>
            <th>Humidity (%)</th> 
            <th>Temperature (°C)</th>
            <th>CO level (ppm)</th>
            <th>ID</th>
        </tr>
        <tr>
            <?php

            // Keyrir query. $sqlresult geymir nidurstoduna
            $sqlresult = mysqli_query($con, "SELECT * FROM value");
            // Loopar úr $sqlresult
            // Hvert row verður gert að array ($row) í gegnum mysql_fetch_array
            while($row = mysqli_fetch_array($sqlresult)) {
                // Skrifar út gildi (sem er núna í $row)
                foreach($sqlresult as $value){
                    echo "<tr><td>" . $value['Date']. "<td>" . $value['HUMIDITY'] . "<td>" . $value['TEMP'] . "<td>" . $value['CO'] . "<td>" . $value['id'] . "</td><tr>";
                    echo '<script type="text/javascript">console.log("table loop");</script>';
                 }
            }
            //loka töflunni
            echo "</tr>";
            
            // Keyrir query aftur til ad byrja fra byrjun
            $sqlresult = mysqli_query($con, "SELECT * FROM value");
            //Setur allt i array
            $response = array();
            $posts = array();
            while($row = mysqli_fetch_array($sqlresult))
            {
                $CO=$row['CO'];
                $TEMP=$row['TEMP'];
                $HUMIDITY=$row['HUMIDITY'];
                $DATE=$row['Date'];
                $ID=$row['id'];
                
                $posts[] = array('CO'=> $CO, 'TEMP'=> $TEMP, 'HUMIDITY'=> $HUMIDITY, 'Date'=> $DATE, 'id'=> $ID);
            }
            $response['posts'] = $posts;
            
            //Býr til .json file og skrifar í hann
            $fp = fopen('results.json', 'w');
            fwrite($fp, json_encode($response));
            fclose($fp);
            
            // Close the database connection
            mysqli_close($con);
            ?>
        </tr>
        </table>
    </body>
</html>
