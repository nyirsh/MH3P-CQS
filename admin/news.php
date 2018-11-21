<?
	if ($isAuthorized)
	{
?>
<div class="table-styler shadow">
<table class="table-content">
<thead>
<tr>
  <td>
    <h1>QS3 | Administration Page</h1>
  </td>
</tr>
</thead>
<tbody>
<tr>
 <td class="table-subhead">
   <div id="tabmenucontainer">
     <ul class="tabmenumenu">
		<li id="tabP1" class="active">Site News</li>
		<li id="tabP2">Store News</li>
     </ul>
   </div>
 </td>
</tr>

<tr>
 <td class="table-row" style="padding-top: 5px;">
	<div class="tabmenucontent tabP1">
	<h2>~ Function » Site News Management</h2>
	<hr/>
	<div class="innerdiv toround">
		<table style="width: 100%">
			<tr style="border-bottom: 1px solid #AAA;">
				<td><b>Title</b></td>
				<td><b>Text</b></td>
				<td><b>Date</b></td>
				<td><b>Newser</b></td>
				<td></td>
			</tr>
			<?
				for ($index = 0; $index < (count($allnews) - 1); $index++)
				{
					if ($allnews[$index]["type"] == "1")
					{
						if ($index == (count($allnews) - 2))
							echo '<tr>';
						else
						{
							if ($index < (count($allnews) - 1))
							{
								if ($allnews[$index + 1]["type"] == "1")
									echo '<tr style="border-bottom: 1px solid black;">';
								else
									echo '<tr>';
							}
							else
								echo '<tr>';
						}
			?>
					<td style="vertical-align: top;"><? echo $allnews[$index]["title"]; ?></b></td>
					<td><? echo str_replace("\r", "<br/>", str_replace("\n", "<br/>", str_replace("\r\n", "<br/>", $allnews[$index]["text"]))); ?></td>
					<td style="vertical-align: top;"><? echo $allnews[$index]["date"]; ?></td>
					<td style="vertical-align: top;"><? echo $allnews[$index]["username"]; ?></td>
					<td style="vertical-align: top; text-align:right;"><form action="admin.php?p=news" method="post"><input type="hidden" name="news_id" value="<? echo $allnews[$index]["id"]; ?>" /><input type="submit" name="formbutton" value="Delete" /></form></td>
				<tr>
			<?
					}
				}
			?>
		</table>
	</div>
	<div class="spoiler">
	<span>&#9658;</span>
	<a onclick="performSpoiler(this); return false">Insert Site News</a>
	<div class="inner toround" style="display:none;">
	<form action="admin.php?p=news" method="post">
	<input type="hidden" name="news_type" value="1" />
		<table style="width:100%">
			<tr>
				<td><b>Title:</b></td>
				<td><input type="text" size="80" name="news_title" /><input type="submit" name="formbutton" value="Insert" style="float: right;" /></td>
			<tr>
			<tr>
				<td style="vertical-align:top;"><b>Text:</b></td>
				<td><textarea type="text" style="width:99%" rows="7" name="news_text"></textarea></td>
			<tr>
		</table>
	</form>
	</div>
	</div>
	</div>
	</div>
	
	<div class="tabmenucontent tabP2">
	<h2>~ Function » Store News Management</h2>
	<hr/>
	<div class="innerdiv toround">
		<table style="width: 100%">
			<tr style="border-bottom: 1px solid #AAA;">
				<td><b>Text</b></td>
				<td><b>Date</b></td>
				<td><b>Newser</b></td>
				<td></td>
			</tr>
			<?
				for ($index = 0; $index < (count($allnews) - 1); $index++)
				{
					if ($allnews[$index]["type"] == "2")
					{
						if ($index == (count($allnews) - 2))
							echo '<tr>';
						else
						{
							if ($index < (count($allnews) - 1))
							{
								if ($allnews[$index + 1]["type"] == "2")
									echo '<tr style="border-bottom: 1px solid black;">';
								else
									echo '<tr>';
							}
							else
								echo '<tr>';
						}
			?>
					<td><? echo $allnews[$index]["text"]; ?></td>
					<td><? echo $allnews[$index]["date"]; ?></td>
					<td><? echo $allnews[$index]["username"]; ?></td>
					<td style="text-align:right;"><form action="admin.php?p=news" method="post"><input type="hidden" name="news_id" value="<? echo $allnews[$index]["id"]; ?>" /><input type="submit" name="formbutton" value="Delete" /></form></td>
				<tr>
			<?
					}
				}
			?>
		</table>
	</div>
	<div class="spoiler">
	<span>&#9658;</span>
	<a onclick="performSpoiler(this); return false">Insert Store News</a>
	<div class="inner toround" style="display:none;">
	<form action="admin.php?p=news" method="post">
	<input type="hidden" name="news_type" value="2" />
		<table style="width:100%">
			<tr>
				<td><b>Text:</b></td>
				<td><input type="text" style="width: 100%;" name="news_text" /></td>
			<tr>
			<tr>
				<td colspan="2"><i>Remember to don't insert a news with too much characters or the store will be altered!</i><input type="submit" name="formbutton" value="Insert" style="float: right;" /></td>
			</tr>
		</table>
	</form>
	</div>
	</div>
	</div>
 </td>
</tr>
</tbody>
</table>
</div>
<?
	}
	else
		echo "You are not authorized to view this page.";
?>