<?php
session_start();
  if(empty($_SESSION['userCount']) || $_SESSION['userCount'] > 7){
    $_SESSION['userCount'] = 0;
  }
  $_SESSION['userCount'] = $_SESSION['userCount'] + 1;
  echo $_SESSION['userCount'];


  include("connections.php");
  include("includes/browse_users_functions.inc.php");
  $userDet = getUserDetails($_SESSION['userCount'] , $con);

  $imgData = getImg($_SESSION['userCount'] , $con);
  $imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
?>



<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="LoginStyle.css">
  <title></title>
</head>
<body>

  <div style="width: 40%;" class="login">

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
          <input type="submit" name="yes" value="Yes">
          <input type="submit" name="no" value="No">
        </form>
    </div>
  </div>
</body>
</html>
