<?

function GetBanDetails($username)
{
   require "./config.php";

   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());

   if(!get_magic_quotes_gpc())
   {
	$username = addslashes($username);
   }
    
   $q = "SELECT BE.message, BT.username FROM stor3_users AS BU INNER JOIN stor3_banexplain AS BE ON BU.user_id = BE.user_id INNER JOIN stor3_users AS BT ON BE.banner_id = BT.user_id WHERE BU.username = '".$username."'";
   $result = mysql_query($q,$conn);
   $dbarray = mysql_fetch_array($result);
   mysql_close();
   return $dbarray;
}

?>
