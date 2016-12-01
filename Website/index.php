<!DOCTYPE html>
<html>
    <head>
    <title>/iVjLZDDc</title>
        <meta charset="utf-8">
        <meta name="theme-color" content="#ffffff">
        <!-- refresh a 5 min fresti -->
        <META HTTP-EQUIV="Refresh" CONTENT="360">
        <!--favicon-->
        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <link rel="favicon" type="image/png" href="favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="manifest.json">
        <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
        <!--libraries-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css" />
        <link rel="stylesheet" type="text/css" href="ct.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
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
                        //Birtir nyjustu gildin efst a sidunni
                        //substring til að taka burt sekúndur, prentar út
                        echo '<td>' . substr($value['Date'], 0 , -3) . '</td>';
                        //Setur warning ef eitthvað er of hátt.
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
        <?php
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
            //býr til array
            $posts[] = array('CO'=> $CO, 'TEMP'=> $TEMP, 'HUMIDITY'=> $HUMIDITY, 'Date'=> $DATE, 'id'=> $ID);
        }
        $response['values'] = $posts;
        //Býr til .json file og skrifar í hann
        $fp = fopen('results.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);

        // Close the database connection
        mysqli_close($con);
        ?>
    </body>
</html>
