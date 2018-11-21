<?

// Print the lateral menu
$file_content = implode("",file("templates/panel-menu.html"));

if (file_exists("templates/panel-menu-".$_SESSION['GroupName'].".html"))
{
	$file_content = eregi_replace("<!-- SPECIALMENU -->", implode("", file("templates/panel-menu-".$_SESSION['GroupName'].".html")), $file_content);
}
echo $file_content;


if($ShowPopup)
{
   $file_content = implode("",file("templates/popup-base.html"));
   $file_content = eregi_replace("<!-- ERRORTITLE -->", $PopupTitle, $file_content);
   $file_content = eregi_replace("<!-- ERRORMESSAGE -->", $PopupMessage, $file_content);
   $file_content = eregi_replace("<!-- ERRORBACK -->", implode("",file("templates/popup-back.html")), $file_content);
   echo $file_content;
}

if (!$isLogged)
{
    $file_content = implode("",file("templates/panel-login.html"));
}
else
{
    if ($isBanned)
    {
        $file_content = implode("",file("templates/panel-banned.html"));
		$file_content = eregi_replace("<!-- BANNER -->", $banResult['username'], $file_content);
		$file_content = eregi_replace("<!-- BANMESSAGE -->", "<br/>".$banResult['message'], $file_content);
		$file_content = eregi_replace("<!-- USERNAME -->", $_SESSION['username'], $file_content);
        $file_content = eregi_replace("<!-- USERGROUP -->", $_SESSION['GroupName'], $file_content);
    }
	else
	{
		$file_content = implode("",file("templates/panel-personal.html"));
		$file_content = eregi_replace("<!-- USERNAME -->", $_SESSION['username'] , $file_content);
		$file_content = eregi_replace("<!-- USERGROUP -->", $_SESSION['GroupName'] , $file_content);
		$file_content = eregi_replace("<!-- QUESTSPACE -->", $_SESSION['QuestSpace'] , $file_content);
	}
}
$file_content = eregi_replace("<!-- SELFPAGE -->", $HTTP_SERVER_VARS[PHP_SELF], $file_content);
echo $file_content;

?>