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
  if($imgData == null){
  $imgSource = "img/default/" . "default.png"; 
  }else{
    $imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
  }



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
  
  if($_SESSION['userCount'] >= $_SESSION['maxUsers']){
    header('Location: noUsers.html');
    exit();
  }

  if(empty($_SESSION['userCount'])){
    $_SESSION['userCount'] = 0;
  }
  $userDet = getUserDetails($_SESSION['userIds'][$_SESSION['userCount']], $con);
  $imgData = getImg($_SESSION['userIds'][$_SESSION['userCount']], $con);

  if($imgData == null){
    $imgSource = "img/default/" . "default.png"; 
  }else{
    $imgSource = $imgData["img_dir"] . $imgData["img_name"]; 
  }
}


?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/user_style.css">

  <title>Browse Users</title>
  </head>
  <body>
    <section class="User py-5">
      <div class="container">
        <div class="row">


          <div class="col-lg-5 pt-5 text-center">
            <img src="<?php echo $imgSource?>" class="img-fluid" alt="User Profile Picture" onerror=this.src="img/default/default.png">
            <h1><?php
            echo textStyle($userDet["firstname"]);?></h1>
            <h2><?php echo textStyle($userDet["city"]) . " , " . $userDet["age"];?></h2>
            <p><?php echo textStyle($userDet["job"])?></p>
          </div>


          <div class="col-lg-7 text-center py-3">

              <div class="py-3 pt-5">
                <div class="offset-1 col-lg-10">
                    <p style="word-wrap:break-word"><?php echo $userDet["bio"]?></p>
                </div>
              </div>



              <div class="py-3 pt-5">
                <div class="offset-1 col-lg-10">
                  <h4>
                    <?php 
                    $arrayHobbies = groupHobbies($userDet["hobbies"]);
                    foreach ($arrayHobbies as $value) {
                      echo textStyle($value) . "    ";
                   } 

                   ?>
                  </h4>
                </div>
              </div>


              <div class="py-3">
                <div class="offset-1 col-lg-10">
                  <p><?php echo textStyle($userDet["university"])?></p>
                </div>
              </div>   
              <form method="post" action="BrowseUser.php">
                <div class="form-row pt-5">
                  <div class="offset-1 col-lg-10">
                      <h3>Interested?</h3>
                  </div>

                  <div class="offset-1 col-lg-10">
                    <input type="submit" class = "submit" name="action" value="Yes">
                    <input type="submit" class = "submit" name="action" value="No">
                  </div>
                </div>
              </form>
              <div class="form-row pt-5">
                <div class="offset-1 col-lg-10">
                  <a href="Menu.php">
                    Menu
                  </a>
                </div>
              </div>
            </form>
            
          </div>


          </div>
        </div>
      </div>
    </section>



  </body>
</html>