<?php
session_start();
require 'config.php';
require 'admin_news.php';
require 'admin_home.php';
require 'admin_permission.php';

$action = $_GET['action'];

if ((!isset($_SESSION['Connected']))||((!isset($_SESSION['Admin']))&&(!isset($_SESSION['Storer']))))
{
	header('Location: index.php');
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

// Write Basic Menu Structure
if (isset($_SESSION['Connected']))
{
	echo '<table width="100%" style="vertical-align: top"><tr><td style="vertical-align: top"><table id="admin_menu" cellspacing="1" cellpadding="4" class="tborder"><thead><tr><td class="thead"><strong>Menu</strong></td></tr></thead><tbody><tr><td class="trow1">';
	echo '<a href="admin.php">Home</a><br />';
	echo '<a href="admin.php?action=news">News</a><br />';
	echo '<a href="admin.php?action=quest">Quests</a><br />';
	if (isset($_SESSION['Admin']))
	{
		echo '<a href="admin.php?action=permission">Permissions</a>';
	}
	echo '<hr />';
	echo '<a href="index.php">Store</a>';
	echo '</td></tr></tbody></table></td><td style="vertical-align: top">';
}

// Action Controls
if (isset($_SESSION['Connected']))
{
	switch($action)
	{
		case "news":
			$news = $_POST['news'];
			if ($news != "")
			{
				InsertNews($news);
			}
			NewsPage();
			break;
			
		case "quest":
			break;
			
		case "permission":
		    $permissionType = $_POST['permission_type'];
			if ($permissionType != "")
			{
				if (($permissionType != "store_permission")&&($permissionType != "store_banned"))
				{
					Warn($_SESSION['User'], "permission_type: ".$permissionType);
				}
				else
				{
					$permissionAction = $_POST['permission_action'];
					$permissionBanned = 1;
					if ($permissionType == "store_permission")
						$permissionBanned = 0;
					$permissionUser = $_POST['permission_user'];
					$permissionAdmin = 0;
					if ($_POST['permission_admin'] == "on")
						$permissionAdmin = 1;
					$permissionStorer = 0;
					if ($_POST['permission_official'] == "on")
						$permissionStorer = 1;
					
					if (($permissionAction != "")&&($permissionUser != ""))
					{
						if ($permissionAction == "Add")
						{
							AddStorePermission($permissionUser, $permissionAdmin, $permissionBanned, $permissionStorer);
						}
						else if ($permissionAction = "Remove")
						{
							RemoveStorePermission($permissionUser, $permissionBanned);
						}
						else
						{
							Warn($_SESSION['User'], "permission_action: ".$permissionType);
						}
					}
					else
					{
						Warn($_SESSION['User'], "permission_type: ".$permissionAction."  permission_user: ".$permissionUser);
					}
				}
			}
			PermissionPage();
			break;
			
		default:
			if ($action != "")
			{
				Warn($_SESSION['User'], $action);
			}
			else
			{
				$logaction = $_GET['log'];
				if ($logaction == "delete")
				{
					DeleteWarningLog();
				}
				else
				{
					if ($logaction != "")
					{
						Warn($_SESSION['User'], "LOG#".$logaction);
					}
				}
				if (isset($_SESSION['Admin']))
				{
					HomePage($_SESSION['User'], true);
				}
				else
				{
					HomePage($_SESSION['User'], false);
				}
			}
			break;
	}
	
	// Closing Menu UI
	echo '</td></tr></table>';
}

?>

</div>
</body>
</html>