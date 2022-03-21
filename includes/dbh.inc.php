<? php

	$serverName = "localhost";
	$DBUserName = "root";
	$dBPassword = "";
	$dBName = "loveconnect";

		// $serverName = "sql108.epizy.com";
		// $DBUserName = "epiz_31203799";
		// $dBPassword = "siSrE7hjLok";
		// $dBName = "epiz_31203799_loveconnect";
	
	global $conn = mysqli_connect($serverName, $DBUserName, $dBPassword, $dBName);

	
	if(!$conn){
		
		die("Error connecting to database: " . mysqli_connect_error());
		
	}
?>