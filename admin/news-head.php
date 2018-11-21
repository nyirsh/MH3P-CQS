<?

	if ($isAuthorized)
	{
		// Inserting News
		if ($_POST["formbutton"] == "Insert")
		{
			$news_type = $_POST['news_type'];
			if ($news_type != "1" && $news_type != "2")
			{
				$ShowPopup = true;
				$PopupTitle = "WTF are you trying to do?";
				$PopupMessage = "Very well, you have been logged my dear...";
				require 'functions/logger.php';
				Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "Invalid news type on inserting.");
			}
			else
			{
				$news_title = $_POST['news_title'];
				$news_text = $_POST['news_text'];
				
				if ($news_title == null || $news_type == "2")
					$news_title = "";
				if ($news_title == "" && $news_type == "1")
				{
					$ShowPopup = true;
					$PopupTitle = "Ehm...";
					$PopupMessage = "What kind of news has no title?";
				}
				else if ($news_text == null || $news_text == "")
				{
					$ShowPopup = true;
					$PopupTitle = "Ehm...";
					$PopupMessage = "What kind of news has no text?";
				}
				else
				{
					$news_date = date("d/m/Y");
					require "config.php";
			
					$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
					mysql_select_db($dbdb, $conn) or die(mysql_error());
					
					if(!get_magic_quotes_gpc())
					{
						$news_text = addslashes($news_text);
						$news_title = addslashes($news_title);
						$news_date = addslashes($news_date);
					}
					
					mysql_query("INSERT INTO stor3_news (title,text,date,user_id,type) VALUES ('".$news_title."', '".$news_text."', '".$news_date."', '".$_SESSION['user_id']."', ".$news_type.")",$conn);
				}
			}
		}
	
		// Deleting News
		if ($_POST["formbutton"] == "Delete")
		{
			$news_id = $_POST["news_id"];
			if ($news_id == null || $news_id == "")
			{
				$ShowPopup = true;
				$PopupTitle = "WTF are you trying to do?";
				$PopupMessage = "Very well, you have been logged my dear...";
				require 'functions/logger.php';
				Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "News id void or null.");
			}
			else
			{
				require "config.php";
			
				$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
				mysql_select_db($dbdb, $conn) or die(mysql_error());
				
				if(!get_magic_quotes_gpc())
				{
					$news_id = addslashes($news_id);
				}
				
				$result = mysql_query("SELECT * FROM stor3_news WHERE id = '".$news_id."'",$conn);
				if(mysql_numrows($result) > 0)
				{
					mysql_query("DELETE FROM stor3_news WHERE id = '".$news_id."'",$conn);
					$ShowPopup = true;
					$PopupTitle = "News or not news?";
					$PopupMessage = "The news was succesfully deleted.";
				}
				else
				{
					$ShowPopup = true;
					$PopupTitle = "WTF are you trying to do?";
					$PopupMessage = "Very well, you have been logged my dear...";
					require 'functions/logger.php';
					Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "News id changed on delete.");
				}
			
				mysql_close();
			}
		}
	
	
		// Getting News
		$allnews = array();
		
		require "config.php";
		
		$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
		mysql_select_db($dbdb, $conn) or die(mysql_error());
		$result = mysql_query("(SELECT sn.id, sn.title, sn.text, sn.date, su.username, sn.type FROM stor3_news AS sn INNER JOIN stor3_users AS su ON sn.user_id = su.user_id WHERE sn.type = 1 ORDER BY sn.id DESC LIMIT 3) UNION ALL (SELECT sn.id, sn.title, sn.text, sn.date, su.username, sn.type FROM stor3_news AS sn INNER JOIN stor3_users AS su ON sn.user_id = su.user_id WHERE sn.type = 2 ORDER BY sn.id DESC LIMIT 5)",$conn);
		if(mysql_numrows($result) > 0)
		{
			while($allnews[] = mysql_fetch_array($result)) { }
		}
		
		mysql_close();
	}
	else
		echo "You are not authorized to view this page.";
?>