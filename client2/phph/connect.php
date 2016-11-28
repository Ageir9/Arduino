<?php

	function Connection(){
		$servername = "tsuts.tskoli.is";
        $username = "2411972479";
        $password = "mypassword";
        $dbname = "2411972479_rob";
	   	
		$connection = mysqli_connect($servername, $username, $password, $dbname);

		if (!$connection) {
	    	die('MySQL ERROR: ' . mysqli_error());
		}
		
		mysqli_select_db($connection,$dbname) or die( 'MySQL ERROR: '. mysqli_error() );

		return $connection;
	}
?>
