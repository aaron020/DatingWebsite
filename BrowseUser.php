<?php
session_start();
include("includes/browse_users_functions.inc.php");
include("connections.php");


//The user that is logged in  11 to see all users
$userId_LoggedIn = $_SESSION['ID'];
$userDet;
$imgData;
$imgSource;

//The Yes or No Button are clicked
if($_SERVER['REQUEST_METHOD'] === 'POST'){

  if($_POST['action'] == 'Yes'){
    addLike($userId_LoggedIn, $_SESSION['userIds'][$_SESSION['userCount']], $con);
  }
  if($_POST['action'] == 'No'){
    addNotInterested($userId_LoggedIn, $_SESSION['userIds'][$_SESSION['userCount']], $con);
  }
  $_SESSION['userCount'] = $_SESSION['userCount'] + 1;

  if($_SESSION['userCount'] >= $_SESSION['maxUsers']){
    header('Location: noUsers.html');
    exit();
  }


  $userDet = getUserDetails($_SESSION['userIds'][$_SESSION['userCount']], $con);
  $imgData = getImg($_SESSION['userIds'][$_SESSION['userCount']], $con);
  $imgSource = $imgData["img_dir"] . $imgData["img_name"]; 


}else{
  //The page is loaded for the first time

  //An array of the user preferences
  $pref = getPreferences($userId_LoggedIn, $con);
  //All the Id's of users that the user logged in should be interested in
  $ids = usersByPrefence($pref, $userId_LoggedIn,$con);

  if(isset($_SESSION['userIds'])){
    //Session var ia already set - remove all vals + give it new ones
    unset($_SESSION['userIds']);
    $_SESSION['userIds'] = $ids;
  }else{
    //Session var is not set - so we set it
    $_SESSION['userIds'] = $ids;
  }

  $_SESSION['maxUsers'] = count($_SESSION['userIds']);

  if(empty($_SESSION['userCount'])){
    $_SESSION['userCount'] = 0;
  }
  $userDet = getUserDetails($_SESSION['userIds'][$_SESSION['userCount']], $con);
  $imgData = getImg($_SESSION['userIds'][$_SESSION['userCount']], $con);
  $imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
}

print_r($_SESSION['userIds']);
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


 
        <h3 style="text-align: center;">Interested?</h3>
        <form method="post" action="BrowseUser.php">
          <input type="submit" name="action" value="Yes">
          <input type="submit" name="action" value="No">
        </form>
    </div>
  </div>
</body>
</html>
