<?php
require 'psp_funcs.php';

CheckAgent();

$lastinfo = array();
$lastupdate = "";

require 'config.php';

mysql_connect($host, $name, $password);
mysql_select_db($db);

$newsResult = mysql_query("SELECT * FROM store_news ORDER BY id DESC");
$newsCount = mysql_num_rows($newsResult);

if($newsCount > 10)
{
	$newsCount = 10;
}

for($i = 0; $i < $newsCount; $i++)
{
	$currText = mysql_result($newsResult,$i,"text");
	$currText = str_replace("\'", "'", $currText);
	$lastinfo[] = ' - '.$currText;
	if ($i == 0)
	{
		$lastupdate = mysql_result($newsResult,$i,"lastupdate");
	}
}

mysql_close();

$infocount = count($lastinfo);

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<!--
	<GAME-STYLE>
		"MOUSE=OFF",
		"SCROLL=OFF",
		"TITLE=OFF",
		"BACK=ON:DL_SEL.php",
		"FORWARD=OFF",
		"CANCEL=OFF",
		"RELOAD=OFF",
		"CHOICE_MV=OFF",
		"LINK_U=OFF",
		"FRONT_LABEL=ON:1",
		"MOVE_CHAR=fpic://51.gif,57,71,7,,20,,403,137",
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,-48,-32",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30, 48,-64",
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,144,  0",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30,240,-32",
		"ASSEMBLE_BG=ON",
	</GAME-STYLE>
-->
<body text=white link=white vlink=white bgcolor=blue background=fpic://03.gif>
<basefont size=1>
<table width=480 height=250 cellspacing=0 cellpadding=0 border=0>
	<tr>
		<td width=224>
			<table width=224 height=250 cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td width=224 colspan=2>
						<img src=fpic://52.gif width=208 height=47 alt="Download Menu"><br>
					</td>
				</tr>
				<tr>
					<td>
						<table width=224 cellspacing=0 cellpadding=0>
							<form action="DL_SELECT.PHP" method=get>
                            <tr><td>
			 					<input type=image ANIME=20 src="img/menu_official.gif" name=submit width=224 height=47 alt="Official CQ">
                                <input type="hidden" name="official" value="1">
							</td></tr></form>
							<form action="DL_SELECT.PHP?official=0" method=get>
                            <tr><td>
			 					<input type=image ANIME=20 src="img/menu_public.gif" name=submit width=224 height=47 alt="Public CQ">
                                <input type="hidden" name="official" value="0">
							</td></tr> </form>
							<form action="DL_TOP.PHP" method=get>
                            <tr><td>
			 					<input type=image ANIME=20 src="img/menu_search.gif" name=submit width=224 height=47 alt="Search">
							</td></tr></form>
							<form action="credits.html">
                            <tr><td>
			 					<input type=image ANIME=20 src="img/credits_menu.gif" name=submit width=224 height=47 alt="Credits">
							</td></tr></form>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width=256 valign=top align=right>
			<table width=250 height=250 border=0 cellspacing=0 cellpadding=0 29 background=fpic://24.gif>
				<tr>
					<td valign=top height=37 colspan=2></td>
				</tr>
				<tr>
					<td width=15 height=143></td>
					<td width=235 valign=top>
            			<font color=#4682d8>Last Update:</font><?php echo " ".$lastupdate; ?><br>
                    	<br>
                        <?php
							for ($i = 0; $i < $infocount -1; $i++)
							{
								echo "<img height=16>".$lastinfo[$i]."<br>";
							}
							echo "<img height=16>".$lastinfo[$i];
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0><tr><td width=480 height=22><img ANIME=128 src=fpic://08.gif width=480 height=22></td></tr></table>
</body>
</html>