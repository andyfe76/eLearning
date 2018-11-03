<?php

	$_include_path = '../include/';
	$_editor_path = '../editor/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/format_content.inc.php');

	if ($_POST['cancel']) {
		if ($_POST['pid'] != 0) {
			Header('Location: ../index.php?cid='.$_POST['pid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
			exit;
		}
		Header('Location: ../index.php?cid='.$_POST['cid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	
	if ($_POST['body']){		
		//***            						intro_stud.inc.php
		   				$cfname = 'include/html/intro_stud.inc.php';		
						ignore_user_abort(true);    ## prevent refresh from aborting file operations and hosing file
						$fh = fopen($cfname, 'w+');    
        				fwrite($fh, $_POST['body']);
        				fflush($fh);
     					fclose($fh);
						ignore_user_abort(false);    ## put things back to normal
		
		//***

				
			
				
				Header('Location: ../users/index.php');
				exit;
			
	}

	$_section[0][0] = $_template['edit_content'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');

	if (isset($_GET['pid'])) {
		$pid = intval($_GET['pid']);
	} else {
		$pid = intval($_POST['pid']);
	}

?>
	<h2><?php echo $_template['edit_content'];  ?></h2>
<?php

	$help[] = AT_HELP_EMBED_GLOSSARY;
	//$help[] = AT_HELP_CONTENT_PATH;

?>
<!-- p>(<a href="frame.php?p=<?php //echo urlencode($_my_uri); ?>"><?php //echo $_template['open_frame']; ?></a>).</p-->
<?php

	/* print any errors that occurred */
	print_errors($errors);
	print_feedback($feedback);
	print_help($help);

?>
	<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
	<?php

	if(!$_POST['cid']){
		$result = $contentManager->getContentPage($cid);
		if (!( $row =$result->fetchRow(DB_FETCHMODE_ASSOC)) ) {
			$errors[] = AT_ERROR_PAGE_NOT_FOUND;
			print_errors($errors);
			require ($_include_path.'footer.inc.php');
			exit;
		}
	}

	$top_level = $contentManager->getContent($row['CONTENT_PARENT_ID']);

	if ($_POST['pid']) {
		echo '<input type="hidden" name="pid" value="'.$_POST['pid'].'" />';
	} else {
	 	echo '<input type="hidden" name="pid" value="'.$pid.'" />';
	}

	if ($_POST['cid']) {
		echo '<input type="hidden" name="cid" value="'.$_POST['cid'].'" />';
	} else {
		echo '<input type="hidden" name="cid" value="'.$cid.'" />';
	}
?>

	<input type="hidden" name="MAX_FILE_SIZE" value="204000" />
	<p>
		<table cellspacing="1" cellpadding="0" width="90%" border="0" class="bodyline" summary="" align="center">
		<tr>
			<th colspan="2"class="left"><?php echo $_template['edit_content'];  ?>
<?php
			 echo '<input type="hidden" name="revision" value="'.ContentManager::cleanOutput($row['REVISION']).'" />';
			 echo '<input type="hidden" name="last_modified" value="'.$row['LAST_MODIFIED'].'" />';
			if($_POST['revision'] && $_POST['last_modified']){
				echo '<small class="spacer"> ( '.$_template['last_modified'].':'.$_POST['last_modified'].'. '. $_template['revision'].':'.$_POST['revision'].'. )</small>';

			}else{
				echo '<small class="spacer"> ( '.$_template['last_modified'].':'.$row['LAST_MODIFIED'].'. '. $_template['revision'].':'.ContentManager::cleanOutput($row['REVISION']).'. )</small>';

			}
			require($_editor_path.'spaw_control.class.php');
			?>
			</th>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		
		<?php
		if($_POST['title']){
		?>
		<tr>
			<td align="right" class="row1"><b><label for="title"><?php echo $_template['title'];  ?>:</label></b></td>
			<td class="row1"><input type="text" name="title" size="40" class="formfield" value="<?php echo ContentManager::cleanOutput($_POST['title']); ?>" id="title" /></td>
		</tr>
		<?php }else{ ?>
		
		<tr>
			<td align="right" class="row1"><b><label for="title"><?php echo $_template['title'];  ?>:</label></b></td>
			<td class="row1"><input type="text" name="title" size="40" id="title" class="formfield" value="<?php echo ContentManager::cleanOutput($row['TITLE']); ?>"></td>
		</tr>
		
		<?php } ?>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<?php if ($_POST['day']) { ?>
		<tr>
			<td align="right" class="row1"><?php print_popup_help(AT_HELP_NOT_RELEASED); ?><b><?php echo $_template['release_date'];  ?></b></td>
			<td class="row1"><?php

				$today_day   = $day;
				$today_mon   = $month;
				$today_year  = $year;

				$today_hour  = $hour;
				$today_min   = $min;
				require($_include_path.'lib/release_date.inc.php');
		?>
	</td>
	</tr>
	<?php } else { ?>
	<tr>
	<td align="right" class="row1"><?php print_popup_help(AT_HELP_NOT_RELEASED); ?><b><?php echo $_template['release_date'];  ?>:</b></td>
	<td class="row1"><?php

			$today_day   = substr($row['R_DATE'], 0, 2);
			$today_mon   = substr($row['R_DATE'], 3, 2);
			$today_year  = substr($row['R_DATE'], 6, 4);

			$today_hour  = substr($row['R_DATE'], 11, 2);
			$today_min   = substr($row['R_DATE'], 14, 2);
			
			require($_include_path.'lib/release_date.inc.php');

			?>
	</td>
	</tr>
	
	<?php } ?>


		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td colspan="2" valign="top" align="left" class="row1"><b><label for="body"><?php echo $_template['body'];  ?>:</label></b><br />

			<?php 
			if ($_POST['body']) { 
				$_POST['body'] = str_replace('`', "'", $_POST['body']);
				$sw = new SPAW_Wysiwyg('body',stripslashes(($HTTP_POST_VARS['body'])));
				$sw->show(); 
			 } else {  
			 	
			 	//***
			 	$fh = fopen('../'.$row['TEXT'], 'r');   
        		$chf_text = fread($fh, filesize('../'.$row['TEXT']));
        		fflush($fh);
     			fclose($fh);
			 	//***
			 	
			 	$chf_text = str_replace('`', "'", $chf_text);
				$sw = new SPAW_Wysiwyg('body',stripslashes(($chf_text)));
				$sw->show();
			} ?>
				</td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>

		<tr>
			<td align="right" class="row1"><a name="jumpcodes"></a><?php print_popup_help(AT_HELP_INSERT); ?><b><label for="move"><?php echo $_template['move_to']; ?>:</label></b></td>
			<td class="row1"><select name="new_ordering" class="formfield" id="move">
				<option value="-1"></option><?php

			if ($row['ORDERING'] != count($top_level)) {
				echo '<option value="'.count($top_level).'">'.$_template['end_section'].'</option>';
			}
			if ($row['ORDERING'] != 1) {
				echo '<option value="1">'.$_template['start_section'].'</option>';
			}

			foreach ($top_level as $x => $info) {
				if (($info['ordering'] != $row['ORDERING']-1) 
					&& ($info['ordering'] != $row['ORDERING']))
				{
					echo '<option value="';
					
					if ($info['ordering'] == count($top_level)) {
						/* special case, last item */
						echo $info['ordering'];
					} else {
						echo $info['ordering']+1;
					}

					echo '">'.$_template['after'].': '.$info['ordering'].' "'.$info['title'].'"</option>';
				} else {
					echo '<option value="-1">'.$_template['no_change'].': '.$info['ordering'].' "'.$info['title'].'"</option>';
				}
			}
		?></select><?php

			$menu = $contentManager->getContent();
			echo $_template['or'].' <select name="move">';
			echo '<option value="-1"></option>';
			echo '<option value="0">'.$_template['top'].'</option>';
			print_move_select(0, $menu, $row['CONTENT_PARENT_ID']);
			echo '</select>';

		?></td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="right" class="row1"><?php print_popup_help(AT_HELP_RELATED); ?><label for="related"><b><?php echo $_template['related_to'];  ?>:</b></label></td>
		<td class="row1"><?php
		reset($menu);

		if ($contentManager->getNumSections() > 1) {
			/* get existing related content */
			if ($_POST['submit'] != '') {
				$related_content = $_POST['related'];
			} else {
				$related_content = $contentManager->getRelatedContent($cid);
			}

			echo '<select class="formfield" name="related[]" id="related">';
			echo '<option value="0"></option>';

			print_select_menu(0, $menu, $related_content[0]);

			echo '</select></td></tr>';
			

			for ($i=1; $i<max( min(4, $contentManager->getNumSections()-1 ), count($related_content) ); $i++) {
				echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
				echo '<tr><td align="right" class="row1">&nbsp;</td>';
				echo '<td class="row1"><select class="formfield" name="related[]">
							<option value="0"></option>';
				
				print_select_menu(0, $menu, $related_content[$i]);

				echo '</select></td></tr>';
			}
		} else {
			echo $_template['none_available'].'</td></tr>';
		}
?>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td colspan="2" align="center" class="row1"><br /><input type="submit" name="submit" value="<?php echo $_template['save_content'] ?>" class="button" accesskey="s" />  - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel']; ?>" /></td>
		</tr>
		</table>
	</p>
	</form>
	<SCRIPT language="JavaScript">
		document.form.title.focus();
	</SCRIPT>

<?php
	require($_include_path.'footer.inc.php');
?>
