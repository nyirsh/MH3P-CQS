<?

function GetUserDetails($user)
{
   $resultSet = array();

   $resultSet['email'] = "";
   $resultSet['code'] = "";
   
   require "./config.php";
	
   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());
   
   if(!get_magic_quotes_gpc())
   {
	  $user = addslashes($user);
   }
   
   $q = "SELECT email, randomcode FROM stor3_users WHERE username = '".$user."'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1))
   {
      $resultSet['email'] = "";
	  $resultSet['code'] = "";
   }
   else
   {
		$resultSet['email'] = mysql_result($result,0,"email");
        $resultSet['code'] = mysql_result($result,0,"randomcode");
   }
   
   mysql_close();
   
   return $resultSet;
}


function GetUsername($email)
{  
   require "./config.php";
	
   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());
   
   if(!get_magic_quotes_gpc())
   {
	  $email = addslashes($email);
   }
   
   $q = "SELECT username FROM stor3_users WHERE email = '".$email."'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1))
   {
      $username = "";
   }
   else
   {
	  $username = mysql_result($result,0,"username");
   }
   
    mysql_close();
   
   return $username;
}


function CheckCode($user, $code)
{
   $resultSet = false;   
   require "./config.php";
	
   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());
   
   if(!get_magic_quotes_gpc())
   {
	  $user = addslashes($user);
	  $code = addslashes($code);
   }
   
   $q = "SELECT user_id FROM stor3_users WHERE username = '".$user."' AND randomcode = '".$code."'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1))
   {
        $resultSet = false;
   }
   else
   {
		$resultSet = true;
   }
   
   mysql_close();
   
   return $resultSet;
}

?>
