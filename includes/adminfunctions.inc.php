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
		return "Not Banned";
	}
}


function getAllUserData($con){
	$query  = "SELECT * FROM userdetails";
	$result = mysqli_query($con, $query);
	$allUsers = [];
	if(mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($allUsers, $row['userId'],$row['firstname'],$row['lastname'],
				$row['gender'], $row['age'], $row['city'], $row['bio'], $row['university'],$row['job'], $row['hobbies'], $row['interests'], $row['contact']);
		}
		return $allUsers;
	}else{
		return null;
	}
}

function getAllUserIds($con){
	$query = "SELECT userId FROM userdetails;";
	$userIds = [];
	if($stmt = $con->prepare($query)){
		$stmt->execute();
		$stmt->bind_result($userId);
		while($stmt->fetch()){
			array_push($userIds, $userId);
		}
		$stmt->close();
	}
	return $userIds;
}