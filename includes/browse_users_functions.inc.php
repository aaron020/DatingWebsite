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
		if(empty($value) || strlen($value) < 2 || strlen($value) > 20 || $key > 2){
			//assume this is a phony value
			unset($hobbiesArray[$key]);
		}
	}

	return array_values($hobbiesArray);

}

//Takes an array of a users preferences and returns an array of userID's that meet the preferences
function usersByPrefence($preferences, $con){
	//Any empty values are converted to default 
	foreach($preferences as $key=>&$value){
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
	return $userIdArray;

}