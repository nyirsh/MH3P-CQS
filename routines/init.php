<?

session_start();
$_SESSION['LastPage'] = $_SERVER['PHP_SELF'];

if(top.mainFrame==null)
{
   window.open("/","_top");
}

?>