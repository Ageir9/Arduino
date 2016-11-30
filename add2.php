<?php 

$user ="2411972479";
$pass = "mypassword";
foreach($_GET as $key =>$row)
{
	echo $key." ".$row;
}

if(isset($_GET['data']))
{	$data1 = $_GET['data'];
	$data2 = $_GET['data2'];
    $data3 = $_GET['data3'];
 
    $datetime = date('Y-m-d H:i:s');
    $seconds = time();
    $rounded_seconds = floor($seconds / (15 * 60)) * (15 * 60);

    //echo "Original: " . date('H:i', $seconds) . "\n";
    //echo "Rounded: " . date('Y-m-d H:i:s', $rounded_seconds) . "\n";
    $roundedtime = (date('Y-m-d H:i:s', $rounded_seconds));
 
	try {
    $dbh = new PDO('mysql:host=tsuts.tskoli.is;dbname=2411972479_rob', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql= "INSERT INTO `2411972479_rob`.`value` (CO,TEMP,HUMIDITY,Date) VALUES ('$data1','$data2','$data3','$roundedtime')";
	echo $sql;
	$dbh->exec($sql);
    echo "New record created successfully";
    }
	catch (PDOException $e) {
    print  $sql . "<br>" . $e->getMessage() . "<br/>";
    die();
	}
	$dbh = null;
}
else{echo "No data";}


/*function roundTime(\DateTime $datetime, $precision = 30) {
    $second = (int) $datetime->format("s");
    if ($second > 30) {
        $datetime->add(new \DateInterval("PT".(60-$second)."S"));
    } elseif ($second > 0) {
        $datetime->sub(new \DateInterval("PT".$second."S"));
    }
    $minute = (int) $datetime->format("i");
    $minute = $minute % $precision;
    if ($minute > 0) {
        $diff = $precision - $minute;
        $datetime->add(new \DateInterval("PT".$diff."M"));
    }
    
}
*/


?>
