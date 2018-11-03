<?php

	$_include_path = '../include/';
	$_editor_path = '../editor/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/forum_codes.inc.php');
	require($_include_path.'lib/format_content.inc.php');

	if ($_POST['cancel']) {
		if ($_POST['pid'] != 0) {
			Header('Location: ../index.php?cid='.$_POST['pid'].';f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
			exit;
		}
		Header('Location: ../index.php?cid='.$_POST['cid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if( ($_POST['submit_file'] == 'Upload') && ($_FILES['uploadedfile']['name'] == ''))	{
		$errors[] = AT_ERROR_FILE_NOT_SELECTED;
	} else if ($_POST['submit_file']) {
		if ($_FILES['uploadedfile']['name']
			&& (($_FILES['uploadedfile']['type'] == 'text/plain')
			|| ($_FILES['uploadedfile']['type'] == 'text/html')) )
		{
			$fd = fopen ($_FILES['uploadedfile']['tmp_name'], 'r');
			$_POST['text'] = fread ($fd, filesize($_FILES['uploadedfile']['tmp_name']));

			$path_parts = pathinfo($_FILES['uploadedfile']['name']);
			$ext = strtolower($path_parts['extension']);
			if (in_array($ext, array('html', 'htm'))) {
				/* get the <title></title> of this page				*/

				$start_pos	= strpos(strtolower($_POST['text']), '<title>');
				$end_pos	= strpos(strtolower($_POST['text']), '</title>');

				if (($start_pos !== false) && ($end_pos !== false)) {
					$start_pos += strlen('<title>');
					$_POST['title'] = trim(substr($_POST['text'], $start_pos, $end_pos-$start_pos));
				}

				unset($start_pos);
				unset($end_pos);

				/* strip everything before <body> */
				$start_pos	= strpos(strtolower($_POST['text']), '<body');
				if ($start_pos !== false) {
					$start_pos	+= strlen('<body');
					$end_pos	= strpos(strtolower($_POST['text']), '>', $start_pos);
					$end_pos	+= strlen('>');

					$_POST['text'] = substr($_POST['text'], $end_pos);
				}

				/* strip everything after </body> */
				$end_pos	= strpos(strtolower($_POST['text']), '</body>');
				if ($end_pos !== false) {
					$_POST['text'] = trim(substr($_POST['text'], 0, $end_pos));
				}

				/* change formatting to HTML? */
				/* $_POST['formatting']	= 1; */
			}
			$_POST['cid']=$_POST['cid'];
			$feedback[]=AT_FEEDBACK_FILE_PASTED;
			fclose ($fd);
		} else {
			$errors[] = AT_ERROR_BAD_FILE_TYPE;
		}
	}
	
	if ($_POST['submit']) {
		echo 'Submitting data...<br>';
		$_POST['title'] = trim($_POST['title']);
		$_POST['body']	= trim($_POST['body']);
		$_POST['pid']	= intval($_POST['pid']);
		$_POST['formatting']	= 1;

		if ($_POST['title'] == '') {
			$errors[] = AT_ERROR_NO_TITLE;
		}

		$day	= intval($_POST['day']);
		$month	= intval($_POST['month']);
		$year	= intval($_POST['year']);
		$hour	= intval($_POST['hour']);
		$min	= intval($_POST['min']);

		if (!checkdate($month, $day, $year)) {
			$errors[] = AT_ERROR_BAD_DATE;
		}

		if ($errors == '') {
			if (strlen($month) == 1){
				$month = "0$month";
			}
			if (strlen($day) == 1){
				$day = "0$day";
			}
			if (strlen($hour) == 1){
				$hour = "0$hour";
			}
			if (strlen($min) == 1){
				$min = "0$min";
			}
			$release_date = "$year-$month-$day $hour:$min:00";
			if($_POST['cid']){
			$err = $contentManager->editContent($_POST['cid'], $_POST['title'], $_POST['body'], $_POST['new_ordering'], $_POST['related'], $_POST['formatting'], $_POST['move'], $release_date);
			}

			/* check if a definition is being used that isn't already in the glossary */
			$r = preg_match_all("/(\[\?\])([\s\w\d])*(\[\/\?\])/i", $_POST['text'], $matches, PREG_PATTERN_ORDER);

			if ($r != 0) {
				/* redirect to add glossery terms, but we do not know if those have been defined or not */
				Header('Location: ./add_new_glossary.php?pcid='.$cid);
				exit;
			} else {
				Header('Location: ../index.php?cid='.$cid.';f='.urlencode_feedback(AT_FEEDBACK_CONTENT_UPDATED));
				exit;
			}
		 }
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
	<form action="<?php echo $PHP_SELF; ?>" method="post" name="form" enctype="multipart/form-data">
	<?php

	if(!$_POST['cid']){
		$result = $contentManager->getContentPage($cid);

		if (!( $row = @mysql_fetch_array($result)) ) {
			$errors[]=AT_ERROR_PAGE_NOT_FOUND;
			print_errors($errors);
			require ($_include_path.'footer.inc.php');
			exit;
		}
	}

	$top_level = $contentManager->getContent($row['content_parent_id']);

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
			 echo '<input type="hidden" name="revision" value="'.ContentManager::cleanOutput($row['revision']).'" />';
			 echo '<input type="hidden" name="last_modified" value="'.$row['last_modified'].'" />';
			if($_POST['revision'] && $_POST['last_modified']){
				echo '<small class="spacer"> ( '.$_template['last_modified'].':'.$_POST['last_modified'].'.'. $_template['revision'].':'.$_POST['revision'].'. )</small>';

			}else{
				echo '<small class="spacer"> ( '.$_template['last_modified'].':'.$row['last_modified'].'.'. $_template['revision'].':'.ContentManager::cleanOutput($row['revision']).'. )</small>';

			}
			require($_editor_path.'spaw_control.class.php');
			?>
			</th>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="right" class="row1" valign="top"><?php
				$errors[]=AT_ERROR_BAD_DATE;
				//$def = 'text<b>as</b>';   //whats this? untranslated
				print_popup_help(AT_HELP_PASTE_FILE1);
				?>
			<b><?php echo $_template['paste_file']; ?>:</b></td>
			<td class="row1" valign="top">
			<input type="file" name="uploadedfile" class="formfield" size="20" /> <input type="submit" name="submit_file" value=" <?php echo $_template['upload']; ?>" class="button" /><?php
			?><br />
			<small class="spacer"><?php echo $_template['html_only'] ?><br />
			<?php echo $_template['edit_after_upload']; ?></small>

			</td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="center" class="row1" colspan="2"><b><?php echo $_template['or'];?></b></td>
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
			<td class="row1"><input type="text" name="title" size="40" id="title" class="formfield" value="<?php echo ContentManager::cleanOutput($row['title']); ?>"></td>
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

			$today_day   = substr($row['release_date'], 8, 2);
			$today_mon   = substr($row['release_date'], 5, 2);
			$today_year  = substr($row['release_date'], 0, 4);

			$today_hour  = substr($row['release_date'], 11, 2);
			$today_min   = substr($row['release_date'], 14, 2);
			require($_include_path.'lib/release_date.inc.php');

			?>
	</td>
	</tr>
	
	<?php } ?>


		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td colspan="2" valign="top" align="left" class="row1"><b><label for="body"><?php echo $_template['body'];  ?>:</label></b><br />

			<?php if ($_POST['body']) { ?>
<?php $sw = new SPAW_Wysiwyg('body',stripslashes(($HTTP_POST_VARS['body'])));
				$sw->show(); ?>
				<br />
			<?php } else {  ?>
<?php $sw = new SPAW_Wysiwyg('body',stripslashes(($row['text'])));
				$sw->show(); ?>
				<br />
			<?php } ?>
				</td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>

		<tr>
			<td align="right" class="row1"><a name="jumpcodes"></a><?php print_popup_help(AT_HELP_INSERT); ?><b><label for="move"><?php echo $_template['move_to']; ?>:</label></b></td>
			<td class="row1"><select name="new_ordering" class="formfield" id="move">
				<option value="-1"></option><?php

			if ($row['ordering'] != count($top_level)) {
				echo '<option value="'.count($top_level).'">'.$_template['end_section'].'</option>';
			}
			if ($row['ordering'] != 1) {
				echo '<option value="1">'.$_template['start_section'].'</option>';
			}

			foreach ($top_level as $x => $info) {
				if (($info['ordering'] != $row['ordering']-1) 
					&& ($info['ordering'] != $row['ordering']))
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
			print_move_select(0, $menu, $row['content_parent_id']);
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
