<?php

function PermissionPage()
{
	require 'config.php';	
	
	mysql_connect($host, $name, $password);
   	mysql_select_db($db); 
	
	// Usage Permissions
	echo '<table width="70%" class="tborder">';
	echo '<thead><tr><td class="thead"><strong>Usage Permissions:</strong></td></tr></thead>';
	echo '<tbody><tr><td class="tcat">';
  	echo '<form action="admin.php?action=permission" method="post">';
	echo '<strong>Username: <input type="hidden" name="permission_type" value="store_permission"><input type="text" name="permission_user" size="50"/><div style="float: right"><input type="submit" value="Add" name="permission_action" /><input type="submit" value="Remove" name="permission_action" /></div></strong></form></td></tr>';
	echo '<tr><td class="trow1">';
	
	$permitted = mysql_query("SELECT * FROM store_permission INNER JOIN mybb_users ON user_id = uid INNER JOIN mybb_userfields ON uid = ufid WHERE isBanned = '0' AND isAdmin = '0' AND isOfficial = '0' ORDER BY username ASC");
   	$numpermitted = mysql_num_rows($permitted);
	
	echo '<table border="0" width="100%">';
   	$i=0;
   	while ($i < $numpermitted)
   	{
	   if ($i % 4 == 0)
	   {
		   echo '<tr>';
	   }
 
	   echo '<td width="25%">';
	   $currusr = mysql_result($permitted,$i,"username");
	   $curradm = mysql_result($permitted,$i,"isAdmin");
	   $currcountry =  mysql_result($permitted, $i, "fid5");

	   if ($currcountry != "")
	   {
		   echo '[<img width="15" height="10" src="../forum/images/flags/'.$currcountry.'.gif" alt="'.$currcountry.'" />] ';
	   }
	   echo ''.$currusr;
	   if ($curradm == true)
	   {
		  echo '*';
	   }
	   echo '</td>';
	   $i++;
	   if ($i % 4 == 0)
	   {
		   echo '</tr>';
	   }
   	}
   	$remaining = $numpermitted % 4;
   
   	while($remaining > 0)
   	{
	  echo '<td></td>';
	  $remaining--;
   	}

   	if ($numpermitted < 4)
   	{
	   echo '</tr>';
   	}
   	echo '</table>';
	echo '</td></tr>';
	echo '</table>';
	
	echo '<br/>';
	
	// Store Permissions
	echo '<table width="70%" class="tborder">';
	echo '<thead><tr><td class="thead"><strong>Store Permissions:</strong></td></tr></thead>';
	echo '<tbody><tr><td class="tcat">';
  	echo '<form action="admin.php?action=permission" method="post">';
	echo '<strong>Username: <input type="hidden" name="permission_type" value="store_permission"><input type="text" name="permission_user" size="50"/><input type="checkbox" name="permission_admin" />Administrator<input type="checkbox" name="permission_official" />Official Storer<div style="float: right"><input type="submit" value="Add" name="permission_action" /><input type="submit" value="Remove" name="permission_action" /></div></strong></form></td></tr>';
	echo '<tr><td class="trow1">';
	
	$permitted = mysql_query("SELECT * FROM store_permission INNER JOIN mybb_users ON user_id = uid INNER JOIN mybb_userfields ON uid = ufid WHERE isBanned = '0' AND isAdmin = '1' OR isOfficial = '1' ORDER BY username ASC");
   	$numpermitted = mysql_num_rows($permitted);
	
	echo '<table border="0" width="100%">';
   	$i=0;
   	while ($i < $numpermitted)
   	{
	   if ($i % 4 == 0)
	   {
		   echo '<tr>';
	   }
 
	   echo '<td width="25%">';
	   $currusr = mysql_result($permitted,$i,"username");
	   $curradm = mysql_result($permitted,$i,"isAdmin");
	   $currcountry =  mysql_result($permitted, $i, "fid5");

	   if ($currcountry != "")
	   {
		   echo '[<img width="15" height="10" src="../forum/images/flags/'.$currcountry.'.gif" alt="'.$currcountry.'" />] ';
	   }
	   echo ''.$currusr;
	   if ($curradm == true)
	   {
		  echo '*';
	   }
	   echo '</td>';
	   $i++;
	   if ($i % 4 == 0)
	   {
		   echo '</tr>';
	   }
   	}
   	$remaining = $numpermitted % 4;
   
   	while($remaining > 0)
   	{
	  echo '<td></td>';
	  $remaining--;
   	}

   	if ($numpermitted < 4)
   	{
	   echo '</tr>';
   	}
   	echo '</table>';
	echo '</td></tr>';
	echo '</table>';
	
	echo '<br/>';
	
	// Banned Users
	echo '<table width="70%" class="tborder">';
	echo '<thead><tr><td class="thead"><strong>Banned Users:</strong></td></tr></thead>';
	echo '<tbody><tr><td class="tcat">';
  	echo '<form action="admin.php?action=permission" method="post">';
	echo '<strong>Username: <input type="hidden" name="permission_type" value="store_banned"><input type="text" name="permission_user" size="50"/><div style="float: right"><input type="submit" value="Add" name="permission_action" /><input type="submit" value="Remove" name="permission_action" /></div></strong></form></td></tr>';
	echo '<tr><td class="trow1">';
	
	$permitted = mysql_query("SELECT * FROM store_permission INNER JOIN mybb_users ON user_id = uid INNER JOIN mybb_userfields ON uid = ufid WHERE isBanned = TRUE ORDER BY username ASC");
   	$numpermitted = mysql_num_rows($permitted);
	
	echo '<table border="0" width="100%">';
   	$i=0;
   	while ($i < $numpermitted)
   	{
	   if ($i % 4 == 0)
	   {
		   echo '<tr>';
	   }
 
	   echo '<td width="25%">';
	   $currusr = mysql_result($permitted,$i,"username");
	   $currcountry =  mysql_result($permitted, $i, "fid5");

	   if ($currcountry != "")
	   {
		   echo '[<img width="15" height="10" src="../forum/images/flags/'.$currcountry.'.gif" alt="'.$currcountry.'" />] ';
	   }
	   echo ''.$currusr;
	   
	   echo '</td>';
	   $i++;
	   if ($i % 4 == 0)
	   {
		   echo '</tr>';
	   }
   	}
   	$remaining = $numpermitted % 4;
   
   	while($remaining > 0)
   	{
	  echo '<td></td>';
	  $remaining--;
   	}

   	if ($numpermitted < 4)
   	{
	   echo '</tr>';
   	}
	
	if ($numpermitted == 0)
	{
		echo '<tr><td><i><smalltext>No user banned</smalltext></i></td></tr>';
	}
   	echo '</table>';
	
	echo '</td></tr>';
	echo '</table>';
	
	
	mysql_close();
}

function AddStorePermission($username, $isAdmin, $isBanned, $isStorer)
{
	require 'config.php';
	
	mysql_connect($host, $name, $password);
   	mysql_select_db($db); 
	
	$userResult = mysql_query("SELECT * FROM store_permission INNER JOIN mybb_users ON user_id = uid WHERE username = '".$username."'");
	if (mysql_num_rows($userResult) > 0)
	{
		// Modify User
		$uid = mysql_result($userResult, 0, "uid");
		$query = "UPDATE store_permission SET isAdmin = '".$isAdmin."', isBanned = '".$isBanned."', isOfficial = '".$isStorer."' WHERE user_id = '".$uid."'";
		mysql_query($query);
	}
	else
	{
		// Insert User
		$userResult = mysql_query("SELECT * FROM mybb_users INNER JOIN mybb_userfields WHERE username = '".$username."'");
		if (mysql_num_rows($userResult) > 0)
		{
			// Only if user really exists
			$uid = mysql_result($userResult, 0, "uid");
			$query = "INSERT INTO store_permission (`user_id`, `isAdmin`, `isBanned`, `isOfficial`) VALUES ('".$uid."', '".$isAdmin."', '".$isBanned."', '".$isStorer."');";
			mysql_query($query);
		}
	}
	
	mysql_close();
}

function RemoveStorePermission($username, $banFlag)
{
	require 'config.php';
	
	mysql_connect($host, $name, $password);
   	mysql_select_db($db); 
	
	$userResult = mysql_query("SELECT * FROM store_permission INNER JOIN mybb_users ON user_id = uid WHERE username = '".$username."'");
	if (mysql_num_rows($userResult) > 0)
	{
		$uid = mysql_result($userResult, 0, "uid");
		if ($banFlag)
		{
			// Only Remove Ban Flag
			$query = "UPDATE store_permission SET isBanned = '0' WHERE user_id = '".$uid."'";
			mysql_query($query);
		}
		else
		{
			// Remove the entire Entry
			mysql_query("DELETE FROM store_permission WHERE user_id = '".$uid."'");
		}
	}
	mysql_close();
}
?>