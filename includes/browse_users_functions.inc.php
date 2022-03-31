<?php

//Returns an array preferences based off of the userId entered 
function getPreferences($userId, $con){
	$query = "SELECT * FROM userpreferences WHERE userId = $userId";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {
 			return mysqli_fetch_assoc($result);
	} else {



		//If the user has not manually set their preferences then we check the 
		// userdetails table for the interests that have to be set 
		$queryUserDetails = "SELECT interests FROM userdetails WHERE userId = $userId";
		$resultUserDetails = mysqli_query($con, $queryUserDetails);
		if (mysqli_num_rows($resultUserDetails) > 0) {
			$userIdInterests = mysqli_fetch_assoc($resultUserDetails);


			//Give all the other preferences no val
			$interests = array_fill_keys(array('userId' , 'gender', 
				'hobbies', 'university', 'city','age_high','age_low'), '');
			$interests['gender'] = $userIdInterests["interests"];
			return $interests;



		}else{
			echo "error";
			//ERROR
		}
	}
}

function getImg($userId, $con){
	$query = "SELECT * FROM images WHERE userId = $userId";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result) > 0){
		return mysqli_fetch_assoc($result);
	}else{
		return null;
	}
}

//Returns an array of all the user details
function getUserDetails($userId, $con){
	$query = "SELECT * FROM userdetails WHERE userId = $userId";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {
 			return mysqli_fetch_assoc($result);
 	}else{
 		echo("error");
 	}
}

//Function that styles any string being displayed eg jOHN --> John 
function textStyle($text){
	//Change all text to lower case
	$resStr = strtolower($text);
	return ucfirst($resStr);
}



//Take a string of hobbies and converts it to an array eg "Swimming,Running,Jogging" --> 1=>Swimming , 2=>Running, 3=>Walking
function groupHobbies($hobbies){
	$hobbiesArray = explode(",", $hobbies);

	//Look phony hobby values 

	foreach ($hobbiesArray as $key => $value) {
		if(empty($value) || strlen($value) < 2 || strlen($value) > 20 || $key > 2){
			//assume this is a phony value
			unset($hobbiesArray[$key]);
		}
	}

	return array_values($hobbiesArray);

}

//Takes an array of a users preferences and returns an array of userID's that meet the preferences + makes sure the users arent :
//The same as the user logged in , banned, already liked by the user, already not interested by the user
function usersByPrefence($preferences, $userId_LoggedIn, $con){
	//Any empty values are converted to default 
	foreach($preferences as $key=>&$value){
		if($value == 'Both'){
			$value = '%';
		}
		if(empty($value)){
			if($key == 'age_low'){
				$value = 18;
			}elseif ($key == 'age_high') {
				$value = 99;
			}else{
				$value = "%";				
			}

		}
	}

	//Get the hobbies entered + if there is less than 3 fill the others with %
	$hobbies = groupHobbies($preferences['hobbies']);
	for($i = count($hobbies); $i < 3; $i++){
		array_push($hobbies,"%");
	}
		
	//Executing the sql query 
	$query = "SELECT userId FROM userdetails WHERE gender LIKE '{$preferences['gender']}' &&
	(hobbies LIKE '{$hobbies[0]}' OR hobbies LIKE '{$hobbies[1]}' OR hobbies LIKE '{$hobbies[2]}' ) &&
	university LIKE '{$preferences['university']}' &&
	city LIKE '{$preferences['city']}' &&
	(age <= {$preferences['age_high']} && age >= {$preferences['age_low']});";

	$userIdArray = []; 
	if ($stmt = $con->prepare($query)) {

	    /* execute statement */
	    $stmt->execute();

	    /* bind result variables */
	    $stmt->bind_result($userId);

	    /* fetch values */
	    while ($stmt->fetch()) {
	    	array_push($userIdArray, $userId);
	        //printf ("%s\n", $userId);
	    }

	    /* close statement */
	    $stmt->close();
	}
	//Remove the user that is logged in from the list
	removeId($userId_LoggedIn, $userIdArray);

	//Remove all banned users, liked users, not interested users
	$bannedUsers = bannedUsers($con);
	$likedUsers = likedUsers($userId_LoggedIn, $con);
	$notInterestedUsers = notInterestedUsers($userId_LoggedIn, $con);

	//Not scalable but okay for now 
	if($bannedUsers){
		removeIdArray($bannedUsers, $userIdArray);
	}
	if($likedUsers){
		removeIdArray($likedUsers, $userIdArray);
	}

	if($notInterestedUsers){
		removeIdArray($notInterestedUsers, $userIdArray);
	}

	return array_values($userIdArray);

}

//Takes a userId and an array of userId's and removes the userId from it if its there 
function removeId($Id, &$ids){
	foreach($ids as $key => $value){
		if($value == $Id){
			unset($ids[$key]);
		}
	}
}

function removeIdArray($Id_Removed, &$ids){
	foreach($Id_Removed as $value){
		removeId($value, $ids);
	}
}


function bannedUsers($con){
	$query = "SELECT userId FROM banned;";
	$bannedUser = [];
	if($stmt = $con->prepare($query)){
		$stmt->execute();
		$stmt->bind_result($userId);
		while($stmt->fetch()){
			array_push($bannedUser, $userId);
		}
		$stmt->close();
	}
	return $bannedUser;
}


//All liked users from the user logged in
function likedUsers($userId_LoggedIn ,$con){
	$query = "SELECT userId_Received FROM likes WHERE userId_Sent = $userId_LoggedIn;";
	$liked = [];
	if($stmt = $con->prepare($query)){
		$stmt->execute();
		$stmt->bind_result($userId_Received);
		while($stmt->fetch()){
			array_push($liked, $userId_Received);
		}
		$stmt->close();
	}
	return $liked;
 }

//All users the user logged in is not interested in
function notInterestedUsers($userId_LoggedIn ,$con){
	$query = "SELECT userId_Received FROM not_interested WHERE userId_Sent = $userId_LoggedIn;";
	$notInterested = [];
	if($stmt = $con->prepare($query)){
		$stmt->execute();
		$stmt->bind_result($userId_Received);
		while($stmt->fetch()){
			array_push($notInterested, $userId_Received);
		}
		$stmt->close();
	}
	return $notInterested;
 } 

//Send a like from the user logged in to the user that they like
function addLike($userId_LoggedIn, $userId_Received, $con){
	$query = "INSERT into likes (userId_Sent, userId_Received) values ($userId_LoggedIn, $userId_Received)";
	if(!mysqli_query($con,$query)){
		echo("Error description: " . mysqli_error($con));
	}
}


function addNotInterested($userId_LoggedIn, $userId_Received, $con){
	$query = "INSERT into not_interested (userId_Sent, userId_Received) values ($userId_LoggedIn, $userId_Received)";
	if(!mysqli_query($con,$query)){
		echo("Error description: " . mysqli_error($con));
	}
}

