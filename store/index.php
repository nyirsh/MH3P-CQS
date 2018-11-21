<?php
session_start();

require 'config.php';
require 'store_funcs.php';

$action = $_GET['action'];

if ($action == "logout")
{
	session_destroy();
	session_start();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
       <title>Custom Quest World</title>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <link type="text/css" rel="stylesheet" href="http://customquestworld.site88.net/forum/cache/themes/theme2/global.css" />
   </head>
   <body>
<div id="container">
<a name="top" id="top"></a>
<div id="header">
<div id="logo">
<a href="index.php"><img src="../forum/images/Logo.png" alt="Custom Quest World" title="Custom Quest World" /></a>
</div>
<div id="submenu">
<div id="submenu_left">
<strong>
<a href="../index.php">Index</a> |
<a href="../forum" target="_top">Forum</a> |
<a href="../downloads" target="_top">Downloads</a> |
<a href="index.php" target="_top">Store</a>
</strong>
</div>
</div>
</div>
<br />
<div align="center">
<?php

// Login Function
if (!isset($_SESSION['Connected']))
{	
	Login($_POST['username'], $_POST['password']);
}
if (!isset($_SESSION['Connected']))
{
	echo '<table>';
	echo '<tr><td width="400"><table border="0" cellspacing="1" cellpadding="4" class="tborder"><thead><tr><td class="thead">';
	echo '<strong>Login</strong></td></tr></thead><tbody><tr><td class="tcat"><form action="index.php" method="post">';
	echo '<table border="0"><tr><td><strong style="color:#FFF">Username: </strong></td><td><input type="text" name="username" /></td>';
	echo '</tr><tr><td><strong style="color:#FFF">Password: </strong></td><td><input type="password" name="password" /></td>';
	echo '</tr><tr><td></td><td><input type="submit" value="Login" /></td></tr></table></form></td></tr></tbody></table></td></tr>';
	echo '</table>';
}


// Write Basic Menu Structure
if (isset($_SESSION['Connected']))
{
	Links(isset($_SESSION['Guest']), (isset($_SESSION['Storer'])||isset($_SESSION['Admin'])));
}

// Action Controls
if (isset($_SESSION['Connected']))
{
	echo '<table><tr><td width="1000">';
	echo '<table border="0" cellspacing="1" cellpadding="4" class="tborder"><thead><tr><td class="thead"><strong>Home</strong>';
	echo '</td></tr></thead><tbody><tr><td class="trow1">';
	echo '<div align="center">';
	echo '<strong>'.$_SESSION['User'].', welcome to the Custom Quest World Store</strong><br /><br >';
	echo '<smalltext>From here you can manage your quests, download other users quests and vote your favorites!</smalltext><br />';
	echo '<smalltext>You can find everything you need from the menu on the left.</smalltext><br /><br />';
	echo '<div style="float: right"><a href="index.php?action=logout">Logout</a></div>';
	echo '</div>';
	echo '</td></tr></tbody></table>';
	
	// Closing Menu UI
	echo '</td></tr></table>';
}

?>

</div>
</body>
</html>