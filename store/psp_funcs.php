<?php

function CheckAgent()
{
	$realAgent = "Capcom Portable Browser v1.4 for MonsterHunterPortable3rd";
	$currAgent = $_SERVER['HTTP_USER_AGENT'];
	
	if ($realAgent != $currAgent)
	{
		echo "You are not allowed to access this page";
		exit;
	}
}

?>