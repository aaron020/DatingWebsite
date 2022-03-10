<?php
include("connections.php");

$gender = ($_POST['gender']);
$hobbies = $_POST['hobbies'];
$uni = $_POST['uni'];
$city = $_POST['city'];
$age_low =  $_POST['age_from'];
$age_high =  $_POST['age_to'];

echo $gender;
echo $hobbies;
echo $uni;
echo $city;
echo $age_low;
echo $age_high;


