<?php 

	include "dbh.inc.php";	
	
	if (isset($_POST["submit"])) {
		
		$name = $_POST["usersId"];
		$pwd = $_POST["pwd"];
		$pwd_confirm= $_POST["pwd_confirm"];
		
		$serverName = "localhost";
		$DBUserName = "root";
		$dBPassword = "";
		$dBName = "loveconnect";
	
		$conn = mysqli_connect($serverName, $DBUserName, $dBPassword, $dBName);
		
	if(!$conn){
		
		die("Error connecting to database: " . mysqli_connect_error());
		
	}
		require_once 'functions.inc.php';
		
		if (noInputSignup($name, $pwd, $pwd_confirm) !== false) {
			header("location: ../Register.html?error=emptyinput");
			exit();
		}
		if (invalidUid($name) !== false) {
			header("location: ../Register.html?error=noname");
			exit();
		}
		if (pwdCon($pwd, $pwd_confirm) !== false) {
			header("location: ../Register.html?error=pwdnomatch");
			exit();
		}
		//This script can't find $conn
		if (UidExists($conn, $name) !== false) {
			header("location: ../Register.html?error=usernametaken");
			exit();
		}
		
		createUser($conn, $name, $pwd);
	}
	else {
		header("location: ../Register.php");
		exit();
	}
?>