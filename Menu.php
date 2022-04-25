<?php
session_start();
if(!isset($_SESSION['ID'])){
  ob_start();
  header('Location: Login.php');
  ob_end_flush();
  die();
}
$_SESSION['userCount'] = 0;
$userId_LoggedIn = $_SESSION['ID'];

include("connections.php");
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="MainMenuStyle.css">
</head>
<body>

<!--
<div class="banner">
  <img class="banner-image" src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\banner.jpg">
<div class="banner--fadeBottom"></div>
</div>  -->

<div class="banner">
  <div class="banner__contents">
    <h1 class="banner__title">Love Connect </h1>
  </div>
  <div class="banner--fadeBottom"></div>
</div>


<div id="mySidenav" class="sidenav">
<input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search..." title="Search a user">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="UserProfile.php">My Profile</a>
  <a href="BrowseUser.php">Browse Users</a>
  <a href="changePreferences.html">Search</a>
  <a href="match.php">View Matches</a>
  <a href="EditUser.php">Edit Profile</a>
  <a href="favourites.php">Favourites</a>
  <a href="bestMatch.php">Best Match</a>
  <a href="includes/logout.inc.php">Log Out</a>
</div>

<div id="main">
  <span style="font-size:30px;cursor:pointer; color: white" onclick="openNav()">&#9776; Menu</span>
</div>
	

	<form id="form"> 
  <input type="search" id="search-box" placeholder="Search...">
  <button>Search</button>
</form>

    <!--Browse Users-->
<div class="row">
    <h2>BROWSE USERS</h2>
    <div class="row_posters">
<?php 

$sql = "SELECT * FROM images";
$result = mysqli_query($con,$sql); //potential error
$processedIds=array();
$id_to_image = array();
  
// Push elements to the array
if(mysqli_num_rows($result)> 0){
    while($fetch = mysqli_fetch_assoc($result)){
        $image = $image + 1;
        $userId =  $fetch["userId"];
        if(!in_array( $userId , $processedIds)){
            $id_to_image[$userId] =  $fetch["img_name"];
    ?>

<!--<div class="nameDiv"> -->
    <?php $finalImg = "./img/pfp/" . $fetch["img_name"]; ?>
  <a href="/BrowseUser.php?<?php echo $userId; ?>">
<img src="<?php echo $finalImg; ?>" alt="" class="row_poster row_posterLarge">
</a>
<!--<h6>Dean</h6>-->
    <?php
  // echo "Dean";

    
    $finalImg = "./img/pfp/" . $fetch["img_name"];

    ?>
<!--</div> -->
    <?php
    }
    array_push($processedIds, "$userId");
    }
}
?>
    </div>
</div>
	
	 <!--View Matches-->
    <div class="row">
      <h2>VIEW Likes</h2>
      <div class="row_posters">
       <?php 

$sql = "SELECT userId_Received FROM likes where userId_Sent=$userId_LoggedIn";
$result = mysqli_query($con,$sql); //potential error
if(mysqli_num_rows($result)> 0){
    while($fetch = mysqli_fetch_assoc($result)){
        $image = $image + 1;
    ?>


      <?php $finalImg = "./img/pfp/" . $id_to_image[$fetch["userId_Received"]]; ?>
  <a href="/BrowseUser.php?<?php echo $fetch["userId_Received"]; ?>">
<img src="<?php echo $finalImg; ?>" alt="" class="row_poster row_posterLarge">
</a>
<!--<h6>Dean</h6>-->
    <?php
  // echo "Dean";

    
    $finalImg = "./img/pfp/" . $fetch["img_name"];

    ?>
<!--</div> -->
    <?php
    }
}
?>
	</div>
    </div>

    <!--Your Top 5 Matches!-->
    <div class="row">
      <h2>TOP 5 MATCHES</h2>
      <div class="row_posters">
        <img src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\girl5.jpg" alt="" class="row_poster row_posterLarge">
        <img src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\girl.webp" alt="" class="row_poster row_posterLarge">
		<img src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\girl3.jpg" alt="" class="row_poster row_posterLarge">
		<img src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\girl4.jpg" alt="" class="row_poster row_posterLarge">			
	  	<img src="C:\Users\35386\OneDrive\Desktop\Year 3\CS4116\images\girl6.jpg" alt="" class="row_poster row_posterLarge">

      </div>
    </div>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}

function viewMatches(){


}


</script>
   
</body>
</html> 
