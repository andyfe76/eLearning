<?php

	$_include_path	='../../include/';
	require($_include_path.'vitals.inc.php');

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests/';
	$_section[2][0] = $_template['edit_test'];

	$tid = intval($_GET['tid']);
	if ($tid == 0){
		$tid = intval($_POST['tid']);
	}
	
	if (isset($_GET['title'])){
		$test_title = $_GET['title'];
	} else if (isset($_POST['title'])) {
		$test_title = $_POST['title'];
	} else if (isset($_GET['tt'])) {
		$test_title = $_GET['tt'];
	}

	if ($_POST['addq']) {
		Header('Location: questions.php?tid='.$tid.SEP.'tt='.$_POST['title']);
		exit;
	}
	
	if ($_POST['submit']) {
		$_POST['title'] = trim($_POST['title']);
		$_POST['format']= intval($_POST['format']);
		$_POST['randomize_order']	= intval($_POST['randomize_order']);
		$_POST['num_questions']		= intval($_POST['num_questions']);

		$_POST['instructions'] = trim($_POST['instructions']);

		if ($_POST['title'] == '') {
			$errors[] = AT_ERROR_NO_TITLE;
		}
		
		$s_date = $_POST['s_date'];
		$e_date = $_POST['e_date'];
		
		$day_start	= substr($s_date, 0, 2);
		$month_start= substr($s_date, 3, 2);
		$year_start	= substr($s_date, 6, 4);
		$hour_start	= substr($s_date, 11, 2);
		$min_start	= substr($s_date, 14, 2);

		$day_end	= substr($e_date, 0, 2);
		$month_end	= substr($e_date, 3, 2);
		$year_end	= substr($e_date, 6, 4);
		$hour_end	= substr($e_date, 11, 2);
		$min_end	= substr($e_date, 14, 2);

		if (!checkdate($month_start, $day_start, $year_start)) {
			$errors[]= AT_ERROR_START_DATE_INVALID;
		}

		if (!checkdate($month_end, $day_end, $year_end)) {
			$errors[]=AT_ERROR_END_DATE_INVALID;
		}

		if (strlen($month_start) == 1){
			$month_start = "0$month_start";
		}
		if (strlen($day_start) == 1){
			$day_start = "0$day_start";
		}
		if (strlen($hour_start) == 1){
			$hour_start = "0$hour_start";
		}
		if (strlen($min_start) == 1){
			$min_start = "0$min_start";
		}
		if (strlen($month_end) == 1){
			$month_end = "0$month_end";
		}
		if (strlen($day_end) == 1){
			$day_end = "0$day_end";
		}
		if (strlen($hour_end) == 1){
			$hour_end = "0$hour_end";
		}
		if (strlen($min_end) == 1){
			$min_end = "0$min_end";
		}

		$start_date = "$day_start/$month_start/$year_start $hour_start:$min_start:00";
		$end_date	= "$day_end/$month_end/$year_end $hour_end:$min_end:00";
		
		if (!$errors) {
			$sql = "UPDATE tests SET 
			title='".$_POST['title']."',
  			format='".$_POST['format']."', 
			start_date=TO_DATE('".$start_date."', 'DD/MM/YYYY HH24:MI:SS'), 
			end_date=TO_DATE('".$end_date."', 'DD/MM/YYYY HH24:MI:SS'),
			duration='".$_POST['duration']."', 
			retries='".$_POST['retries']."', 
			randomize_order='".$_POST['order']."', 
			num_questions='".$_POST['num']."', 
			instructions='".$_POST['instructions']."', 
			min_grade='".$_POST['min_grade']."' 
			
			WHERE 	
				test_id=".$tid." AND 
				course_id=".$_SESSION['course_id'] ;
				
			//echo '<br><br>'.$sql.'<br><br>';//??
			$result = $db->query($sql) ;//or die ('---========= query error =========---'.mysql_error());
			
			$sql = "UPDATE content SET title='".$_POST['title']."' WHERE text=".$tid." AND course_id=".$_SESSION['course_id'] ;
			$res = $db->query($sql);
			
			//================ move ====================
			error_reporting(E_NOTICE | E_WARNNING | E_PARSE | E_ERROR );
			if($_POST['move']||$_POST['new_ordering']){
					
					
					$cid=$_SESSION['s_cid'];
					$move=$_POST['move'];	
					$content_id=$_SESSION['s_cid'];
					$new_ordering=$_POST['new_ordering'];
					$sql	= "SELECT ordering, content_parent_id FROM content WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
					$result	= $db->query($sql);
					
					if ( !$row = $result->fetchRow(DB_FETCHMODE_ASSOC) ) {
						return false;
					}		

					$old_ordering		= $row['ORDERING'];
					$content_parent_id	= $row['CONTENT_PARENT_ID'];
					$new_content_parent_id = $content_parent_id;
					$new_content_ordering  = $row['ORDERING'];
 
 					if ($move != -1) {
						if ($move == 0) {
							$new_content_parent_id = 0;
							$new_content_ordering  = 1;

						} else {
							$new_content_parent_id = $move;
							$new_content_ordering  = 1;
						}

					// step 1:											
					// remove the gap left by the moved content			//
					$sql = "UPDATE content SET ordering=ordering-1 WHERE ordering>=$old_ordering AND content_parent_id=$content_parent_id AND content_id<>$content_id AND course_id=$_SESSION[course_id]";
					$result = $db->query($sql);

					// step 2:											//
					// shift the new neighbouring content down			//
					$sql = "UPDATE content SET ordering=ordering+1 WHERE ordering>=$new_content_ordering AND content_parent_id=$new_content_parent_id AND content_id<>$content_id AND course_id=$_SESSION[course_id]";
					$result = $db->query($sql);

					// step 3:											//
					// insert the new content at the bottom				//

					} else if ($new_ordering != -1) {
					// this content will be moved //

					if ($old_ordering < $new_ordering) {
						// move it down				      //
						$start = $old_ordering;
						$end   = $new_ordering;

						// and shift everything else up   //
						$sign = '-';
					} else {
						
						// move it up					 //
						$start = $new_ordering;
						$end   = $old_ordering;
						// and shift everything else down //
						$sign = '+';
					}

					$sql = "UPDATE content SET ordering=ordering $sign 1 WHERE ordering>=$start AND ordering<=$end AND content_parent_id=$content_parent_id AND course_id=$_SESSION[course_id]";
					$result = $db->query($sql);
					$new_content_ordering = $new_ordering;
				} 
				
				
			
		// end moving block 
			}
			$sql = "UPDATE content SET content_parent_id=".$new_content_parent_id.", ordering=".$new_content_ordering." WHERE content_id =".$cid;
			$result = $db->query($sql);
		//================ move ====================	
			
			Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_UPDATED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');
	//echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	//echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	//echo '<h3>'.$_template['edit_test'].'</h3>';

	if (!$_POST['submit']) {
		$sql	= "SELECT test_id, course_id, title, format, TO_CHAR(start_date, 'DD-MM-YYYY HH24:MI:SS') as start_date, TO_CHAR(end_date, 'DD-MM-YYYY HH24:MI:SS') as end_date, duration, randomize_order, num_questions, instructions, retries, min_grade FROM tests WHERE test_id=$tid AND course_id=$_SESSION[course_id]";
		$result	= $db->query($sql);

		if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$errors[]=AT_ERROR_TEST_NOT_FOUND;
			print_errors($errors);
			require ($_include_path.'footer.inc.php');
			exit;
		}

		$_POST	= $row;
	} else {
		$_POST['start_date'] = $start_date;
		$_POST['end_date']	 = $end_date;
	}


print_errors($errors);

?>
<script language="JavaScript" src="include/calendar/ts_picker.js">

//Script by Denis Gritcyuk: tspicker@yahoo.com
//Submitted to JavaScript Kit (http://javascriptkit.com)
//Visit http://javascriptkit.com for this script

</script>
<form action="tools/tests/edit_test.php" method="post" name="form">
<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="100%">
<tr>
	<th colspan="2" class="left"><?php echo $_template['edit_test']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><label for="title"><b><?php echo $_template['test_title']; ?>:</b></label></td>
	<td class="row1"><input type="text" name="title" id="title" class="formfield" size="40"	value="<?php 
		echo $test_title; ?>" /></td>
</tr>
<input type="hidden" name="format" value="0" />
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['start_date']; ?>:</b></td>
	<td class="row1"><?php
			
			$s_date = $_POST['START_DATE'];
			$e_date = $_POST['END_DATE'];
			echo '<input type="text" size="24" name="s_date" value="'.$s_date.'">';
			echo '&nbsp;&nbsp;';
			echo '<a href="javascript:show_calendar(\'document.form.s_date\', document.form.s_date.value);"><img src="images/cal/cal.gif" width="16" height="16" border="0" alt="'.$_template['pick_up_timestamp'].'"></a>';

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['end_date']; ?>:</b></td>
	<td class="row1"><?php
			echo '<input type="text" size="24" name="e_date" value="'.$e_date.'">';
			echo '&nbsp;&nbsp;';
			echo '<a href="javascript:show_calendar(\'document.form.e_date\', document.form.e_date.value);"><img src="images/cal/cal.gif" width="16" height="16" border="0" alt="'.$_template['pick_up_timestamp'].'"></a>';
	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	$sql = "SELECT * FROM tests WHERE test_id=$tid";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
?>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_DURATION);  ?>
		<b> <?php echo $_template['test_duration'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="duration" id="duration" value="<?php echo $row['DURATION']; ?>">
		<label for="duration"><?php echo $_template['minutes']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_RETRIES);  ?>
		<b> <?php echo $_template['test_retries'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="retries" id="retries" value="<?php echo $row['RETRIES']; ?>">
		<label for="duration"><?php echo $_template['times']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="order"><b><?php echo $_template['randomize_order']; ?>:</b></label></td>
	<td class="row1">
	<input type="radio" name="order" value="1" id="yes" <?php if ($row['RANDOMIZE_ORDER'] >0) { echo 'checked="checked"'; }?> />
	<label for="yes">yes</label>, 
	<input type="radio" name="order" value="0" id="no" <?php if ($row['RANDOMIZE_ORDER'] ==0) { echo 'checked="checked"'; }?> />
	<label for="no">no</label></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_NUMBER_QUESTIONS);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['number_of_questions']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="num" name="num" size="2" class="formfield" value="<?php echo $row['NUM_QUESTIONS']; ?>" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_MIN_GRADE);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['min_grade']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="min_grade" name="min_grade" size="2" class="formfield" value="<?php echo $row['MIN_GRADE']; ?>" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><?php print_popup_help(AT_HELP_SPECIAL_INSTRUCTIONS);  ?>
	<label for="inst"><b><?php echo $_template['special_instructions']; ?>:</b></label></td>
	<td class="row1"><textarea name="instructions" id="inst" class="formfield" cols="50" rows="6"><?php echo $row['INSTRUCTIONS']; ?></textarea>
	<br />
	<br /></td>
</tr>
<?php 
		$cid=$_SESSION['s_cid'];
		
		$result = $contentManager->getContentPage($cid);

		if (!( $row = @$result->fetchRow(DB_FETCHMODE_ASSOC)) ) {
			$errors[]=AT_ERROR_PAGE_NOT_FOUND;
			print_errors($errors);
			require ($_include_path.'footer.inc.php');
			exit;
		}
		$top_level = $contentManager->getContent($row['CONTENT_PARENT_ID']);
?>

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
			print_move_select(0, $menu, $row['content_parent_id']);
			echo '</select>';

		?></td>
		</tr>


<?php //***e ?>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td colspan="2">
	<?php
		echo '<img src="../../images/spacer.gif" width="10" height="1">';
		echo '<b>';
		echo '<a href="tools/tests/questions.php?tid='.$tid.SEP.'tt='.$_POST['TITLE'].'" class="breadcrumbs">'.$_template['edit_test_questions'].'</a>';
		//echo '<img src="../../images/spacer.gif" width="50" height="1"><a href="users/usermng.php" class="breadcrumbs">'.$_template['report'].'</a>';
		echo '</b>';
		//echo '<input type="submit" name="addq" value="'.$_template['edit_test_questions'].'" class="button">';
	?>
</td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td colspan="2">
	<?php
		echo '<img src="../../images/spacer.gif" width="10" height="1">';
		echo '<img src="../../images/kdelete.gif">';
		echo '<b>';
		echo '<a href="tools/tests/delete_test.php?cid='.$cid.'&tid='.$tid.SEP.'tt='.$_POST['TITLE'].'" class="breadcrumbs">'.$_template['delete'].' test</a>';
		echo '</b>';
	?>
</td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<input type="hidden" name="tid" value="<?php echo $tid; ?>">
	<td class="row1" align="center" colspan="2"><input type="submit" value="<?php echo $_template['save_test_properties'];  ?>" class="button" name="submit" accesskey="s" />
	</td>
</tr>


</table>
</form>
<br />
<?php
	require ($_include_path.'footer.inc.php');

?>