<? php

	$serverName = "localhost";
	$DBUserName = "root";
	$dBPassword = "";
	$dBName = "loveconnect";
	
	global $conn = mysqli_connect($serverName, $DBUserName, $dBPassword, $dBName);

	
	if(!$conn){
		
		die("Error connecting to database: " . mysqli_connect_error());
		
	}
?>