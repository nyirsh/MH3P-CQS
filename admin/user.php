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
   <p>~ Function » User Management</span></p>
 </td>
</tr>
<tr>
 <td class="table-row" style="padding-top: 5px;">
	<form method="post" action="admin.php?p=user">
		<center>
		<table style="width: 90%;">
			<tr style="border-bottom: 1px solid white;">
				<td colspan="7">Search for user</td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username" value="<? echo $_POST['username']; ?>" /></td>
				<td>Email:</td>
				<td><input type="text" name="email" value="<? echo $_POST['email']; ?>" /></td>
				<td>Group:</td>
				<td>
					<select name="group">
						<option value=""></option>
						<option value="0" <? if ($_POST['group'] == "0") echo "selected"; ?>>Administrator</option>
						<option value="1" <? if ($_POST['group'] == "1") echo "selected"; ?>>Normal User</option>
						<option value="2" <? if ($_POST['group'] == "2") echo "selected"; ?>>Store Moderator</option>
						<option value="-1" <? if ($_POST['group'] == "-1") echo "selected"; ?>>Banned</option>
					</select>
				</td>
				<td><input type="submit" name="searchbutton" value="Search" /></td>
		</table>
		</center>
	</form>
	
	<?
	
		if($isValidSearch == true)
		{
			?>
			<hr/>
			<div class="innerdiv toround">
			<?
			if (count($searchresults) == 0)
			{
				echo "<center>No results was found.</center>";
			}
			else
			{
				?>
				<table style="width: 100%;">
				<tr style="border-bottom: 1px solid #AAA;">
					<td><b>UID</b></td>
					<td><b>Username</b></td>
					<td><b>Email</b></td>
					<td><b>Group</b></td>
					<td><b>Quest Space</b></td>
					<td>
				</tr>
				<?
				for ($index = 0; $index < (count($searchresults) - 1); $index++)
				{
					if ($index == (count($searchresults) - 2))
						echo '<tr>';
					else
						echo '<tr style="border-bottom: 1px solid black;">';
					$questspace = $searchresults[$index][5];
					if ($questspace == "-1")
						$questspace = "Unlimited";
					echo "<td>".$searchresults[$index][0]."</td><td>".$searchresults[$index][1]."</td><td>".$searchresults[$index][3]."</td><td>".$searchresults[$index][7]."</td><td>".$questspace."</td>";
					
					// Prevents to edit master account
					if ($searchresults[$index][0] != "1")
					{
						echo '<td style="text-align: right;"><form action="admin.php?p=user" method="POST"><input type="hidden" name="user_id" value="'.$searchresults[$index][0].'" /><input type="submit" name="formbutton" value="View" />';
						if ($searchresults[$index][4] == "-1")
							echo '<input type="submit" name="formbutton" value="Unban" />';
						echo '</td></form>';
					}
					echo "</tr>";
				}
				?>
				</table>
				<?
			}
			?>
			</div>
			<?
		}
	?>
	<?
		if ($pageviewmode == "viewuser")
		{
		?>
		<hr/>
		<div class="innerdiv toround">
		<table style="width: 100%">
		<tr>
			<td><b>Username:</b></td>
			<td><? echo $userresult[1]; ?></td>
			<td><b>User ID:</b></td>
			<td><? echo $userresult[0]; ?></td>
		</tr>
		<tr>
			<td><b>Email:</b></td>
			<td>
				<form action="admin.php?p=user" method="post">
					<input type="hidden" name="user_id" value="<? echo $user_id; ?>" />
					<input type="text" name="email" value="<? echo $userresult[3]; ?>" size="50" />
					<input type="submit" name="formbutton" value="Change Email" />
				</form>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td>
				<form action="admin.php?p=user" method="post">
					<input type="hidden" name="user_id" value="<? echo $user_id; ?>" />
					<input type="password" name="password" size="50" />
					<input type="submit" name="formbutton" value="Change Password" />
				</form>
			</td>
			<td></td>
			<td></td>
		</tr>
		
		<form action="admin.php?p=user" method="post">
		<input type="hidden" name="user_id" value="<? echo $user_id; ?>" />
		<tr>
			<td><b>User Group:</b></td>
			<td>
				
				<?
					if ($userresult["group_id"] == "-1")
					{
					?>
						Banned <input type="submit" name="formbutton" value="Unban" />
					<?
					}
					else
					{
					?>
					<select name="group" id="usergrouplist" onchange="checkForBanned()">
						<option value="0" <? if ($userresult["group_id"] == "0") echo "selected"; ?>>Administrator</option>
						<option value="1" <? if ($userresult["group_id"] == "1") echo "selected"; ?>>Normal User</option>
						<option value="2" <? if ($userresult["group_id"] == "2") echo "selected"; ?>>Store Moderator</option>
						<option value="-1">Banned</option>
					</select>
					<input type="submit" name="formbutton" value="Change Group" />
					<?
					}
					?>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr style="display: none;" id="banexprow">
			<td style="vertical-align: top"><b>Explaination:</b></td>
			<td><textarea rows="5" cols="50" name="banexp"></textarea></td>
			<td></td>
			<td></td>
		</tr>
		</form>
		<tr>
			<form action="admin.php?p=user" method="post">
			<td><b>Quest Space:</b></td>
			<td><input type="text" size="14" name="userspace" value="<? echo $userresult["quest_space"]; ?>" style="margin-right: 7px;" /><input type="submit" name="formbutton" value="Change Space" /></td>
			<td><input type="hidden" name="user_id" value="<? echo $user_id; ?>" /></td>
			</form>
			<td style="text-align: right;"><form action="admin.php?p=user" method="post"><input type="submit" name="formbutton" value="Back" /></form></td>
		</tr>
		</form>
		</div>
		<?
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