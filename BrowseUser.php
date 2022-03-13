<?php
include("connections.php");
include("includes/browse_users_functions.inc.php");
$userDet = getUserDetails(1, $con);
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

      <img src="picture.png">



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
        <button style="background-color: #b3ffcc;">Yes</button>
        <button style="background-color: #ffad99;">No</button>
                
        

    </div>
  </div>
</body>
</html>
