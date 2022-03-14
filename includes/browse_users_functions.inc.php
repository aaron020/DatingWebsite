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
		echo("error");
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
		if(empty($value) || strlen($value) < 2 || strlen($value) > 20){
			//assume this is a phony value
			unset($hobbiesArray[$key]);
		}
	}

	return array_values($hobbiesArray);

}

//Takes an array of a users preferences and returns an array of userID's that meet the preferences
// functions usersByPrefence($preferences){
	


// }