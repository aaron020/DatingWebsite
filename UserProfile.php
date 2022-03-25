<?php
session_start();
include("includes/browse_users_functions.inc.php");
include("connections.php");


//The user that is logged in  11 to see all users
$userId_LoggedIn = $_SESSION['ID'];
// $userId_LoggedIn = 1;


$userDet = getUserDetails($userId_LoggedIn, $con);

$imgData = getImg($userId_LoggedIn, $con);
$imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
?>



<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="style/BrowseStyle.css">
  <title>User Profile</title>
</head>
<body>

  <div style="width: 40%;" class="users">

    <div class="heading">
      <a href="Menu.php"> <button style="width: 20%;">Main Menu</button> </a>

      <img src="<?php echo $imgSource?>">



      <div class="NameLocation">
        <h2>
          <?php
            echo textStyle($userDet["firstname"]) . " , " . $userDet["age"];
          ?> 
        </h2>
        <p style="text-align: left;">from <?php echo textStyle($userDet["city"])?></p>
      </div>

      <div class="JobUni">
        <p style="padding: 10px;"><?php echo textStyle($userDet["job"])?></p>
        <p style="padding: 10px;"><?php echo textStyle($userDet["university"])?></p>
      </div>

      <div class="hobbies">
        <p style="padding: 20px;">
          <?php 
          $arrayHobbies = groupHobbies($userDet["hobbies"]);
          foreach ($arrayHobbies as $value) {
             echo textStyle($value) . "    ";
           } 

         ?>
         </p>
      </div>


      <div class="JobUni">
        <p style="padding: 20px;"><?php echo $userDet["bio"]?></p>
      </div>


        <form action="EditUser.php">
          <input type="submit" name="action" value="Edit Profile">
        </form>
    </div>
  </div>
</body>
</html>
