<?php
session_start();
include("includes/browse_users_functions.inc.php");
include("connections.php");


//The user that is logged in  11 to see all users
$userId_LoggedIn = $_SESSION['ID'];


//Next
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if($_POST['action'] == 'Next'){
    $_SESSION['userLiked'] = $_SESSION['userLiked'] + 1;
  }
}


//Get likes
$liked = likedUsers($userId_LoggedIn, $con);
// print_r($ids);
$maxUsers = count($liked); // Amount of users found based off the preferences give

if($maxUsers == 0){
  ob_start();
  header('Location: noUsers.html');
  ob_end_flush();
  die();
}


if(empty($_SESSION['userLiked'])){
    $_SESSION['userLiked'] = 0;
}
if($_SESSION['userLiked'] >= $maxUsers){
    $_SESSION['userLiked'] = 0;
}

// echo $_SESSION['userCount'];


$userDet = getUserDetails($liked[$_SESSION['userLiked']], $con);

$imgData = getImg($liked[$_SESSION['userLiked']], $con);
$imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
?>



<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="style/BrowseStyle.css">
  <title>Browse Users</title>
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

        <form method="post" action="favourites.php">
          <input type="submit" name="action" value="Next">
        </form>
    </div>
  </div>
</body>
</html>
