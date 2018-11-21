<?php

// Login procedure
include "functions/login.php";
$isLogged = checkLogin();

if(isset($_POST['sublogin']))
{
   $loginResult = CheckDatas($_POST['user'], $_POST['pwd']);

   $ShowPopup = $loginResult['ShowPopup'];
   $PopupTitle = $loginResult['errorTitle'];
   $PopupMessage = $loginResult['errorString'];
   $isBanned = $loginResult['isBanned'];
   $isLogged = $loginResult['isLogged'];
}

?>