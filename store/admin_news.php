<?php

function InsertNews($news)
{
	require 'config.php';
	
	// News Insertion
	if ($news != "")
	{
		mysql_connect($host, $name, $password);
		mysql_select_db($db);
		
		$news = mysql_real_escape_string($news);
		$lastUpdate = date("d/m");
		
		mysql_query("INSERT INTO store_news (text, lastupdate) VALUES ('".$news."', '".$lastUpdate."')");
		
		mysql_close();
	}
}

function NewsPage()
{
	require 'config.php';
	
	// News Page UI
	echo '<table><tr><td width="1000">';
	echo '<table border="0" cellspacing="1" cellpadding="4" class="tborder"><thead><tr><td class="thead"><strong>News</strong>';
	echo '</td></tr></thead><tbody><tr><td class="tcat">';
	
	mysql_connect($host, $name, $password);
	mysql_select_db($db);
	
	$newsResult = mysql_query("SELECT * FROM store_news ORDER BY id DESC");
	$newsCount = mysql_num_rows($newsResult);
	echo '<strong style="color: #FFF">All News</strong></td></tr>';
	echo '<tr><td class="trow1">';
	if($newsCount > 10)
	{
		$newsCount = 10;
	}
	
	for($i = 0; $i < $newsCount; $i++)
	{
		$currText = mysql_result($newsResult,$i,"text");
		$currText = str_replace("\'", "'", $currText);
		echo'<smalltext> - '.$currText.'</smalltext>';
		if ($i != ($newsCount -1))
		{
			echo '<br />';
		}
	}
	echo '</td></tr><tr><td class="tcat"><strong style="color: #FFF">Actions</strong></td></tr>';
	echo '<tr><td class="trow1"><form action="admin.php?action=news" method="post">';
	echo '<table border="0"><tr><td><strong style="color:#000">News: </strong></td><td width="500"><input type="text" name="news" size="90%" /></td>';
	echo '<td><input type="submit" value="Add" /></td></tr></table></form></td></tr></tbody></table></td></tr></table>';
	
	mysql_close();
}
?>