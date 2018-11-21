<?php

// Banned Check
if($_SESSION['GroupID'] == '-1')
{
   require "functions/banned.php";

   $isBanned = true;
   $ShowPopup = true;
   $PopupTitle = "You are banned!";
   $banResult = GetBanDetails($_SESSION['username']);
   $PopupMessage = "<b><h2>Details</h2></b><p class=\"grey\">Banned by: ".$banResult['username']."<br/><u>Explanation:</u><br/>".$banResult['message'];
   $PopupMessage .= "<hr/><i><p class=\"grey\">If you think that there was an error,<br/>please contact the site administrators.</p></i>";
}

?>