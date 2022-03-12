<?php 

	include "dbh.inc.php";

	if (isset($_POST["submit"])) {
		
		$name = $_POST["usersId"];
		$pwd = $_POST["pwd"];
		
		require_once 'dbh.inc.php';
		$serverName = "localhost";
		$DBUserName = "root";
		$dBPassword = "";
		$dBName = "loveconnect";
		
		$conn = mysqli_connect($serverName, $DBUserName, $dBPassword, $dBName);

		if(!$conn){
			
			die("Error connecting to database: " . mysqli_connect_error());
			
		}
		
		require_once 'functions.inc.php';
		
		if (noInputLogin($name, $pwd) != false) {
			header("location: ../Login.html?error=emptyinput");
			exit();
		}
		loginUser($conn, $name, $pwd);
	}
	else {
		header("location: ../Login.html?error=dunno");
		exit();
	}