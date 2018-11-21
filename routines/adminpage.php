<?php

include "functions/login.php";
$isLogged = checkLogin();
$isAuthorized = false;

if($isLogged == true)
{
	if($_SESSION['GroupID'] != 0)
		$isAuthorized = false;
	else
		$isAuthorized = true;
}

?>