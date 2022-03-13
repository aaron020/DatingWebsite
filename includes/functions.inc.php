<?php

function noInputSignup($name, $pwd, $pwd_confirm) {
	$return;
	if (empty($name) || empty($pwd) || empty($pwd_confirm)) {
		$return = true;
	}
	else {
		$return = false;
	}
	return $return;
}
function invalidUid($name) {
	$return;
	//filter_var($email, FILTER_VALIDATE_EMAIL) <- if we add emails to be 
	if (!preg_match("/^[a-zA-Z0-9]*$/", $name)) {
		$return = true;
	}
	else {
		$return = false;
	}
	return $return;
}
function pwdCon($pwd, $pwd_confirm) {
	$return;
	
	if ($pwd !== $pwd_confirm) {
		$return = true;
	}
	else {
		$return = false;
	}
	return $return;
}
function UidExists($conn, $name) {
	
	$sql = "SELECT * FROM users WHERE usersName = ?;";//Add OR usersEmail = ? if looking for email
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../Login.html?error=stmtfailed");
		exit();
	}
	
	mysqli_stmt_bind_param($stmt, "s", $name);
	mysqli_stmt_execute($stmt);
	
	$resultData = mysqli_stmt_get_result($stmt);
	
	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}
	
	mysqli_stmt_close($stmt);
}

function pwdGet($conn, $name) {
	
	$sql = "SELECT password FROM users WHERE usersName = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../Login.html?error=stmtfailed");
		exit();
	}
	
	mysqli_stmt_bind_param($stmt, "s", $name);
	mysqli_stmt_execute($stmt);
	
	$resultData = mysqli_stmt_get_result($stmt);
	
	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}
	
	mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $pwd) {
	
	$sql = "INSERT INTO users (usersName, password) VALUES (?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../Register.html?error=stmtfailed2");
		exit();
	}
	
	$hashedpwd = password_hash($pwd, PASSWORD_BCRYPT);
	
	mysqli_stmt_bind_param($stmt, "ss", $name, $hashedpwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: Login.html");
	exit();
}
function noInputLogin($name, $pwd) {
	$return;
	if (empty($name) || empty($pwd)) {
		$return = true;
	}
	else {
		$return = false;
	}
	return $return;
}
function loginUser($conn, $name, $pwd){
	
	$uidExists = UidExists($conn, $name);//Add another id parameter for email if login using email
	$passCheck = pwdGet($conn, $name);
	
	if ($uidExists == false) {
		header("location: ../Login.html?error=wronglogin");
		exit();
	}
	$pwdHashed = $passCheck;
	$checkPwd = password_verify($pwd,$pwdHashed["password"]);
	
	if ($checkPwd == false) {
		header("location: ../Login.html?error-wrongpassword= ");
		exit();
	}

	else if ($checkPwd == true) {
		session_start();
		$_SESSION["userName"] = $uidExists["userName"];
		header("location: Userdetails.html");
		exit();
	}
}