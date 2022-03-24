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