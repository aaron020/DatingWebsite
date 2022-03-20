<?php
session_start();
include("includes/uniChecker.inc.php");
include("connections.php");
$Imgdir = "img/pfp/";
$fileName = rand(10,10000000) . basename($_FILES['img']['name']);
$targetFile = $Imgdir . $fileName;
//Need to add some checks for the file size

// if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
// } 
move_uploaded_file($_FILES['img']['tmp_name'], $targetFile);
$UID = $_SESSION['ID'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$age =  $_POST['age'];
$city =  $_POST['city'];
$bio = $_POST['bio'];
$uni =  universityChecker($_POST['uni']);
$job =  $_POST['job'];
$hobbies =  $_POST['hobbies'];
$interest = $_POST['interest'];
$contact = $_POST['contact'];



$query = "INSERT into userdetails (userId,firstname,lastname,gender,age,city,bio,university,job,hobbies,interests,contact) 
	values ('$UID', '$firstname', '$lastname','$gender',$age,'$city','$bio','$uni','$job','$hobbies','$interest','$contact');";

$imgQuery = "INSERT into images (userID, img_dir, img_name) values (1, '$Imgdir', '$fileName')";

if(!mysqli_query($con,$imgQuery)){
	echo("Error description: " . mysqli_error($con));
}

if(!mysqli_query($con,$query)){
	echo("Error description: " . mysqli_error($con));
}


//Just for testing -- 
echo $_POST['firstname'];
echo $_POST['lastname'];
echo $_POST['gender'];
echo $_POST['age'];
echo $_POST['city'];
echo $_POST['bio'];
echo $_POST['uni'];
echo $_POST['job'];
echo $_POST['hobbies'];
echo $_POST['interest'];



