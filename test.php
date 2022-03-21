<?php
// include("includes/editUser.inc.php");
// include("includes/browse_users_functions.inc.php");
include("connections.php");
include("includes/functions.inc.php");



echo userDetailsEntered($con, 12);

// $imgName = $_FILES['img']['name'];
// $imgType = $_FILES['img']['type'];


// $Imgdir = "img/pfp/";
// $fileName = rand(10,10000000) . basename($_FILES['img']['name']);
// $targetFile = $Imgdir . $fileName;
// echo $targetFile;

//move_uploaded_file($_FILES['img']['tmp_name'], $targetFile);


// $pref = getPreferences(2, $con);


// $ids = usersByPrefence($pref, 6,$con);
// print_r($ids);


// echo testValue("132131", "Default");

// addLike(1,2, $con);

// $liked = notInterestedUsers(4,$con);
// print_r($liked);

// $banned = bannedUsers($con);
// print_r($banned);
// $hobbies = groupHobbies("running,swimming,cycling,minercaft");
// print_r($hobbies);