<?php
include("connections.php");
$img = ($_POST['img']);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$age =  $_POST['age'];
$city =  $_POST['city'];
$bio = $_POST['bio'];
$uni =  $_POST['uni'];
$job =  $_POST['job'];
$hobbies =  $_POST['hobbies'];
$interest = $_POST['interest'];
$contact = $_POST['contact'];



$query = "insert into userdetails (userId,firstname,lastname,gender,age,city,bio,university,job,hobbies,interests,contact) 
	values ('4', '$firstname', '$lastname','$gender',$age,'$city','$bio','$uni','$job','$hobbies','$interest','$contact');";



if(!mysqli_query($con,$query)){
	echo("Error description: " . mysqli_error($con));
}


//Just for testing -- 
echo($_POST['img']);
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

