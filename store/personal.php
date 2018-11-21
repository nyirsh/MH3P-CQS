<?php
session_start();

require 'store_funcs.php';
require 'config.php';	

if ( (!isset($_SESSION['Connected']))||(isset($_SESSION['Guest'])))
{
	header('Location: index.php');
}

// Getting quest datas
if ($page_action == 'delete')
{
	$del_id =  $_POST['quest_id'];
	if ($del_id != null)
	{
		mysql_connect($host, $name, $password);
		mysql_select_db($db);
		
		mysql_query("DELETE FROM store_quests WHERE filename='".$del_id."' AND user_id = '".$_SESSION['Uid']."'");
					
		mysql_close();
		
		$target_path = "UNOFFICIAL/".$del_id;
		$target_path_store = "QUEST/".$del_id;
		
		if (file_exists($target_path))
		{
			unlink($target_path);
		}
		
		if (file_exists($target_path_store))
		{
			unlink($target_path_store);
		}
		
		$del_error = '';
	}
	else
	{
		$del_error = 'You don\'t have the rights to delete that quest.';
		Warn($_SESSION['User'], "UnvalidQuestDelete");
	}
}

if ($page_action == 'upload')
{
	$file_name = $_FILES['upfile']['name'];
	$isOfficial = $_POST['isOfficialQuest'];
	
	if (substr($file_name, -4) == '.cqs')
	{
		$fs = fopen($_FILES['upfile']['tmp_name'], "rb");
		$totsize = filesize($_FILES['upfile']['tmp_name']);
		
		$b = fread($fs, 4);
		$num = unpack("i", $b);
		$bytex = $num[1];
		$bytex -= 4;
		
		$infos = fread($fs, $bytex);
		$bytex += 4;
		$quest = fread($fs, ($totsize - $bytex));
		fclose($fs);
		
		$splittedInfo = explode("<!info!>", $infos);
		
		$quest_id = $splittedInfo[1];
		$quest_name = $splittedInfo[2];
		$quest_money = $splittedInfo[3];
		$quest_fee = $splittedInfo[4];
		$quest_map = $splittedInfo[5];
		$quest_monsters = $splittedInfo[6];
		$quest_description = $splittedInfo[7];
		$quest_difficulty = $splittedInfo[8];
		$quest_time = $splittedInfo[9];
		$quest_condition = $splittedInfo[10];
		$quest_lang = $splittedInfo[11];
		
		if (($quest_name != '')&&($quest_money != '')&&($quest_fee != '')&&($quest_map != '')&&($quest_monsters != '')&&($quest_description != '')&&($quest_difficulty != '')&&($quest_time != '')&&($quest_condition != '')&&($quest_lang != '')&&($quest_id != ''))
		{
			$target_path = "UNOFFICIAL/m".$quest_id.".mib";
			$target_path_store = "QUEST/m".$quest_id.".mib";
			
			if ((!file_exists($target_path))&&(!file_exists($target_path_store)))
			{
				if ($isOfficial == 'chkd')
				{
					$qf = fopen($target_path_store, "wb");
					fwrite($qf, $quest);
					fclose($qf);
					$file_size = filesize ($target_path_store);
					$file_csum = DCSUM($target_path_store);
				}
				else
				{
					$qf = fopen($target_path, "wb");
					fwrite($qf, $quest);
					fclose($qf);
					$file_size = filesize ($target_path);
					$file_csum = DCSUM($target_path);
				}
				
				// Update Database
				$isOfficial = '0';
				if ($isOfficial == 'chkd')
				{
					$isOfficial = '1';
				}
				
				$file_name = "m".$quest_id.".mib";
				
				mysql_connect($host, $name, $password);
				mysql_select_db($db);
				
				$quest_name = mysql_real_escape_string($quest_name);
				$quest_description = mysql_real_escape_string($quest_description);
				
				$query = "INSERT INTO store_quests (`name`, `money`, `fee`, `map`, `monsters`, `description`, `csum`, `filename`, `lang`, `user_id`, `difficulty`, `time`, `condition`, `filesize`, `isOfficial`) VALUES ('".$quest_name."', '".$quest_money."', '".$quest_fee."', '".$quest_map."', '".$quest_monsters."', '".$quest_description."', '".$file_csum."', '".$file_name."', '".$quest_lang."', '".$_SESSION['Uid']."', '".$quest_difficulty."', '".$quest_time."', '".$quest_condition."', '".$file_size."', '".$isOfficial."');";
			
				
				mysql_query($query);
				
				mysql_close();
			}
			else
			{
				$file_error = 'This quest id is already in use. Please use an another id.';
			}
		}
		else
		{
			$file_error = 'The uploaded file is corrupted.';
		}
	}
	else
	{
		$file_error = 'This file format is not supported. You can only upload ".cqs" files.';
	}
}
	

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Custom Quest World</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script type="text/javascript" src="http://customquestworld.site88.net/forum/jscripts/prototype.js?ver=1600"></script>
	<script type="text/javascript" src="http://customquestworld.site88.net/forum/jscripts/general.js?ver=1600"></script>

    <link type="text/css" rel="stylesheet" href="http://customquestworld.site88.net/forum/cache/themes/theme2/global.css" />
</head>
<body>
<div id="container">
	<a name="top" id="top"></a>
	<div id="header">
		<div id="logo">
			<a href="index.php"><img src="../forum/images/Logo.png" alt="Custom Quest World" title="Custom Quest World" /></a>
		</div>
	<div id="submenu">
		<div id="submenu_left">
			<strong>
				<a href="../index.php">Index</a> |
				<a href="../forum" target="_top">Forum</a> |
				<a href="../downloads" target="_top">Downloads</a> |
				<a href="index.php" target="_top">Store</a>
			</strong>
		</div>
	</div>
</div>
<br />
<div align="center">
<table width="100%" style="vertical-align: top">
	<tr>
    	<td style="vertical-align: top">
			<?php
            if (isset($_SESSION['Connected']))
            {
                Links(isset($_SESSION['Guest']), (isset($_SESSION['Storer'])||isset($_SESSION['Admin'])));
            }
            ?>
        </td>
        <td style="vertical-align: top" width="100%">
        <?php
			// Gestione Messaggi Upload
			if ($page_action == 'upload')
			{
				$upload_title = "Upload Result";
				if ($file_error != '')
				{
					$upload_title = "Upload Error";
				}
				
				echo '<table width="70%" class="tborder"><thead><tr><td class="thead"><strong>'.$upload_title.'</strong></td></tr></thead>';
				echo '<tbody><tr><td class="trow1"><div align="center"><strong><br />';
				
				if ($file_error != '')
				{
					echo $file_error;
				}
				else
				{
					echo 'Upload Successful!';
				}
				
				echo '</strong></div><br /></td></tr></tbody></table><br />';
			}
			// Gestione Messaggi
			if ($page_action == 'delete')
			{
				$upload_title = "Quest Delete";
				if ($file_error != '')
				{
					$upload_title = "Quest Delete Error";
				}
				
				echo '<table width="70%" class="tborder"><thead><tr><td class="thead"><strong>'.$upload_title.'</strong></td></tr></thead>';
				echo '<tbody><tr><td class="trow1"><div align="center"><strong><br />';
				
				if ($del_error != '')
				{
					echo $del_error;
				}
				else
				{
					echo 'Upload Successful!';
				}
				
				echo '</strong></div><br /></td></tr></tbody></table><br />';
			}
		?>
        <!-- Your Quests -->
        <table width="70%" class="tborder">
                <thead>
                <tr>
                    <td class="thead"><strong>Your Quests</strong></td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="trow1">
                        <?php
							mysql_connect($host, $name, $password);
							mysql_select_db($db);
							$query = "SELECT * FROM store_quests WHERE user_id = '".$_SESSION['Uid']."' ORDER BY id";
							$questResult = mysql_query($query);
							
							$questCount = mysql_num_rows($questResult);
							if ($questCount < 1)
							{
								echo "You haven't uploaded any quest yet.<br/>";
							}
							else
							{
								for ($i=0; $i < $questCount; $i++)
								{
									$currName = mysql_result($questResult, $i, "name");
									echo $currName." (0/5) - Downloaded 0 times<br/>";
									$currLang = mysql_result($questResult, $i, "lang");
									$currOfficial = mysql_result($questResult, $i, "isOfficial");
									if ($currOfficial == '1')
									{
										$currOfficial = ' - OFFICIAL';
									}
									else
									{
										$currOfficial = '';
									}
									echo '<div style="float: left">Language: '.$currLang.$currOfficial.'</div>';
									echo'<div style="float: right" class="expcolimage"><img style="cursor: pointer;" src="../forum/images/collapse_collapsed.gif" id="more_'.$i.'" class="expander" alt="[+]" title="[+]"></div>';
									
									echo '<div style="display: none" id="more_'.$i.'_e"><br/>';
									echo '<div style="float:left"><i>If you delete the quest, this won\'t be visible anymore.</div>';
									$currID = mysql_result($questResult, $i, "filename");
									
									echo '<form action="personal.php" method="post">';
									echo '<div style="float: right"><input type="button" value="Delete"></div>';
									echo '<input type="hidden" value="delete" name="action" /><input type="hidden" value="'.$currID.'" name="quest_id" /></form>';
									echo '</div>';
									if (($i +1) != $questCount)
									{
										echo "<br /><hr />";
									}
								}
							}
							
							mysql_close();
						?>
                        </td>
                    </tr>
                </tbody>
            </table>
        
        <br />
        <!-- Uploader -->
            <table width="70%" class="tborder">
                <thead>
                <tr>
                    <td class="thead"><div class="expcolimage"><img style="cursor: pointer;" src="../forum/images/collapse_collapsed.gif" id="uploader_form" class="expander" alt="[+]" title="[+]"></div>
<strong>Upload Quest</strong>
                    </td>
                </tr>
                </thead>
                <tbody style="display: none" id="uploader_form_e">
                    <tr>
                        <td class="trow1">
                            <form action="personal.php" method="post" enctype="multipart/form-data">
                                <table border="0">
                                    <tr>
                                        <td style="vertical-align: top">
                                        <br/>
                                        File: <input type="file" name="upfile" size="48"><br/><br/>
                                        <div style="float: left">
										<?php
                                            if (isset($_SESSION['Storer']))
                                            {
                                                echo '<input type="checkbox" name="isOfficialQuest" value="chkd"/>Official Quest';
                                            }
                                        ?>
                                        </div>                       
                                        <div style="float: right">
                                            <input type="submit" value="Upload" >&nbsp;&nbsp;&nbsp;
                                            <input type="hidden" value="upload" name="action" />
                                        </div>
                                        </td>
                                        <td></td>
                                        <td style="vertical-align: top">
                                        	<b>Readme:</b><br /><i>
                                            Only .cqs files will be uploaded, so your quest must be saved in this format in order to make them visible on the PSP Store.<br /><br />
                                            Remember that only English Quests can be approved to be Official Store Quests, so save them when using the CQE in EN.</i>
                                        </td>
                                    </tr>
                                 </table>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
	</tr>
</table>
</div>
</body>
</html>