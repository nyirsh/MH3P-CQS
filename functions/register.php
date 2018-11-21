<?

function CheckAndRegister($user, $pwd, $email)
{
   $resultSet = array();

   $resultSet['ShowPopup'] = false;
   $resultSet['errorTitle'] = "";
   $resultSet['errorString'] = "";

   if(!$user || !$pwd || !$email)
   {
      $resultSet['ShowPopup'] = true;
      $resultSet['errorTitle'] = "What did you expect?";
      $resultSet['errorString'] = "Username, Password and Email are required";
   }
   else
   {
      $user = trim($user);
      if(strlen($user) > 30)
      {
         $resultSet['ShowPopup'] = true;
         $resultSet['errorTitle'] = "What did you expect?";
         $resultSet['errorString'] = "Invalid Username.<br />It can't be longer than 30 characters.";
      }
      else
      {
         if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
         {
             $resultSet['ShowPopup'] = true;
             $resultSet['errorTitle'] = "Sorry but...";
             $resultSet['errorString'] = "Invalid Email address.<br/>The Email address must be something like example@domain.com";
         }
         else
         {
             $registerResult = PerformRegister($user, $pwd, $email);
             
             if ($registerResult == 1)
             {
                $resultSet['ShowPopup'] = true;
                $resultSet['errorTitle'] = "Sorry but...";
                $resultSet['errorString'] = "The username ".$user." has been already taken";
             }
             else if ($registerResult == 2)
             {
                $resultSet['ShowPopup'] = true;
                $resultSet['errorTitle'] = "Sorry but...";
                $resultSet['errorString'] = "The Email address ".$email." has been already registered.";
             }
             else if ($registerResult == 3)
             {
                $resultSet['ShowPopup'] = true;
                $resultSet['errorTitle'] = "Registration Failure";
                $resultSet['errorString'] = "Unknown error. Please contact the site administrator.";
             }
             else
             {
                $resultSet['ShowPopup'] = true;
                $resultSet['errorTitle'] = "Registration Complete";
                $resultSet['errorString'] = "Welcome aboard ".$user."!<br/>No confirmation required, you can login from now on!<br/>Take a tour of the site and enjoy the stay.";
             }
         }
      }
   }

   return $resultSet;
}


function PerformRegister($username, $password, $email)
{
   require "./config.php";

   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());

   if(!get_magic_quotes_gpc())
   {
		$username = addslashes($username);
        $password = addslashes($password);
		$email = addslashes($email);
   }
    
   $q = "SELECT username FROM stor3_users WHERE username = '".$username."'";
   $result = mysql_query($q,$conn);
   if (mysql_numrows($result) > 0)
   {
      mysql_close();
      return 1;
   }

   $q = "SELECT email FROM stor3_users WHERE email = '".$email."'";
   $result = mysql_query($q,$conn);
   if (mysql_numrows($result) > 0)
   {
      mysql_close();
      return 2;
   }

   $md5pwd = md5($password);
   $randomcode = createRandomCode();
   $q = "INSERT INTO stor3_users (user_id , username , password , email, randomcode) VALUES (NULL , '".$username."', '".$md5pwd."', '".$email."', '".$randomcode."')";
   mysql_query($q,$conn);

   /* Verify that user is in database */
   $q = "SELECT user_id FROM stor3_users WHERE username = '".$username."' AND password = '".$md5pwd."' AND email = '".$email."'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1))
   {
      return 3;
   }

   $dbarray = mysql_fetch_array($result);
   mysql_close();

   $user_id = stripslashes($dbarray['user_id']);

   /* Validate if the user id is correct */
   if((!$user_id) || ($user_id == "") || ($user_id == 0))
   {
      return 3;
   }

   return 0; // Registration Complete
}


function createRandomCode() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $code = '' ; 

    while ($i <= 10) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $code = $code.$tmp; 
        $i++; 
    } 

    return $code; 

} 


function ChangePassword($username, $password)
{
	require "./config.php";
	
	$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
    mysql_select_db($dbdb, $conn) or die(mysql_error());
	
	if(!get_magic_quotes_gpc())
    {
		$username = addslashes($username);
        $password = addslashes($password);
    }
   
    $password = md5($password);
    $code = createRandomCode();
   
	$q = "UPDATE stor3_users SET password = '".$password."', randomcode = '".$code."' WHERE username = '".$username."'";
	
	mysql_query($q,$conn);
	mysql_close();
}

?>
