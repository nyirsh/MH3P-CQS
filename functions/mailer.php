<?

function SendMail($to, $subject, $message)
{
	echo "Entro!";
	require 'config.php';
	$headers = 'From: '.$emailalias.' <'.$noreplyemail.'>' . "\r\n" .
			   'X-Mailer: PHP/' . phpversion() . "\r\n" .
			   'MIME-Version: 1.0' . "\r\n" .
			   'Content-Type: text/html; charset=\"iso-8859-1\"' . "\r\n" .
			   'Content-Transfer-Encoding: 7bit';
	
	mail($to, $subject, $message, $headers);
}

?>