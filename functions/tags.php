<?

function evaluateSpecialTags($daHtml)
{
error_reporting(0);

	$dom = new DOMDocument;
	$dom->loadHTML($daHtml);
	
	require './config.php';
	
	$conn = mysql_connect($dbhost, $dbname, $dbpassword) or die(mysql_error());
    mysql_select_db($dbdb, $conn) or die(mysql_error());
	
    $q = "SELECT * FROM stor3_tags";
    $result = mysql_query($q,$conn);
    if(!$result || (mysql_numrows($result) < 1))
    {
       return $daHtml;
    }
	
	while($tag = mysql_fetch_array($result))
	{
		$currTagName = $tag[0];
		$currTagRoutine = $tag[1];
		
		$allNodes = $dom->getElementsByTagName($currTagName);
		
		while($allNodes->length > 0)
		{
			$daNode = $allNodes->item(0);
			include 'tags/'.$currTagRoutine;
			$daNode->parentNode->replaceChild($newNode, $daNode);
		}
	}
	
	mysql_close();
	$daHtml = $dom->saveHTML();
	$daHtml = preg_replace('/(&)(amp;)([a-zA-Z]+;)/', '$1$3', $daHtml);
	return $daHtml;
}

?>