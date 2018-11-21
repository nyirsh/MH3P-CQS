<?php

// Stampa i Link delle pagine a seconda dei permessi degli utenti
function Links($guest, $admin)
{
	echo '<table width="100%" style="vertical-align: top"><tr><td style="vertical-align: top"><table id="admin_menu" cellspacing="1" cellpadding="4" class="tborder">';
	echo '<thead><tr><td class="thead"><strong>Menu</strong></td></tr></thead><tbody><tr><td class="trow1">';
	echo '<a href="index.php">Home</a><br />';
	if (!$guest)
		echo '<a href="personal.php">Your Quests</a><br />';
	echo '<a href="store.php">Download</a><br />';
	if ($admin)
	{
		echo '<hr />';
		echo '<a href="admin.php">Administration</a>';
	}
	
	echo '</td></tr></tbody></table></td><td style="vertical-align: top">';
}

// Aggiunge una riga al file deigli avvertimenti
function Warn($warn_user, $warn_action)
{
	$warnFile = "warnings.txt";
	$fh = fopen($warnFile, 'a');
	$stringData = "User: ".$warn_user."\t\tAction: ".$warn_action."\t\tDate Time:".date("d/m")." ".time()."\r\n";
	fwrite($fh, $stringData);
	fclose($fh);
}

// Calcola il Checksum del Download del file
function DCSUM($file)
{
	$byteArr = array();
	$fhandle = fopen($file, "rb");
	while (!feof($fhandle))
	{
		$data = fread($fhandle, 1);
		array_push($byteArr, $data);
	}
	fclose($fhandle);

	$arrTot = count($byteArr);
	$crc = 0;
	for($index = 0; $index < $arrTot; $index++)
	{
		$crc += ord($byteArr[$index]);
	}
	$crc = $crc % 0x10000;
	return $crc;
}

// Effettua il Login
function Login($usr, $pwd)
{
	require 'config.php';
	
	session_start();
	
	if(($pwd!="")&&($usr!=""))
	{
		mysql_connect($host, $name, $password);
		mysql_select_db($db);
		
		$userResult = mysql_query("SELECT * FROM mybb_users WHERE username='".$usr."'");
		if (mysql_num_rows($userResult) > 0)
		{
			$uid = mysql_result($userResult,0,"uid");
			$salt = mysql_result($userResult,0,"salt");
			$pwd = md5(md5($salt).md5($_POST['password']));
			$tocheck = mysql_result($userResult,0,"password");
			if ($pwd == $tocheck)
			{
				$_SESSION['Connected'] = 'True';
				$_SESSION['User'] = $usr;
				$_SESSION['Uid'] = $uid;
				$storeResult = mysql_query("SELECT * FROM store_permission  WHERE user_id='".$uid."' AND isBanned=0");
				if (mysql_num_rows($storeResult) > 0)
				{
					$admin = mysql_result($storeResult,0,"isAdmin");
					if ($admin == 1)
					{
						$_SESSION['Admin'] = 'True';
					}
					$storer = mysql_result($storeResult,0,"isOfficial");
					if ($storer == 1)
					{
						$_SESSION['Storer'] = 'True';
					}
				}
				else
				{
					$_SESSION['Guest'] = 'True';
				}
			}
			else
			{
				Warn($usr, "PWDERR");
			}
		}
		else
		{
			Warn($usr, "LNA");
		}
		
		mysql_close();
	}
}

?>