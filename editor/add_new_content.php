<?php

	$_include_path = '../include/';
	$_editor_path = '../editor/';
	require($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		if ($_POST['pid'] != 0) {
			Header('Location: ../index.php?cid='.$_POST['pid'].';f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
			exit;
		}
		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if ($_POST['submit']) {
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
			$release_date = "$day/$month/$year $hour:$min:00";

			$cid = $contentManager->addContent($_SESSION['course_id'],
												  $_POST['pid'],
												  $_POST['ordering'],
												  $_POST['title'],
												  $_POST['body'],
												  $_POST['related'],
												  '1',
												  $release_date);
												  
			/* check if a definition is being used that isn't already in the glossary */
			$r = preg_match_all("/(\[\?\])([\s\w\d])*(\[\/\?\])/i", $_POST['body'], $matches, PREG_PATTERN_ORDER);

			if ($r != 0) {
				Header('Location: ./add_new_glossary.php?pcid='.$cid);
				exit;
			} else {
				Header('Location: ../index.php?cid='.$cid.';f='.urlencode_feedback(AT_FEEDBACK_CONTENT_ADDED));
				exit;
			}
		}
	}

	$_section[0][0] = $_template['add_content'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');
	require($_editor_path.'spaw_control.class.php');

	if (isset($_GET['pid'])) {
		$pid = intval($_GET['pid']);
	} else {
		$pid = intval($_POST['pid']);
	}
	$top_level = $contentManager->getContent($pid);

?>
	<h2><?php echo $_template['add_content']; ?></h2>
	<?php
	$help[] = AT_HELP_EMBED_GLOSSARY;
	//$help[] = AT_HELP_CONTENT_PATH;

print_help($help);

	/* print any errors that occurred */
	print_feedback($feedback);
	print_errors($errors);
?>

	<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
	<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
	<input type="hidden" name="MAX_FILE_SIZE" value="204000" />
	<p>
		<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center"		 width="90%">
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="right" class="row1"><b><label for="title"><?php echo $_template['title']; ?>:</label></b></td>
			<td class="row1"><input type="text" name="title" size="40" class="formfield" value="<?php echo ContentManager::cleanOutput($_POST['title']); ?>" id="title" /></td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="right" class="row1"><?php print_popup_help(AT_HELP_NOT_RELEASED); ?><b><?php echo $_template['release_date']; ?>:</b></td>
			<td class="row1"><?php
					$today_day  = date('d');
					$today_mon  = date('m');
					$today_year = date('Y');
					$today_hour = date('H');
					$today_min  = 0;

					require($_include_path.'lib/release_date.inc.php');

				echo ' ';

				?></td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td colspan="2" valign="top" align="left" class="row1"><b><label for="body"><?php echo $_template['body']; ?>:</label></b><br />
				<?php $sw = new SPAW_Wysiwyg('body',stripslashes($HTTP_POST_VARS['body']));
				$sw->show(); ?>

				<!-- <p><textarea name="text" class="formfield" cols="73" rows="20" id="body"><?php echo ContentManager::cleanOutput($_POST['text']); ?></textarea></p> -->
				<br /></td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<!-- <tr>
			<td align="right" class="row1">	
			<?php // print_popup_help(AT_HELP_FORMATTING); ?>
			<b><?php // echo $_template['formatting']; ?>:</b></td>
			<td class="row1"><input type="radio" name="formatting" value="0" id="text" <?php // if ($_POST['formatting'] === 0) { echo 'checked="checked"'; } ?> /><label for="text"><?php // echo $_template['plain_text']; ?></label>, <input type="radio" name="formatting" value="1" id="html" <?php // if ($_POST['formatting'] !== 0) { echo 'checked="checked"'; } ?> /><label for="html"><?php // echo $_template['html']; ?></label> <?php ?></td>
		</tr> 
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td class="row1" colspan="2"><a href="<?php // echo substr($_my_uri, 0, strlen($_my_uri)-1); ?>#jumpcodes" title="<?php // echo $_template['jump_code']; ?>"><?php // print_popup_help(AT_HELP_ADD_CODES1); ?><img src="images/clr.gif" height="1" width="1" alt="<?php // echo $_template['jump_code']; ?>" border="0" /></a><?php // require($_include_path.'html/code_picker.inc.php'); ?></td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr> --> 

		<tr>
			<td align="right" class="row1"><a name="jumpcodes"></a><?php print_popup_help(AT_HELP_INSERT); ?><b><label for="insert"><?php echo $_template['insert']; ?>:</label></b></td>
			<td class="row1"><select name="ordering" id="insert" class="formfield">
				<option value="0"><?php echo $_template['start_section']; ?></option>
			<?php
			if (is_array($top_level)) {
				$count = count($top_level);
				if ($count > 0) {
					echo '<option value="'.$count.'" selected="selected">'.$_template['end_section'].'</option>';
				}
				foreach ($top_level as $x => $info) {
					echo '<option value="'.$info['ordering'].'">'.$_template['after'].': '.$info['ordering'].' "'.$info['title'].'"</option>';
				}
			}			
			?></select>
			<?php 
//				if (is_array($top_level)) {
//				  foreach ($top_level as $x => $info) {
//						echo $info['ordering'].' : ';
//					} 
//				}
			?>
			<input type="hidden" name="formating" id="text" value="1"> 
			</td>
		</tr>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td align="right" class="row1"><?php print_popup_help(AT_HELP_RELATED); ?><label for="related"><b><?php echo $_template['related_to']; ?></b></label></td>
			<td class="row1"><?php
				$menu = $contentManager->getContent();

				if ($contentManager->getNumSections() > 0) {
					echo '<select class="formfield" name="related[]" id="related">';
					echo '<option value="0"></option>';

					print_select_menu(0, $menu, $_POST['related'][0]);

					echo '</select></td></tr>';
 
					for ($i=1; $i<min(4, $contentManager->getNumSections() ); $i++) {
						echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
						echo '<tr><td align="right" class="row1">&nbsp;</td>';
						echo '<td class="row1"><select class="formfield" name="related[]" id="related">';
						echo '<option value="0"></option>';
						print_select_menu(0, $menu, $_POST['related'][$i]);
						echo '</select></td></tr>';
					}

				} else {
					echo $_template['none_available'].'</td></tr>';
				}
				echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
			?>
		<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
			<td colspan="2" align="center" class="row1"><br /><input type="submit" name="submit" value="<?php echo $_template['add_content'];  ?>" class="button" accesskey="s" />  - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel'];  ?>" /></td>
		</tr>
		</table>
	</p>
	</form>

	<hr />
<?php
	//require($_include_path.'html/learning_concepts.inc.php');

	require($_include_path.'footer.inc.php');
?>
