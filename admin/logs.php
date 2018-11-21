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
   <p>~ Function » Logs</span></p>
 </td>
</tr>
<tr>
 <td class="table-row" style="padding-top: 5px;">
	<? echo $_SESSION['username']; ?>, welcome to the QS3 Administration Page.<br/>
	You can manage warning logs from here.
	<hr/>
	<?
		if (file_exists($warnFile))
		{
		   echo '<smalltext>Anomalies detected. Please <a href="'.$warnFile.'" target="_blank">read</a> the log or <a href="admin.php?log=delete">delete</a> it.</smalltext>';
		}
		else
		{
			echo '<smalltext>No warning messages.</smalltext>';
		}
		
		if ($_SESSION['user_id'] == "1")
		{
			echo "<hr/>";
			$warnFile = "logs/specialwarnings.log";
			if (file_exists($warnFile))
			{
			   echo '<smalltext>Anomalies detected. Please <a href="'.$warnFile.'" target="_blank">read</a> the log or <a href="admin.php?log=deletespecial">delete</a> it.</smalltext>';
			}
			else
			{
				echo '<smalltext>No special warning messages.</smalltext>';
			}
		}
	?>
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