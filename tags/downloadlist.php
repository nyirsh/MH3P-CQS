<?
	
	$newNode = $dom->createElement("div");
	if($daNode->hasAttribute("style"))
	{
		$daStyle = $daNode->getAttribute("style");
	}
	else
	{
		$daStyle = "default";
	}
	$newNode->setAttribute("class", "downloadlist-".$daStyle);
	$ulNode = $dom->createElement("ul");
	$brNode = $dom->createElement("br");
	$brNode->setAttribute("style", "clear: both");

	$dwnNodes = $daNode->getElementsByTagName("download");
	while($dwnNodes->length > 0)
	{
		$dwnNode = $dwnNodes->item(0);
		$liNode = $dom->createElement("li");
		$liNode->appendChild($dwnNode->cloneNode(true));
		$dwnNode->parentNode->removeChild($dwnNode);
		$ulNode->appendChild($liNode);
		$ulNode->appendChild($brNode->cloneNode(true));
	}
	$newNode->appendChild($ulNode);

?>