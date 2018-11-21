<?

/*
 * Checks the entire datas
 */
function CheckDatas($user, $pwd)
{
   $resultSet = array();

   $resultSet['ShowPopup'] = false;
   $resultSet['errorTitle'] = "";
   $resultSet['errorString'] = "";
   $resultSet['isBanned'] = false;
   $resultSet['isLogged'] = false;

   if(!$user || !$pwd)
   {
      $resultSet['ShowPopup'] = true;
      $resultSet['errorTitle'] = "What did you expect?";
      $resultSet['errorString'] = "Both Username and Password are required";
   }
   else
   {
     $user = trim($user);
     if(strlen($user) > 30)
     {
        $resultSet['ShowPopup'] = true;
        $resultSet['errorTitle'] = "What did you expect?";
        $resultSet['errorString'] = "Invalid Username.<br />It can't be longer than 30 characters";
     }
     else
     {
       $md5pass = md5($pwd);
       $result = confirmUser($user, $md5pass);
       if($result == 1)
       {
         $resultSet['ShowPopup'] = true;
         $resultSet['errorTitle'] = "Woops, something's wrong";
         $resultSet['errorString'] = "This username does not exists";
       }
       else if ($result == 2)
       {
         $resultSet['ShowPopup'] = true;
         $resultSet['errorTitle'] = "Woops, something's wrong";
         $resultSet['errorString'] = "Password not correct.<br/>If you don't remember it, just change it.";
       }
       else
       {
         setSessionVariables($result, $result['username'], $md5pass);
         if ($_SESSION['GroupID'] == '-1')
         {
            $resultSet['isBanned'] = true;
         }
            
         if(isset($_POST['rememberme']))
         {
            setcookie("cookname", $result['username'], time()+60*60*24*100, "/");
            setcookie("cookpass", $md5pass, time()+60*60*24*100, "/");
         }
   
         $resultSet['isLogged'] = true;
       }
     }
   }
   return $resultSet;
}





/*
 * Sets the session variables according to the resultset
 */
function setSessionVariables($sessarr, $user, $pass)
{
   $_SESSION['username'] = $user;
   $_SESSION['password'] = $pass;
   $_SESSION['GroupID'] = $sessarr['group_id'];
   $_SESSION['GroupName'] = $sessarr['group_name'];
   $_SESSION['user_id'] = $sessarr['user_id'];
   if ($_SESSION['GroupID'] != '-1')
   {
      if ($sessarr['quest_space'] == '-1')
      {
          $_SESSION['QuestSpace'] = 'Unlimited';
      }
      else
      {
          $_SESSION['QuestSpace'] = $sessarr['quest_space'];
      }
   }
}



/*
 * Checks whether or not the given username is in the
 * database, if so it checks if the given password is
 * the same password in the database for that user.
 * If the user doesn't exist or if the passwords don't
 * match up, it returns an error code (1 or 2). 
 * On success it returns 0.
 */
function confirmUser($username, $password)
{
   require "./config.php";
	
   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());

   /* Add slashes if necessary (for query) */
   if(!get_magic_quotes_gpc())
   {
	$username = addslashes($username);
   }

   /* Verify that user is in database */
   $q = "SELECT stor3_users.username, stor3_users.password, stor3_users.quest_space, stor3_groups.group_id, stor3_groups.group_name, stor3_users.user_id FROM stor3_users INNER JOIN stor3_groups ON stor3_users.group_id = stor3_groups.group_id WHERE username = '".$username."'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1))
   {
      return 1; // Username Failure
   }

   /* Retrieve password from result, strip slashes */
   $dbarray = mysql_fetch_array($result);
   mysql_close();

   $dbarray['password']  = stripslashes($dbarray['password']);
   $password = stripslashes($password);

   /* Validate that password is correct */
   if($password == $dbarray['password'])
   {
      return $dbarray; //Success! Username and password confirmed
   }
   else
   {
      return 2; //Indicates password failure
   }
   
   
}

/*
 * Checks if the user has already previously logged in,
 * Returns true if the user has logged in.
 */
function checkLogin()
{
    session_start();

    /* Username and password have been set */
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
      /* Confirm that username and password are valid */
      $confirmResult = confirmUser($_SESSION['username'], $_SESSION['password']);

      if(($confirmResult == 1) || ($confirmResult == 2))
      {
         /* Variables are incorrect, user not logged in */
         unset($_SESSION['username']);
         unset($_SESSION['password']);
         return false;
      }
      setSessionVariables($confirmResult, $_SESSION['username'], $_SESSION['password']);
      return true;
    }
    else
    {
      /* Check if user has been remembered */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']))
      {
        $_SESSION['username'] = $_COOKIE['cookname'];
        $_SESSION['password'] = $_COOKIE['cookpass'];
		return checkLogin();
      }
      return false;
    }
}

?>
