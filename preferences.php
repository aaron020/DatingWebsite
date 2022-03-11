<?php
include("connections.php");

$gender = ($_POST['gender']);
$hobbies = $_POST['hobbies'];
$uni = $_POST['uni'];
$city = $_POST['city'];
$age_low =  $_POST['age_from'];
$age_high =  $_POST['age_to'];

$query = "insert into userpreferences (userId,gender,hobbies,university,city,age_high,age_low) 
	values ('4', '$gender', '$hobbies','$uni','$city',$age_high,$age_low);";
if(!mysqli_query($con,$query)){
	//header("Location : error.html");
	echo("Error description: " . mysqli_error($con));
}
//Testing purposes 
echo $gender;
echo $hobbies;
echo $uni;
echo $city;
echo $age_low;
echo $age_high;


