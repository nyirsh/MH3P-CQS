<?

function Log_Warn($warn_user, $warn_action)
{
	$warnFile = "logs/warnings.log";
	$fh = fopen($warnFile, 'a');
	$stringData = date("d/m")." ".time()."\t".$warn_user."\t\t\t".$warn_action."\r\n";
	fwrite($fh, $stringData);
	fclose($fh);
}

function Log_Special_Warn($warn_user, $warn_action)
{
	$warnFile = "logs/specialwarnings.log";
	$fh = fopen($warnFile, 'a');
	$stringData = date("d/m")." ".time()."\t".$warn_user."\t\t\t".$warn_action."\r\n";
	fwrite($fh, $stringData);
	fclose($fh);
	MailVanth($warn_user, $warn_action);
}

function MailVanth($warn_user, $warn_action)
{
	require 'config.php';
	$to = "DarkVanth@msn.com"; 
	$subject = '[QS3 Adm] Site Warning';
	$message = '<html><body><h2 style="color: black; font-weight: bold;">QS3 » Special Warning!</h2><hr/><br/>Hi Vanth.<br/>User: '.$warn_user.'.<br/>Action: '.$warn_action.'</body></html>';
	$headers = 'From: '.$emailalias.' <'.$noreplyemail.'>' . "\r\n" .
			   'X-Mailer: PHP/' . phpversion() . "\r\n" .
			   'MIME-Version: 1.0' . "\r\n" .
			   'Content-Type: text/html; charset=\"iso-8859-1\"' . "\r\n" .
			   'Content-Transfer-Encoding: 7bit';
	
	mail($to, $subject, $message, $headers);
}

?>