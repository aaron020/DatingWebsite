<?php

//Returns username
function getUsername($userId, $con){
	$query = "SELECT username FROM users WHERE userId = $userId";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {
 			return mysqli_fetch_assoc($result);
 	}else{
 		echo("error");
 	}
}


function bannedText($userId, $con){
	$query = "SELECT * FROM banned WHERE userId = $userId";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {
		$banned = mysqli_fetch_assoc($result);
		if($banned['time'] == 0){
			return "Permanently Banned";
		}else{
			return "Temporarily Banned";
		}
	}else{
		return "UnBanned";
	}
}