<?php
function HomePage($username, $isAdmin)
{
	echo '<table><tr><td width="1000">';
	echo '<table border="0" cellspacing="1" cellpadding="4" class="tborder"><thead><tr><td class="thead"><strong>Home</strong>';
	echo '</td></tr></thead><tbody><tr><td class="trow1">';
	echo '<div align="center">';
	echo '<strong>'.$username.', welcome to the Custom Quest World Store Administration Page</strong>';
	
	if ($isAdmin)
	{
		echo '<br />';
		AdminHomePage();
	}
	
	echo '</div>';
	echo '</td></tr></tbody></table>';
}

function AdminHomePage()
{
	if (file_exists("warnings.txt"))
	{
	   echo '<smalltext>Anomalies detected. Please <a href="warnings.txt" target="_blank">read</a> the log or <a href="admin.php?log=delete">delete</a> it.</smalltext>';
	}
	else
	{
		echo '<smalltext>No warning messages.</smalltext>';
	}
}

function Warn($warn_user, $warn_action)
{
	$warnFile = "warnings.txt";
	$fh = fopen($warnFile, 'a');
	$stringData = "User: ".$warn_user."\t\tAction: ".$warn_action."\t\tDate Time:".date("d/m")." ".time()."\r\n";
	fwrite($fh, $stringData);
	fclose($fh);
}

function DeleteWarningLog()
{
	unlink("warnings.txt");
}

?>