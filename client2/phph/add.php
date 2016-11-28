<?php
   	include("connect.php");
   	
   	$link=Connection();


    $COVALUE="12";
	$temp1="12";#$_POST["temp1"];
	$hum1="12";#$_POST["hum1"];
    
    $datetime = date('Y-m-d H:i:s');
	$query = "INSERT INTO value (CO,TEMP,HUMIDITY,Date) 
		VALUES ('$COVALUE', '$temp1' , '$hum1', '$datetime')"; 
    echo $query;
   	
  $link->query($query);
    $link->close();

?>
