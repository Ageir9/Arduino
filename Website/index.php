<!DOCTYPE html>
<html>
    <head>
    <title>Arduino</title>
        <meta charset="utf-8">
        <meta name="theme-color" content="#ffffff">
        <!-- refresh a 5 min fresti -->
        <META HTTP-EQUIV="Refresh" CONTENT="300">
        <!--favicon-->
        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <link rel="favicon" type="image/png" href="favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="manifest.json">
        <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css" />
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

            // Byr til toflu i db ef hun er ekki til
            $createtable = "CREATE TABLE IF NOT EXISTS `value` (
              `CO` int(4) NOT NULL,
              `TEMP` int(4) NOT NULL,
              `HUMIDITY` int(4) NOT NULL,
              `Date` datetime DEFAULT NULL,
              `id` int(10) NOT NULL AUTO_INCREMENT,
              PRIMARY KEY (`id`)
            )";
            $crtable = mysqli_query($con, $createtable);
            // debugging
            if ($crtable === TRUE){
                echo '<script type="text/javascript">console.log("New table created");</script>';
            } else {
                echo '<script type="text/javascript">console.log("Table already exists");</script>';
            }

            // Keyrir query. $sqlresult geymir nidurstoduna
            $sqlresult = mysqli_query($con, "SELECT * FROM value");
            // Hvert row verður gert að array ($row) i gegnum mysql_fetch_array
            while($row = mysqli_fetch_array($sqlresult)) {
                foreach($sqlresult as $value){
                 }
            }
        ?>
        <div id="container-current">
            <h1>Current values</h1>
            <table class="ui orange fixed celled table">
                <thead>
                    <tr>
                        <th>Last check</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                        <th>CO</th>
                    </tr>
                    <tr>
                        <?php
                        // Birtir nyjustu gildin efst a sidunni
                        // substring tekur burt sekundur
                        echo '<td>' . substr($value['Date'], 0 , -3) . '</td>';
                        // Setur warning merki ef eitthvað er of hátt.
                        $warning = '<td class="error"><i class="attention icon"></i>';
                        if($value['TEMP'] >= 40){
                            echo $warning . $value['TEMP'] . '°C </td>';
                        } else{
                            echo '<td>' . $value['TEMP'] . '°C </td>';
                        }
                        if($value['HUMIDITY'] >= 80){
                            echo $warning . $value['HUMIDITY'] . '% </td>';
                        } else{
                            echo '<td>' . $value['HUMIDITY'] . '% </td>';
                        }
                        if($value['CO'] >= 150){
                            echo $warning . $value['CO'] . ' ppm </td>';
                        } else{
                            echo '<td>' . $value['CO'] . ' ppm </td>';
                        }
                        ?>
                    </tr>
                </thead>
            </table>
        </div>
        
        <h3>10 Recent values</h3>
        <table id="t101">
        <tr>
            <th>Date</th>
            <th>Humidity (%)</th> 
            <th>Temperature (°C)</th>
            <th>CO level (ppm)</th>
        </tr>
        <tr>
        
        <?php
        // Keyrir query. $sqlresult geymir nidurstoduna
        $sqlresult = mysqli_query($con, "SELECT * FROM value LIMIT 10");
        // Loopar ur $sqlresult
        // Hvert row verður gert að array ($row) i gegnum mysql_fetch_array
        while($row = mysqli_fetch_array($sqlresult)) {
            // Skrifar ut gildi (sem er núna i $row)
            foreach($sqlresult as $value){
                echo "<tr><td>" . substr($value['Date'], 0 , -3) . "<td>" . $value['HUMIDITY'] . "<td>" . $value['TEMP'] . "<td>" . $value['CO'] . "<td>" . "</td><tr>";
             }
        }
        //loka töflunni
        echo "</tr></table>";

        // Keyrir query. $sqlresult geymir nidurstoduna
        $sqlresult = mysqli_query($con, "SELECT * FROM value");
        $response = array();
        $posts = array();
        while($row = mysqli_fetch_array($sqlresult))
        {
            $CO=$row['CO'];
            $TEMP=$row['TEMP'];
            $HUMIDITY=$row['HUMIDITY'];
            $DATE=$row['Date'];
            $ID=$row['id'];
            //Byr til array
            $posts[] = array('CO'=> $CO, 'TEMP'=> $TEMP, 'HUMIDITY'=> $HUMIDITY, 'Date'=> $DATE, 'id'=> $ID);
        }
        $response['values'] = $posts;
        // Byr til .json file og skrifar i hann
        $fp = fopen('js/results.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);

        // Lokar database connection
        mysqli_close($con);
        ?>
        <div class="bil">
            <div class= "linurit">
                <canvas id="myChart" width="300" height="300"></canvas>
            </div>
        </div>

        <div class="bil">
            <div class= "linurit">
                <canvas id="myChart1" width="300" height="300"></canvas>
            </div>
        </div>

        <div class="bil">
            <div class= "linurit">
                <canvas id="myChart2" width="300" height="300"></canvas>
            </div>
        </div>
        <!--libraries-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
        <script type="application/javascript" src="js/results.json"></script>
        <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script></script>
        <script src="js/graph.js"></script>
    </body>
</html>
