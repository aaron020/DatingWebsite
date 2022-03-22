<?php
session_start();
include("includes/browse_users_functions.inc.php");
include("connections.php");


//The user that is logged in - Get their details
$userId_LoggedIn = $_SESSION['ID'];
$userDet = getUserDetails($userId_LoggedIn, $con);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/InputStyle.css">
  <title>Edit Details</title>
</head>
<body>


  <div class="box" style="width: 40%;">
    <a href="Menu.html"> <button style="width: 20%;">Main Menu</button> </a>
      <h1>Edit User Details</h1>
      <hr>
      <!-- onsubmit="return validateForm() -->
      
      <form action="includes/editUser.inc.php" name="CreateUser" method = "post"
       enctype="multipart/form-data"> 
        <div class="image-button">
            <h3>Profile Pic:</h3>
            <input type="file" id="img" name="img" accept="image/*">
        </div>

        <div class="input-user">
          <h3>Name:</h3>
          <input type="text" name = "firstname" id="firstname" maxlength="20" placeholder="<?php echo textStyle($userDet["firstname"])?>">
          <input type="text" name = "lastname" id="lastname" maxlength="20" placeholder="<?php echo textStyle($userDet["lastname"])?>">
        </div>

        <div class="slidecontainer">
          <h3>Age: <span id="demo"></span></h3>
          <input style="width: 100%" name = "age" type="range" min="18" max="99" value="<?php echo $userDet["age"]?>" class="slider" id="myRange">
          <script>
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value;

            slider.oninput = function() {
              output.innerHTML = this.value;
            }
          </script>
        </div>

        <div class="City">
          <h3>City:</h3>
          <input type="text" id = "city" name="city" maxlength= "30" placeholder="<?php echo textStyle($userDet["city"])?>">
        </div>

        <div class="Bio">
          <h3>Bio :</h3>
          <textarea rows="5" maxlength="250" name="bio" id = "bio" placeholder="<?php echo $userDet["bio"]?>"></textarea>
        </div>

        <div class="Uni">
          <h3>University:</h3>
          <input type="text" name = "uni" id = "uni" maxlength= "30" placeholder="<?php echo textStyle($userDet["university"])?>">
        </div>

        <div class="Job">
          <h3>Job:</h3>
          <input type="text" name  = "job" id = "job" maxlength = "30" placeholder="<?php echo textStyle($userDet["job"])?>">
        </div>

        <div class="Hobbies">
          <h3>Hobbies:</h3>
          <input type="text" name="hobbies" id = "hobbies" maxlength = "100" placeholder="<?php echo $userDet["hobbies"]?>">
        </div>

        <div class="Contact">
          <h3>Instagram Handle: </h3>
          <input type="text" name="contact" id = "contact" maxlength="30" placeholder="<?php echo $userDet["contact"]?>">
        </div>

        <div class="submit-button">
          <button type="submit" class="float">Update Profile</button>
        </div> 
      </form>
  </div>
</body>
</html>