<?

	$newNode = $dom->createElement("div");
	$newNode->setAttribute("style", "margin-top: 5px;");
	
	$daUrl = "";
	$daTitle = "";
	$daDescription = "";
	$daTimes = "";
	
	if ($daNode->hasAttribute("url"))
	{
		$daUrl = $daNode->getAttribute("url");
		$daTitle = $daNode->nodeValue;
		
		if (($daTitle == null) || ($daTitle == ""))
		{
			$daTitle = "Download";
		}
		if ($daNode->hasAttribute("description"))
		{
			$daDescription = $daNode->getAttribute("description");
		}
		else
		{
			$daDescription = "-";
		}
		$daTimes = "External Link";
	}
	else
	{
		if ($daNode->hasAttribute("id"))
		{
			$daId = $daNode->getAttribute("id");
			$dwnQuery = "SELECT * FROM stor3_downloads WHERE download_id = ".$daId;
			
			$dwnResult = mysql_query($dwnQuery,$conn);
			if(!$dwnResult || (mysql_numrows($dwnResult) < 1))
			{
			}
			else
			{
				$dwnParams = mysql_fetch_array($dwnResult);
				
				$daUrl = "downloads/".$dwnParams[1];
				$daTitle = $dwnParams[2];
				$daDescription = $dwnParams[3];
				$daTimes = "Download count: ".$dwnParams[4];
			}
		}
	}
	
	if ($daUrl != "")
	{
		$imgDiv = $dom->createElement("div");
		$imgDiv->setAttribute("style", "float: left; margin-top: 3px;");
		$linkA = $dom->createElement("a");
		$linkA->setAttribute("href", $daUrl);
		$imgNode = $dom->createElement("img");
		$imgNode->setAttribute("src", "images/download.png");
		$linkA->appendChild($imgNode);
		$imgDiv->appendChild($linkA);
		$newNode->appendChild($imgDiv);
		
		$detailsDiv = $dom->createElement("div");
		$detailsDiv->setAttribute("style", "float: left; margin-bottom: 3px;");
		$spanNode = $dom->createElement("span", $daTitle);
		$spanNode->setAttribute("style", "font-weight: bold; color: #15ADFF;");
		$spanCountNode = $dom->createElement("span", $daTimes);
		$spanCountNode->setAttribute("style", "font-size: 0.8em;");
		$detailsDiv->appendChild($spanNode);
		$detailsDiv->appendChild($dom->createElement("br"));
		$detailsDiv->appendChild($dom->createTextNode($daDescription));
		$detailsDiv->appendChild($dom->createElement("br"));
		$detailsDiv->appendChild($spanCountNode);
		$newNode->appendChild($detailsDiv);
	}
	
?>