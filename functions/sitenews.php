<?

function PrintNews()
{
   require "./config.php";

   $conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
   mysql_select_db($dbdb, $conn) or die(mysql_error());
	
   $allnews = mysql_query("SELECT sn.id, sn.title, sn.text, sn.date, su.username FROM stor3_news AS sn INNER JOIN stor3_users AS su ON sn.user_id = su.user_id WHERE sn.type = 1 ORDER BY sn.id DESC LIMIT 3");
   $numnews = mysql_num_rows($allnews);

   $i=0;
   while (($i < $numnews)&&($i < 3))
   {
		$curr_title = mysql_result($allnews,$i,"title");
		$curr_text = mysql_result($allnews,$i,"text");

		$curr_text = str_replace("\r\n", "<br/>", $curr_text);
		$curr_text = str_replace("\n", "<br/>", $curr_text);
		$curr_text = str_replace("\r", "<br/>", $curr_text);
		$curr_text = "<p>".$curr_text."</p>";

		$curr_date = mysql_result($allnews,$i,"date");
		$curr_user = mysql_result($allnews,$i,"username");

		$file_content = implode("",file("./templates/newstable.html"));
		$file_content = eregi_replace("<!-- NEWSTITLE -->", $curr_title, $file_content);
		$file_content = eregi_replace("<!-- NEWSDATE -->", $curr_date, $file_content);
		$file_content = eregi_replace("<!-- NEWSUSER -->", $curr_user, $file_content);
		$file_content = eregi_replace("<!-- NEWSTEXT -->", $curr_text, $file_content);
		echo $file_content;
	
		$i++;
   }

   mysql_close();
}

?>