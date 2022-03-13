<?php

include("includes/browse_users_functions.inc.php");
include("connections.php");

// $pref  = getPreferences(1, $con);
// print_r($pref);

$userDet = getUserDetails(1, $con);
print_r(groupHobbies("Running,talking"));
print_r($userDet);
