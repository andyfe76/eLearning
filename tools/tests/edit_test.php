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
		
		$day_start	= intval($_POST['day_start']);
		$month_start= intval($_POST['month_start']);
		$year_start	= intval($_POST['year_start']);
		$hour_start	= intval($_POST['hour_start']);
		$min_start	= intval($_POST['min_start']);

		$day_end	= intval($_POST['day_end']);
		$month_end	= intval($_POST['month_end']);
		$year_end	= intval($_POST['year_end']);
		$hour_end	= intval($_POST['hour_end']);
		$min_end	= intval($_POST['min_end']);

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

		$start_date = "$year_start-$month_start-$day_start $hour_start:$min_start:00";
		$end_date	= "$year_end-$month_end-$day_end $hour_end:$min_end:00";

		if (!$errors) {
			$sql = "UPDATE tests SET title='$_POST[title]', format=$_POST[format], start_date='$start_date', end_date='$end_date', duration=$_POST[duration], retries=$_POST[retries], randomize_order=$_POST[randomize_order], num_questions=$_POST[num_questions], instructions='$_POST[instructions]', min_grade=$_POST['min_grade'] WHERE test_id=$tid AND course_id=$_SESSION[course_id]";

			$result = mysql_query($sql, $db);

			Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_UPDATED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');
	//echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	//echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	//echo '<h3>'.$_template['edit_test'].'</h3>';

	if (!$_POST['submit']) {
		$sql	= "SELECT * FROM tests WHERE test_id=$tid AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $db);

		if (!($row = mysql_fetch_array($result))){
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
<form action="tools/tests/edit_test.php" method="post" name="form">
<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="100%">
<tr>
	<th colspan="2" class="left"><?php echo $_template['edit_test']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><label for="title"><b><?php echo $_template['test_title']; ?>:</b></label></td>
	<td class="row1"><input type="text" name="title" id="title" class="formfield" size="40"	value="<?php 
		echo $_POST['title']; ?>" /></td>
</tr>
<input type="hidden" name="format" value="0" />
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['start_date']; ?>:</b></td>
	<td class="row1"><?php
				
			$today_day   = substr($_POST['start_date'], 8, 2);
			$today_mon   = substr($_POST['start_date'], 5, 2);
			$today_year  = substr($_POST['start_date'], 0, 4);

			$today_hour  = substr($_POST['start_date'], 11, 2);
			$today_min   = substr($_POST['start_date'], 14, 2);

			$name = '_start';
			require($_include_path.'lib/release_date.inc.php');

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['end_date']; ?>:</b></td>
	<td class="row1"><?php
				
			$today_day   = substr($_POST['end_date'], 8, 2);
			$today_mon   = substr($_POST['end_date'], 5, 2);
			$today_year  = substr($_POST['end_date'], 0, 4);

			$today_hour  = substr($_POST['end_date'], 11, 2);
			$today_min   = substr($_POST['end_date'], 14, 2);

			$name = '_end';
			require($_include_path.'lib/release_date.inc.php');

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	$sql = "SELECT * FROM tests WHERE test_id=$tid";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
?>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_DURATION);  ?>
		<b> <?php echo $_template['test_duration'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="duration" id="duration" value="<?php echo $row['duration']; ?>">
		<label for="duration"><?php echo $_template['minutes']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_RETRIES);  ?>
		<b> <?php echo $_template['test_retries'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="retries" id="retries" value="<?php echo $row['retries']; ?>">
		<label for="duration"><?php echo $_template['times']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="order"><b><?php echo $_template['randomize_order']; ?>:</b></label></td>
	<td class="row1">
	<input type="radio" name="order" value="1" id="yes" <?php if ($row['randomize_order'] >0) { echo 'checked="checked"'; }?> />
	<label for="yes">yes</label>, 
	<input type="radio" name="order" value="0" id="no" <?php if ($row['randomize_order'] ==0) { echo 'checked="checked"'; }?> />
	<label for="no">no</label></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_NUMBER_QUESTIONS);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['number_of_questions']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="num" name="num" size="2" class="formfield" value="<?php echo $row['num_questions']; ?>" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_MIN_GRADE);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['min_grade']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="min_grade" name="min_grade" size="2" class="formfield" value="<?php echo $row['min_grade']; ?>" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><?php print_popup_help(AT_HELP_SPECIAL_INSTRUCTIONS);  ?>
	<label for="inst"><b><?php echo $_template['special_instructions']; ?>:</b></label></td>
	<td class="row1"><textarea name="instructions" id="inst" class="formfield" cols="50" rows="6"><?php echo $row['instructions']; ?></textarea>
	<br />
	<br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td colspan="2">
	<?php
	echo '<img src="../../images/spacer.gif" width="10" height="1">';
	echo '<b>';
	echo '<a href="tools/tests/questions.php?tid='.$tid.SEP.'tt='.$_POST['title'].'" class="breadcrumbs">'.$_template['edit_test_questions'].'</a>';
	echo '<img src="../../images/spacer.gif" width="50" height="1"><a href="users/usermng.php" class="breadcrumbs">'.$_template['report'].'</a>';
	echo '</b>';
	//echo '<input type="submit" name="addq" value="'.$_template['edit_test_questions'].'" class="button">';
	?>
</td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<input type="hidden" name="title" value="<?php echo $_POST['title']; ?>">
	<input type="hidden" name="tid" value="<?php echo $tid; ?>">
	<td class="row1" align="center" colspan="2"><input type="submit" value="<?php echo $_template['save_test_properties'];  ?>" class="button" name="submit" accesskey="s" />
	</td>
</tr>


</table>
</form>
<br />
<?php
	require ($_include_path.'footer.inc.php');

