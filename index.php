<?php
// session_start();
// $_SESSION['userCount'] = 0;
// echo "I see this";

ob_start();
header('Location: Login.php');
ob_end_flush();
die();



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h3><a href="Login.php">Login</a> </h3>
	<h3><a href="Register.html">Register</a> </h3>
	<h3><a href="Userdetails.html">Userdetails</a> </h3>
	<h3><a href="Menu.html">Menu</a> </h3>
	<h3><a href="changePreferences.html">Change Preferences</a> </h3>
	<h3><a href="BrowseUser.php">Browse User</a> </h3>
	<h3><a href="AdminMenu.html">Admin Menu</a> </h3>
	<h3><a href="noUsers.html">No Users</a> </h3>
	<h3><a href="error.html">Error</a> </h3>
	<h3><a href="EditUser.php">Edit User</h3>
	<h3><a href="AdminEditUser.php">Admin Edit User</h3>	
	<h3><a href="test.php">Test</a> </h3>
	<h3><a href="UserProfile.php">User Profile</a>
	<h3><a href="favourites.php">Favs</a> 	
	 </h3>
	

</body>
</html>
