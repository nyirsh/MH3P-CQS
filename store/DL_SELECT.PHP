<?php
require 'psp_funcs.php';

CheckAgent();

$official = $_GET['official'];

require 'config.php';

mysql_connect($host, $name, $password);
mysql_select_db($db);


// Calcolo delle pagine
$totalQuestsResult = mysql_query("SELECT COUNT(id) FROM store_quests WHERE isOfficial = '".$official."'");
$tot_quests = mysql_result($totalQuestsResult,0,0);

$pages = (int)($tot_quests / 7);
if (($tot_quests % 7) != 0)
{
	$pages++;
}

// Calcolo delle pagine successive
$currPage = $_GET['pg_no'];
if ($currPage < 1)
{
	$currPage = 0;
}

$leftPage = 0;
$rightPage = 0;

if ($pages > 1)
{
	if ($currPage == 0)
	{
		$leftPage = $pages - 1;
	}
	else
	{
		$leftPage = $currPage - 1;
	}
	
	$pages--;
	
	if ($currPage == $pages)
	{
		$rightPage = 0;
	}
	else
	{
		$rightPage = $currPage + 1;
	}
	
	$pages++;
}

?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
</head>
<!--
	<GAME-STYLE>
		"MOUSE=OFF",
		"SCROLL=OFF",
		"TITLE=OFF",
		"BACK=ON:DL_TOP.PHP",
		"FORWARD=OFF",
		"CANCEL=OFF",
		"RELOAD=OFF",
		"CHOICE_MV=OFF",
		"LINK_U=OFF",
		"FRONT_LABEL=ON:2",
        <?php
		echo "\"LB_LINK=DL_SELECT.PHP?pg_no=".$leftPage."&official=".$official."\",\r\n";
		echo "\"RB_LINK=DL_SELECT.PHP?pg_no=".$rightPage."&official=".$official."\",\r\n";
		?>
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,-48,-32",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30, 48,-64",
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,144,  0",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30,240,-32",
		"ASSEMBLE_BG=ON",
	</GAME-STYLE>
-->
<body text=#393025 link=white vlink=white bgcolor=brown background=fpic://03.gif>
<basefont size=1>
<?php
// Calcolo dei LIMIT
$minLimit = 0 + (7 * $currPage);
$maxLimit = 7 + (7 * $currPage);

$questResult = mysql_query("SELECT * FROM store_quests WHERE isOfficial = '".$official."' ORDER BY id DESC LIMIT ".$minLimit.",".$maxLimit);
$questCount = mysql_num_rows($questResult);

$currQuestList = array();
for ($k = 0; $k < $questCount; $k++)
{
	$currQuestList[$k] = mysql_result($questResult,$k,"name");
}

$i = 0;
while ($i < $questCount)
{
	// First Quest Part
	$j = $i +1;
	if ($j < 10)
	{
		echo '<!-- ########  0'.$j.'  1/2 ######## -->';
	}
	else
	{
		echo '<!-- ########  '.$j.'  1/2 ######## -->';
	}
	
	if ($i < 10)
	{
		echo '<a name=00'.$j.'></a>';
	}
	else if ($i < 100)
	{
		echo '<a name=0'.$j.'></a>';
	}
	else
	{
		echo '<a name='.$j.'></a>';
	}
	
 	if ($official == 1)
	{
		$imgUrl = "img/OfficialQuests.gif";
	}
	else
	{
		$imgUrl = "img/UnofficialQuests.gif";
	}
	echo '<img ANIME=129 src="'.$imgUrl.'" width=208 height=47 alt="Quests"><br>';
	echo '<table width=480 height=203 cellspacing=0><tr><td width=230 height=203 align=center>';
	echo '<table width=226 height=139 border=0 cellspacing=0 background=fpic://41.gif><tr><td align=center><table width=212 cellspacing=0>';
	
	$currCSUM = mysql_result($questResult,$i,"csum");
	$currFSIZE = mysql_result($questResult,$i,"filesize");
	$currFNAME = mysql_result($questResult,$i,"filename");
	
	if ($official == 1)
	{
		echo '<form action="QUEST/'.$currFNAME.'" DOWNLOAD CSUM='.$currCSUM.' FSIZE='.$currFSIZE.' method=post>';
	}
	else
	{
		echo '<form action="UNOFFICIAL/'.$currFNAME.'" DOWNLOAD CSUM='.$currCSUM.' FSIZE='.$currFSIZE.' method=post>';
	}
	echo '<tr><td width=212 height=15 align=center><table width=92 cellspacing=0 background=fpic://42.gif>';
	echo '<tr><td height=15 align=center valign=bottom><font color=white>'.($currPage + 1).'/'.$pages.'</font></table><tr>';
	
	$needToGroup = true;
	for ($k = 0; $k < $questCount; $k++)
	{
		if ($k == $i)
		{
			if ($k != 0)
			{
				echo '<tr><td bgcolor=green>';
			}
			else
			{
				echo '<td bgcolor=green>';
			}
			$needToGroup = true;
		}
		else
		{
			if ($needToGroup)
			{
				echo '<td>';
				$needToGroup = false;
			}
		}
		
		$currQName = mysql_result($questResult,$k,"name");
		$currFNAME = str_replace('.mib', '', $currFNAME);
		
		
		echo '<img ANIME=30 src=fpic://45.gif width=14 height=16><a href=#00'.($k+1).' qname='.$currFNAME.'>'.$currQName.'</a><BR><img height=1><BR>';
		if ($k == $i)
		{
			if (($k != ($questCount -1)))
			{
				echo '<tr>';
			}
		}
	}
	
	if ($questCount < 7)
	{
		echo '<tr><td>';
		for ($k = $questCount; $k < 6; $k++)
		{
			echo '<BR>';
		}
	}
	
	$currQName = mysql_result($questResult,$i,"name");
	echo '<input type=image src="" name=submit width=0 height=0></tr></form></table></td></tr></table>';
	echo '</td><td width=250><table width=248 height=197 cellspacing=0 cellpadding=0 background=fpic://34.gif><tr>';
	echo '<td width=248 height=44 align=center valign=bottom colspan=3><img width=10>'.$currQName.'</td>';
	
	echo '</tr><tr><td width=38></td><td width=182><table width=182 cellspacing=0><tr><td height=123 valign=top>';
	
	$currMoney = mysql_result($questResult,$i,"money");
	$currFee = mysql_result($questResult,$i,"fee");
	$currTime = mysql_result($questResult,$i,"time");
	$currMonsters = mysql_result($questResult,$i,"monsters");
	$currCondition = mysql_result($questResult,$i,"condition");
	
	$currUID = mysql_result($questResult,$i,"user_id");
	
	$currUserResult = mysql_query("SELECT * FROM mybb_users WHERE uid = '".$currUID."'");
	$currCreator = mysql_result($currUserResult,0,"username");
	
	echo '<img height=21><font color=#1D3C8D>Money </font>'.$currMoney.'z<br>';
	echo '<img height=16><font color=#1D3C8D>Fee </font>'.$currFee.'z<br>';
	echo '<img height=16><font color=#1D3C8D>Time </font>'.$currTime.'m<br>';
	echo '<img height=16><font color=#1D3C8D>Monsters </font>'.$currMonsters.'<br>';
	echo '<img height=16><font color=#1D3C8D>Condition</font><br>';
	echo '<img height=16>'.$currCondition.'<BR>Created by '.$currCreator.'<BR>';
	
	echo '</td></tr></table></td><td width=21></td></tr></table></td></tr></table>';
	echo '<table cellspacing=0 cellpadding=0><tr><td width=480 height=22><img ANIME=129 src=fpic://08.gif width=480 height=22></td></tr></table>';

	// Second Part
	if ($i < 10)
	{
		echo '<!-- ########  0'.$i.'  2/2 ######## -->';
	}
	else
	{
		echo '<!-- ########  '.$i.'  2/2 ######## -->';
	}
	
	echo '<img ANIME=129 src="'.$imgUrl.'" width=208 height=47 alt="Quests"><br>';
	echo '<table width=480 cellspacing=0><tr><td width=5></td><td width=475 height=203 align=center><table width=472 height=197 cellpadding=0 cellspacing=0 border=0>';
	echo '<tr>';
	echo '<td width=236 height=197 background=fpic://35.gif><TABLE width=233 cellspacing=0 cellpadding=0><tr>';
	echo '<td width=22></td><td height=44 align=center valign=bottom >'.$currQName.'</td><td width=4></td></tr><tr>';
	
	$currMap = mysql_result($questResult,$i,"map");
	echo '<td width=22 height=153 ></td><TD width=210 valign=top><img height=20><font color=#1D3C8D>　Map</font><br><img height=16>'.$currMap.'<BR><BR><BR>';
	
	$currMonsters = str_replace(',', '<BR>', $currMonsters);
	$currMonsters = str_replace('<BR> ', '<BR>', $currMonsters);
	echo '<img height=16><font color=#1D3C8D>　Monsters</font><br><img height=16>'.$currMonsters.'<BR>';
	echo '</TD><td width=4></td></tr></TABLE></td><td width=236 background=fpic://57.gif><TABLE cellspacing=0 cellpadding=0>';
	echo '<tr><td height=45 align=center valign=bottom colspan=3>';
	
	$currLv = mysql_result($questResult,$i,"difficulty");
	echo '<font color=#1D3C8D>LV</font><font color=#AB001C>';
	
	$x = 0;
	while ($x < $currLv)
	{
		echo '★';
		$x++;
	}
	echo '</font><BR></td></tr><tr><td width=10 height=152 ></td><TD width=210 valign=top>';
	echo '<img height=20><font color=#1D3C8D>　Conditions　</font>'.$currCondition.'<BR>';
	echo '<img height=16><font color=#1D3C8D>　Description</font><BR>';
	
	$currDescription = mysql_result($questResult,$i,"description");
	$currDescription = str_replace("\n", "<BR>", $currDescription);
	
	echo '<img height=16>'.$currDescription.'<BR></TD>';
	echo '<td width=16></td></tr></TABLE></td></tr></table></td></tr></table>';
	echo '<table cellspacing=0 cellpadding=0><tr><td width=480 height=22><img ANIME=130 src=fpic://08.gif width=480 height=22></td></tr></table>';
	echo "\n";
	// END
    $i++;	
}

mysql_close();

?>

</body>
</html>