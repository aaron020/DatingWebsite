<?php

include("includes/browse_users_functions.inc.php");
include("connections.php");

// $imgName = $_FILES['img']['name'];
// $imgType = $_FILES['img']['type'];


// $Imgdir = "img/pfp/";
// $fileName = rand(10,10000000) . basename($_FILES['img']['name']);
// $targetFile = $Imgdir . $fileName;
// echo $targetFile;

//move_uploaded_file($_FILES['img']['tmp_name'], $targetFile);


$pref = getPreferences(6, $con);


$ids = usersByPrefence($pref, $con);
print_r($ids);

// $hobbies = groupHobbies("running,swimming,cycling,minercaft");
// print_r($hobbies);