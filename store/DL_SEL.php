<?php
require 'psp_funcs.php';

CheckAgent();
?>
<html>
<!--
	<GAME-STYLE>
		"MOUSE=OFF",
		"SCROLL=OFF",
		"TITLE=OFF",
		"BACK=OFF",
		"FORWARD=OFF",
		"CANCEL=OFF",
		"RELOAD=OFF",
		"CHOICE_MV=OFF",
		"LINK_U=OFF",
		"FRONT_LABEL=ON:6",
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,-48,-32",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30, 48,-64",
		"MOVE_CHAR=fpic://44.gif,56,56,6,70,10,30,144,  0",
		"MOVE_CHAR=fpic://43.gif,64,64,6,80,11,30,240,-32",
		"ASSEMBLE_BG=ON",
	</GAME-STYLE>
-->
<body text=white link=white vlink=white bgcolor=blue background=fpic://03.gif>
<basefont size=1>
<B>
<img src="img/store_selection.gif" width=231 height=47 alt="Store Selection"><br>
<table width=480 height=203 cellspacing=0 cellpadding=0 border=0>
<tr>
	<form action="DL_TOP.PHP">
	<td width=240 height=196 align=center valign=center>
		<input ANIME=1 type=image src="img/store_cqw.gif" name=submit width=189 height=161 alt="CQW Store">
	</td>

	</form>
	<form action="http://crusader.capcom.co.jp/psp/MHP3rd/DL_TOP.PHP">
	<td width=240 height=196 align=center valign=center>
		<input ANIME=1 type=image src="img/store_official.gif" name=submit width=189 height=161 alt="Capcom Store">
	</td>
	</form>
</tr>
</table>
<table cellspacing=0 cellpadding=0 ><tr><td width=480 height=22 background=fpic://07.gif></td></tr></table>
</body>
</html>
