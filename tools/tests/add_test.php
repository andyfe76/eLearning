<?php

	$_include_path	='../../include/';
	require($_include_path.'vitals.inc.php');
	
	if ($_POST['cancel']) {
		if ($_GET['pid'] != 0) {
			$_POST['pid'] = $_GET['pid'];
		}
		if ($_POST['pid'] != 0) {
			Header('Location: ../index.php?cid='.$_POST['pid'].';f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
			exit;
		}
		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}


	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests/';
	$_section[2][0] = $_template['add_test'];


	if ($_POST['submit']) {

		$_POST['title'] = trim($_POST['title']);
		$_POST['format']= intval($_POST['format']);
		$_POST['order']	= intval($_POST['order']);
		$_POST['num']	= intval($_POST['num']);
		
		if ($_POST['title'] == '') {
			$errors[] = AT_ERROR_NO_TITLE;
		}
		if ($_POST['min_grade'] == '') {
			$errors[] = AT_ERROR_INVALID_MIN_GRADE;
		}


		$_POST['instructions'] = trim($_POST['instructions']);

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

		if (!$errors) {
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
			
			if ($_POST['retries'] == '') $_POST['retries'] = 0;
			if ($_POST['duration'] == '') $_POST['duration'] = 0;
			if ($_POST['num'] == '') $_POST['num'] = 0;
			$_POST['min_grade'] = intval($_POST['min_grade']);

			$sql = "INSERT INTO tests VALUES (0, $_SESSION[course_id], '$_POST[title]', $_POST[format], '$start_date', '$end_date', $_POST[duration], $_POST[order], $_POST[num], '$_POST[instructions]', $_POST[retries], $_POST[min_grade])";
			$result = mysql_query($sql, $db);
			
			if (!$result) {
				echo 'Error inserting test properties.';
				echo '<br>SQL expression: '.$sql;
				exit;
			}
			
			$id = mysql_insert_id();
			
			if (($_POST['test_type'] >1) && ($id>0)) {
				$sql	= "INSERT INTO tests_questions VALUES (	0,
					$id,
					$_SESSION[course_id],
					0,
					2,
					$_POST[weight],
					0,
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0)";
				$result	= mysql_query($sql, $db);
				if (!$result) {
					echo 'Error initiating test question database.';
					exit;
				}
			}
			
			$sql = "INSERT INTO test_type VALUES ($id, $_POST[test_type])";
			$res = mysql_query($sql, $db);

			/*
			Insert the test into content management, so that we can give page display access for the pages that follows the test
			--> formatting = 2 indicates that the node is not a course page, but a test (break).
			*/
			$tid = strval($id);
			$cid = $contentManager->addContent($_SESSION['course_id'],
												  $_POST['pid'],
												  1,
												  $_POST['title'],
												  $tid,
												  '',
												  '2',
												  $start_date);
			
			if (!$cid) {
				echo 'Could not add content.';
				exit;
			}

			Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_ADDED));
			exit;
		}
	}
	
	
require($_include_path.'header.inc.php');
echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
echo '<h2>'.$_template['add_test'].'</h2>';

print_errors($errors);

?>
<form action="tools/tests/add_test.php" method="post" name="form">
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ADD_TEST); ?>
&nbsp;<?php echo $_template['new_test'];  ?></th>
</tr>
<tr>
	<td class="row1" align="right"><label for="title"><b><?php echo $_template['test_title'];  ?>:</b></label></td>
	<td class="row1"><input type="text" name="title" id="title" class="formfield" size="40"	value="<?php 
		echo $_POST['title']; ?>" /></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['test_type'];  ?>:</b></td>
	<td class="row1">
	<input type="radio" name="test_type" value="1" id="online" checked="checked" onClick="disableWeight();"><label for="online"><?php echo $_template['online']; ?></label><br>
	<input type="radio" name="test_type" value="2" id="offline" onClick="enableWeight();"><label for="offline"><?php echo $_template['offline']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_GLOBAL_WEIGHT);  ?>
	<b> <?php echo $_template['global_weight']; ?>:</b></td>
	<td class="row1"><div id="div_weight" style="visibility:hidden">
		<input type="text" size="4" name="weight" id="weight" value="<?php echo $_POST['weight']; ?>">
	</div></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['start_date'];  ?>:</b></td>
	<td class="row1"><?php
				
					$today_day  = date('d');
					$today_mon  = date('m');
					$today_year = date('Y');
					$today_hour = date('H');
					$today_min  = 0;

					$name = '_start';
					require($_include_path.'lib/release_date.inc.php');

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['end_date'];  ?>:</b></td>
	<td class="row1"><?php
				
					$today_day  = date('d');
					$today_mon  = date('m');
					$today_year = date('Y');
					$today_hour = date('H');
					$today_min  = 0;
					
					$name = '_end';
					require($_include_path.'lib/release_date.inc.php');

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_DURATION);  ?>
		<b> <?php echo $_template['test_duration'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="duration" id="duration" value="<?php echo $_POST['duration']; ?>">
		<label for="duration"><?php echo $_template['minutes']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_TEST_RETRIES);  ?>
		<b> <?php echo $_template['test_retries'];  ?>:</b></td>
	<td class="row1">
		<input type="text" size="4" name="retries" id="retries" value="<?php echo $_POST['retries']; ?>">
		<label for="duration"><?php echo $_template['times']; ?></label>
	</td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="format"><b><?php echo $_template['questions_per_page']; ?>:</b></label></td>
	<td class="row1"><select name="format" id="format">
			<option value="0"><?php echo $_template['all_on_one_page']; ?></option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
		</select></td>
</tr>

<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="order"><b><?php echo $_template['randomize_order']; ?>:</b></label></td>
	<td class="row1"><input type="radio" name="order" value="1" id="yes" /><label for="yes">yes</label>, <input type="radio" name="order" value="0" id="no" checked="checked" /><label for="no">no</label></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_NUMBER_QUESTIONS);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['number_of_questions']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="num" name="num" size="2" class="formfield" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><?php print_popup_help(AT_HELP_MIN_GRADE);  ?>
		<label for="num"><b>&nbsp;<?php echo $_template['min_grade']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="min_grade" name="min_grade" size="2" class="formfield" /></td>
</tr> 

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><?php print_popup_help(AT_HELP_SPECIAL_INSTRUCTIONS);  ?>
	<label for="inst"><b><?php echo $_template['special_instructions']; ?></b></label></td>
	<td class="row1"><textarea name="instructions" id="inst" class="formfield" cols="50" rows="6"></textarea>
	<br />
	<br /></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="center" colspan="2"><input type="submit" value="<?php echo $_template['save_test_properties']; ?> Alt-s" class="button" name="submit" accesskey="s" /></td>
</tr>
</table>
</form>
<br />
<SCRIPT language=JavaScript>
<!--
function enableWeight()
{
	// document.form.weight.disabled = false;
	document.all.div_weight.style.visibility="visible";
	document.all.weight.focus();
}

function disableWeight()
{
	// document.form.weight.disabled = true;
	document.all.div_weight.style.visibility="hidden";
}

// -->
</script>

<?php
	require ($_include_path.'footer.inc.php');
?>
