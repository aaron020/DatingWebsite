<?php
session_start();
include("includes/browse_users_functions.inc.php");
include("connections.php");


//The user that is logged in
$userId_LoggedIn = 2;





$pref = getPreferences($userId_LoggedIn, $con);
$ids = usersByPrefence($pref, $userId_LoggedIn,$con);
$maxUsers = count($ids); // Amount of users found based off the preferences give

echo $_SESSION['userCount'];
print($maxUsers);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if($_POST['action'] == 'Yes'){
    addLike($userId_LoggedIn, $ids[$_SESSION['userCount']], $con);
  }
  if($_POST['action'] == 'No'){
    addNotInterested($userId_LoggedIn, $ids[$_SESSION['userCount']], $con);
  }
  $_SESSION['userCount'] = $_SESSION['userCount'] + 1;
}

if(empty($_SESSION['userCount'])){
    $_SESSION['userCount'] = 0;
}
if($_SESSION['userCount'] >= $maxUsers){
    header('Location: noUsers.html');
    exit();
}




$userDet = getUserDetails($ids[$_SESSION['userCount']], $con);

$imgData = getImg($ids[$_SESSION['userCount']], $con);
$imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
?>



<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="style/BrowseStyle.css">
  <title></title>
</head>
<body>

  <div style="width: 40%;" class="users">

    <div class="heading">
      <a href="Menu.html"> <button style="width: 20%;">Main Menu</button> </a>

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
