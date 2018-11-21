<?

	$newNode = $dom->createElement("div");
	$newNode->setAttribute("class", "spoiler");
    $newNode->appendChild($dom->createElement("span", "&#9658;"));
	if ($daNode->hasAttribute("title") == true)
	{
		$daTitle = $daNode->getAttribute("title");
	}
	else
	{
		$daTitle = "Spoiler";
	}
	$linkNode = $dom->createElement("a", $daTitle);
	$linkNode->setAttribute("onclick", "performSpoiler(this); return false");
	$newNode->appendChild($linkNode);
	$divNode = $dom->createElement("div", $daNode->nodeValue);
	$divNode->setAttribute("class", "inner toround");
	$divNode->setAttribute("style", "display:none;");
	$newNode->appendChild($divNode);
?>