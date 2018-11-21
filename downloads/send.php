<?

$file = isset($_GET['file']) ? trim($_GET['file']) : '';

if (!$file) {
    die("Error");
}

if ( substr_count($file, '..') > 0 or substr($file, 0, 1) == '/' ) {
    die("Invalid filename.");
}

$path = $file;
if ( !file_exists($path) ) {
    die("File not found: $file");
}

$ext = explode('.', $file);
if ( sizeof($ext) < 2 ) {
    die("Invalid filename: should have extension");
}

require "../config.php";
$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
mysql_select_db($dbdb, $conn) or die(mysql_error());

if(!get_magic_quotes_gpc())
{
	$file = addslashes($file);
}
mysql_query("UPDATE stor3_downloads SET download_count = download_count + 1 WHERE url = '".$file."'",$conn);
mysql_close();


$ext = $ext[sizeof($ext)-1];

switch ($ext) {
	case 'zip' :
		$type = 'application';
		break;
	
	case 'exe' :
		$type = 'application';
		break;

    default :
        $type = 'text/plain';
}

header("Content-type: $type");

$fd = fopen ($path, "rb");
$code = fread ($fd, filesize($path));
fclose ($fd);

echo $code;
?>