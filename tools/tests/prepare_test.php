<?php

	$_include_path	='../../include/';
	require($_include_path.'vitals.inc.php');
	
	if ($_GET['cid'] == '') {
		$errors[] = AT_ERROR_UNKNOWN;
	}
	
	if (isset($_GET['cid'])){
		$cid = intval($_GET['cid']);
	} else if (isset($_POST['cid'])) {
		$cid = intval($_POST['cid']);
	} else {
		$errors[] = AT_ERROR_UNKNOWN;
		Header('Location: tools/tests/index.php');
	}
	
	if ($cid>0) {
		$sql = "SELECT text, course_id FROM content WHERE content_id=$cid";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$tid = intval($row['text']);
		
		$sql = "SELECT * FROM tests WHERE test_id=$tid";
		$res1 = mysql_query($sql);
		$row_t = mysql_fetch_array($res1);
	} else {
		require($_include_path.'header.inc.php');
		echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
		echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
		echo '<h2>'.$_template['take_test'].'</h2>';

		print_errors($errors);
		require ($_include_path.'footer.inc.php');
		exit;
	}
	// check -> if instructor of this course --> edit test instead of taking it
	$course_id = intval($row['course_id']);
	$sql = "SELECT member_id FROM courses WHERE course_id=$course_id";
	//echo $sql.'<br>';
	$res = mysql_query($sql);
	$row_c = mysql_fetch_array($res);
	$mid = $row_c['member_id'];
	
	//echo 's_mid: '.$_SESSION['member_id'].': '.$mid;
	//if ($_SESSION['member_id'] == $mid) {
	if ($_SESSION['c_instructor']) {
		// this is the instructor of this course
		Header('Location: edit_test.php?tid='.$tid.SEP.'tt='.$row_t['title']);
		exit;
	} else {
		// regular user
		$test_action = 'tools/take_test.php';
	}
	if ($row_t['duration'] == 0) {
		$t_duration = $_template['unlimited_2'];
	} else {
		$t_duration = $row_t['duration'].' min';
	}
	
	require($_include_path.'header.inc.php');
	//echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	//echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	echo '<br><h2>'.$_template['take_test'].'</h2><br>';

	print_errors($errors);
	
	echo '<form action="tools/take_test.php" method="post" name="form">';
	echo '<input type="hidden" name="tid" value="'.$tid.'">';
	echo '<input type="hidden" name="tt" value="'.$row_t['title'].'">';
	
	$sql = "SELECT * FROM test_process WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
	$pres = mysql_query($sql, $db);
	$row_p = mysql_fetch_array($pres);

	if ($_SESSION['test_timing'] >0) {
		$duration = $duration - (time() - $_SESSION['test_timing']);
		if ($duration <0) {
			if ($row_p['retries'] >0) {
				$retries = $row_p['retries'];
			} else {
				print_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE);
			}
		} else {
			$reentry = true;
			echo '<span class="small_red">'.$_template['test_reentry'].'</span><br>';
		}
	} else {
		//$_SESSION['test_timing'] = time();
		if ($row_p['test_id'] ==0) {
			/* it means the student is first time here */
			$retries = $row_t['retries'];
			$sql = "INSERT INTO test_process VALUES ($tid, $_SESSION[member_id], $retries)";
			$res = mysql_query($sql, $db);
		} else {
			$retries = $row_p['retries'];
			if ($retries == 0) {
				print_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE);
			} else {
				$retries--;
			}
		}
	}
?>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="80%">
<tr>
	<th colspan="2" class="left">
&nbsp;<?php echo $row_t['title'];  ?></th>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['test_duration']; ?>: </b></td>
	<td class="row1"><?php echo $t_duration; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['special_instructions']; ?>: </b></td>
	<td class="row1"><?php echo $row_t['instructions']; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['test_retries']; ?>: </b></td>
	<td class="row1"><?php echo $retries; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><input type="submit" class="button" name="ok" value="<?php echo $_template['take_test']; ?>"></td>
</tr>


</table>

<?php
	if ($retries >0) {
		echo '<input type="hidden" name="retry" value="1">';
	}
	echo '</form>';
	require ($_include_path.'footer.inc.php');
?>
