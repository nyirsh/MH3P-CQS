<?
	$warnFile = "logs/warnings.log";
	$warnSpecialFile = "logs/specialwarnings.log";

	if ($isAuthorized)
	{
		$logaction = $_GET['log'];
		if ($logaction == "delete")
		{
			unlink($warnfile);
			$ShowPopup = true;
			$PopupTitle = "Admin » Logs";
			$PopupMessage = "Log file succesfully deleted.";
			require 'functions/logger.php';
			Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "Log File deleted.");
		}
		
		if ($logaction == "deletespecial")
		{
			if ($_SESSION["user_id"] == "1")
			{
				unlink($warnSpecialFile);
				$ShowPopup = true;
				$PopupTitle = "Admin » Special Logs";
				$PopupMessage = "Log file succesfully deleted.";
			}
			else
			{
				require 'functions/logger.php';
				Log_Special_Warn($_SERVER['REMOTE_ADDR']." ".$_SESSION['username'], "Special Log File delete attempt.");
			}
		}
	}
	else
		echo "You are not authorized to view this page.";
?>