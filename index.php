<?php
session_start();
$_SESSION['userCount'] = 0;
echo "I see this";


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h3><a href="Login.html">Login</a> </h3>
	<h3><a href="Register.html">Register</a> </h3>
	<h3><a href="Userdetails.html">Userdetails</a> </h3>
	<h3><a href="Menu.html">Menu</a> </h3>
	<h3><a href="changePreferences.html">Change Preferences</a> </h3>
	<h3><a href="BrowseUser.php">Browse User</a> </h3>
	<h3><a href="AdminMenu.html">Admin Menu</a> </h3>
	<h3><a href="noUsers.html">No Users</a> </h3>
	<h3><a href="error.html">Error</a> </h3>
	<h3><a href="test.php">Test</a> </h3>

</body>
</html>