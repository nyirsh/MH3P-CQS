<?
	$warnFile = "logs/warnings.log";

	if ($isAuthorized)
	{
		$isValidSearch = true;
		if ($_POST["searchbutton"] != "Search")
			$isValidSearch = false;
		
		// Initial Check
		if ($isValidSearch)
		{
			$search_username = $_POST['username'];
			$search_email = $_POST['email'];
			$search_group = $_POST['group'];
			
			if ($search_username == null)
				$search_username = "";
			if ($search_email == null)
				$search_email = "";
			if ($search_group == null)
				$search_group = "";
				
			if (($search_username == "" && $search_email == "" && $search_group == "") || strlen($search_username) > 30 || strlen($search_email) > 30 || strlen($search_group) > 30)
			{
				$ShowPopup = true;
				$PopupTitle = "Searching for user?";
				$PopupMessage = "You need to insert at least a username or an email address<br/>or a user group in order to search for users!";
				$isValidSearch = false;
			}
		}
		
		// Search
		if ($isValidSearch)
		{
			require "config.php";
		
			$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
			mysql_select_db($dbdb, $conn) or die(mysql_error());
			if(!get_magic_quotes_gpc())
			{
				$search_username = addslashes($search_username);
				$search_email = addslashes($search_email);
				$search_group = addslashes($search_group);
			}
			
			$searchresults = array();
			
			$wherecondition = "WHERE ";
			if ($search_username != "")
				$wherecondition .= "username LIKE '".$search_username."%' AND ";
			if ($search_email != "")
				$wherecondition .= "email LIKE '".$search_email."%' AND ";
			if ($search_group != "")
				$wherecondition .= "u.group_id = '".$search_group."' AND ";
			$wherecondition = substr($wherecondition, 0, -4);
			$result = mysql_query("SELECT u.*, g.group_name FROM stor3_users AS u INNER JOIN stor3_groups AS g ON u.group_id = g.group_id ".$wherecondition,$conn);
			
			if(mysql_numrows($result) > 0)
			{
				while($searchresults[] = mysql_fetch_array($result)) { }
			}
			mysql_close();
		}
		
		// Actions on User
		$useraction = $_POST['formbutton'];
		$user_id = $_POST['user_id'];
		
		if ($user_id != null && $user_id != "")
		{
			if ($user_id == "1")
			{
				$ShowPopup = true;
				$PopupTitle = "WTF are you trying to do?";
				$PopupMessage = "Very well, you have been logged my dear...";
				require 'functions/logger.php';
				Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User unban code changed to 1.");
			}
			switch($useraction)
			{
				// Back
				case "Back":
					$_POST['user_id'] = "";
					$_POST['username'] = "";
					$_POST['email'] = "";
					$_POST['group_id'] = "";
					break;
			
				// Change Space
				case "Change Space":
					require "config.php";
					$userspace = $_POST["userspace"];
					if ($userspace != "" && $userspace != null)
					{
						if ($userspace == "unlimited")
							$userspace = "-1";
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
						{
							$user_id = addslashes($user_id);
							$userspace = addslashes($userspace);
						}
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							mysql_query("UPDATE stor3_users SET quest_space = '".$userspace."' WHERE user_id = '".$user_id."'",$conn);
							
							$ShowPopup = true;
							$PopupTitle = "Space travel";
							$PopupMessage = "The user quest space has been succesfully changed.";
						}
						else
						{
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on quest space change.");
						}
						mysql_close();
					}
					else
					{
						$ShowPopup = true;
						$PopupTitle = "Problems sir?";
						$PopupMessage = "You can't insert a void quest space.";
						
						$pageviewmode = "viewuser";
						require "config.php";
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
							$user_id = addslashes($user_id);
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							$userresult = mysql_fetch_array($result);
						}
						else
						{
							$pageviewmode = "";
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed.");
						}
						mysql_close();
					}
					break;
			
			
				// Change Group
				case "Change Group":
					require "config.php";
					$group = $_POST["group"];
					if ($group != "" && $group != null)
					{
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
						{
							$user_id = addslashes($user_id);
							$group = addslashes($group);
						}
						$result = mysql_query("SELECT * FROM stor3_groups WHERE group_id = '".$group."'",$conn);
						
						if (mysql_numrows($result) > 0)
						{
							$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
							
							if (mysql_numrows($result) > 0)
							{
								mysql_query("UPDATE stor3_users SET group_id = '".$group."' WHERE user_id = '".$user_id."'",$conn);
								
								if ($group == "-1")
								{
									$banexp = $_POST['banexp'];
									if ($banexp == null)
										$banexp = "";
									$banexp = str_replace("\r\n", "<br/>", $banexp);
									$banexp = str_replace("\n", "<br/>", $banexp);
									$banexp = str_replace("\r", "<br/>", $banexp);
									if(!get_magic_quotes_gpc())
									{
										$banexp = addslashes($banexp);
									}
									
									mysql_query("INSERT INTO stor3_banexplain (user_id,banner_id,message) VALUES('".$user_id."', '".$_SESSION['user_id']."', '".$banexp."')",$conn);
								}
								
								$ShowPopup = true;
								$PopupTitle = "User permission changed";
								$PopupMessage = "The usergroup has been succesfully changed.";
								$_POST["group"] = "";
							}
							else
							{
								$ShowPopup = true;
								$PopupTitle = "WTF are you trying to do?";
								$PopupMessage = "Very well, you have been logged my dear...";
								require 'functions/logger.php';
								Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on group change.");
							}
						}
						else
						{
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on group change.");
						}
						mysql_close();
					}
					else
					{
						$ShowPopup = true;
						$PopupTitle = "WTF are you trying to do?";
						$PopupMessage = "Very well, you have been logged my dear...";
						require 'functions/logger.php';
						Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on group change.");
					}
					break;
					
				// Change Password
				case "Change Password":
					require "config.php";
					$password = $_POST["password"];
					if ($password != "" && $password != null)
					{
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
						{
							$user_id = addslashes($user_id);
						}
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							$oldmail = mysql_result($result,0,"email");
							mysql_query("UPDATE stor3_users SET password = '".md5($password)."' WHERE user_id = '".$user_id."'",$conn);
							require 'functions/mailer.php';
							SendMail($oldmail, "[QS3] Password change notify", "<html><body>Your password has been changed to ".$password." from the user ".$_SESSION['username'].".<br/>If you haven't request a password change, please contact the site administrators and report the user.</body></html>");
							
							$ShowPopup = true;
							$PopupTitle = "New password?";
							$PopupMessage = "The password was succesfully changed";
							$_POST["password"] = "";
						}
						else
						{
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on password change.");
						}
						mysql_close();
					}
					else
					{
						$ShowPopup = true;
						$PopupTitle = "Problems sir?";
						$PopupMessage = "You can't insert a void password.";
						
						$pageviewmode = "viewuser";
						require "config.php";
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
							$user_id = addslashes($user_id);
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							$userresult = mysql_fetch_array($result);
						}
						else
						{
							$pageviewmode = "";
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed.");
						}
						mysql_close();
					}
					break;
					
				// Change Email
				case "Change Email":
					require "config.php";
					$email = $_POST["email"];
					if ($email != "" && $email != null)
					{
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
						{
							$user_id = addslashes($user_id);
							$email = addslashes($email);
						}
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							$oldmail = mysql_result($result,0,"email");
							mysql_query("UPDATE stor3_users SET email = '".$email."' WHERE user_id = '".$user_id."'",$conn);
							require 'functions/mailer.php';
							SendMail($oldmail, "[QS3] Email address change notify", "<html><body>Your email address has been changed to ".$email." from the user ".$_SESSION['username'].".<br/>If you haven't request a email address change, please contact the site administrators and report the user.</body></html>");
							
							$ShowPopup = true;
							$PopupTitle = "New address?";
							$PopupMessage = "The email address was succesfully changed";
							$_POST["email"] = "";
						}
						else
						{
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed on email change.");
						}
						mysql_close();
					}
					else
					{
						$ShowPopup = true;
						$PopupTitle = "Problems sir?";
						$PopupMessage = "Please insert a valid email address.";
						
						$pageviewmode = "viewuser";
						require "config.php";
						$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
						mysql_select_db($dbdb, $conn) or die(mysql_error());
						if(!get_magic_quotes_gpc())
							$user_id = addslashes($user_id);
						$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
						
						if(mysql_numrows($result) > 0)
						{
							$userresult = mysql_fetch_array($result);
						}
						else
						{
							$pageviewmode = "";
							$ShowPopup = true;
							$PopupTitle = "WTF are you trying to do?";
							$PopupMessage = "Very well, you have been logged my dear...";
							require 'functions/logger.php';
							Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed.");
						}
						mysql_close();
					}
					break;
					
				// View
				case "View":
					$pageviewmode = "viewuser";
					
					require "config.php";
					$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
					mysql_select_db($dbdb, $conn) or die(mysql_error());
					if(!get_magic_quotes_gpc())
						$user_id = addslashes($user_id);
					$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."'",$conn);
					
					if(mysql_numrows($result) > 0)
					{
						$userresult = mysql_fetch_array($result);
					}
					else
					{
						$pageviewmode = "";
						$ShowPopup = true;
						$PopupTitle = "WTF are you trying to do?";
						$PopupMessage = "Very well, you have been logged my dear...";
						require 'functions/logger.php';
						Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User code changed.");
					}
					mysql_close();
					break;
					
				// Unban
				case "Unban":
					require "config.php";
			
					$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
					mysql_select_db($dbdb, $conn) or die(mysql_error());
					if(!get_magic_quotes_gpc())
					{
						$user_id = addslashes($user_id);
					}
					$result = mysql_query("SELECT * FROM stor3_users WHERE user_id = '".$user_id."' AND group_id = -1",$conn);
					if(mysql_numrows($result) > 0)
					{
						$oldmail = mysql_result($result,0,"email");
						mysql_query("UPDATE stor3_users SET group_id = 1 WHERE user_id = '".$user_id."'",$conn);
						mysql_query("DELETE FROM stor3_banexplain WHERE user_id = '".$user_id."'", $conn);
						$ShowPopup = true;
						$PopupTitle = "Banned? No more!";
						$PopupMessage = "The user has been succesfully unbanned.";
						
						require 'functions/mailer.php';
						SendMail($oldmail, "[QS3] Banned? No more!", "<html><body>Hi, your account is enabled again!<br/>From now on you can log into the QS3 network and upload your quests.<br/>Remember to follow the rules and have a nice day!<br/> ~ QS3 Staff</body></html>");
					}
					else
					{
						$ShowPopup = true;
						$PopupTitle = "WTF are you trying to do?";
						$PopupMessage = "Very well, you have been logged my dear...";
						require 'functions/logger.php';
						Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "User unban code changed.");
					}
					mysql_close();
					break;
			}
		}
		
		?>
		<script type="text/javascript">
			function checkForBanned() 
			{
				var idx = document.getElementById("usergrouplist");
				if (idx.options[idx.selectedIndex].value == "-1")
					$("#banexprow").fadeIn();
				else
					$("#banexprow").fadeOut();
			}
		</script>
		<?
	}
	else
		echo "You are not authorized to view this page.";
?>