<?php

// Register function
if(isset($_POST['subjoin']))
{
   include "functions/register.php";

   $registerResult = CheckAndRegister($_POST['user'], $_POST['pwd'], $_POST['email']);

   $ShowPopup = $registerResult['ShowPopup'];
   $PopupTitle = $registerResult['errorTitle'];
   $PopupMessage = $registerResult['errorString'];
}

?>