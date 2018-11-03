<?php

	$_include_path	='../../include/';
	require($_include_path.'vitals.inc.php');
	
	if ($_POST['submit']) {
		$tid = intval($_POST['tid']);
		
		
		$sql = "SELECT * FROM test_process WHERE member_id=$_SESSION[member_id] AND test_id=$tid";
		$res = $db->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$retries = $row['RETRIES'];
		
		if ($retries >0) {
			// decrease the number of retries
			if ($_SESSION['test_timing'] >0) {
				// keep the retries if reentry
			} else {
				$retries--;
			}
		}
		if ($_SESSION['test_timing'] >0) {
			// nothing
		} else {
			$_SESSION['test_timing'] = time();
		}

		$sql = "UPDATE test_process SET retries=$retries, S_TIME=$_SESSION[test_timing] WHERE member_id=$_SESSION[member_id] AND test_id=$tid";
		$res = $db->query($sql);
		Header('Location: ../take_test.php?tid='.$tid);
		exit;
	}
	
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
		$res = $db->query($sql);
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		$tid = intval($row['TEXT']);
		
		$sql = "SELECT * FROM tests WHERE test_id=$tid";
		$res1 = $db->query($sql);
		$row_t =$res1->fetchRow(DB_FETCHMODE_ASSOC);
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
	$course_id = intval($row['COURSE_ID']);
	$sql = "SELECT member_id FROM courses WHERE course_id=$course_id";
	//echo $sql.'<br>';
	$res = $db->query($sql);
	$row_c =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$mid = $row_c['MEMBER_ID'];
	
	//echo 's_mid: '.$_SESSION['member_id'].': '.$mid;
	//if ($_SESSION['member_id'] == $mid) {
	if ($_SESSION['c_instructor']) {
		// this is the instructor of this course
		Header('Location: edit_test.php?tid='.$tid.SEP.'tt='.$row_t['TITLE']);
		exit;
	} else {
		// regular user
		$test_action = 'tools/take_test.php';
	}
	
	if ($row_t['DURATION'] == 0) {
		$t_duration = $_template['unlimited_2'];
	} else {
		$t_duration = $row_t['DURATION'].' min';
	}
	
	require($_include_path.'header.inc.php');
	//echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	//echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	echo '<br><h2>'.$_template['take_test'].'</h2><br>';

	print_errors($errors);
	
	echo '<form action="'.$PHP_SELF.'" method="post" name="form">';
	echo '<input type="hidden" name="tid" value="'.$tid.'">';
	echo '<input type="hidden" name="tt" value="'.$row_t['TITLE'].'">';
	
	//***
	
	$sql="SELECT COUNT(member_id) FROM tests_status WHERE passed='yes' AND member_id=$_SESSION[member_id] AND test_id=$tid";
	$tres=$db->query($sql);
	$trow =$tres->fetchRow();
	if ($trow[0]>0) {
		//test already passed 
		print_feedback(AT_FEEDBACK_TEST_ALREADY_PASSED);
		require($_include_path.'footer.inc.php');
		exit;
	}
		
	//***
	
	$sql = "SELECT * FROM test_process WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
	$pres = $db->query($sql);
	$row_p =$pres->fetchRow(DB_FETCHMODE_ASSOC);
	$_SESSION['test_timing'] = $row_p['S_TIME'];
			
	if ($_SESSION['test_timing'] >0) {
		$duration = $row_t['DURATION']*60 - (time() - $_SESSION['test_timing']);
		if ($duration <0) {
			if ($row_p['RETRIES'] >0) {
				$retries = $row_p['RETRIES'] -1;
				$sql = "UPDATE test_process SET s_time=0, retries=$retries WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
			} else {
				print_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE); 
			}
		} else {
			$reentry = true;
			$retries = $row_p['RETRIES'];
			echo '<br><span class="small_red">'.$_template['test_reentry'].'</span><br>';
		}
	} else {
		//$_SESSION['test_timing'] = time(); -- not here, but only after submit
		if ($row_p['TEST_ID'] ==0) {
			/* it means the student is first time here */
			$retries = $row_t['RETRIES'];
			if ($_SESSION['test_timing'] == '') $_SESSION['test_timing'] = 0;
			$sql = "INSERT INTO test_process VALUES ($tid, $_SESSION[member_id], $retries, $_SESSION[test_timing])";
			$res = $db->query($sql);
			if (PEAR::isError($res)) {
				print_r($res);
				exit;
			}
		} else {
			$retries = $row_p['RETRIES'];
			if ($retries == 0) {
				print_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE);
				require($_include_path.'footer.inc.php');
				exit;
			} else {
				//$retries--; -- after submitting do decrease it in the DB. Not here.
			}
		}
	}
	
?>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="80%">
<tr>
	<th colspan="2" class="left">
&nbsp;<?php echo $row_t['TITLE'];  ?></th>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['test_duration']; ?>: </b></td>
	<td class="row1"><?php echo $t_duration; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['special_instructions']; ?>: </b></td>
	<td class="row1"><?php echo $row_t['INSTRUCTIONS']; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><b><?php echo $_template['test_retries']; ?>: </b></td>
	<td class="row1"><?php echo $retries; ?></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php 
	if ($retries >0) {
?>
	<tr>
		<td class="row1" colspan="2" align="center"><input type="submit" name="submit" class="button" value="<?php echo $_template['take_test']; ?>"></td>
	</tr>
<?php
	} else if ($reentry) {
	// for now just keep the same button / message. TBC
?>
	<tr>
		<td class="row1" colspan="2" align="center"><input type="submit" name="submit" class="button" value="<?php echo $_template['continue_test']; ?>"></td>
	</tr>
<?php
	}?>

</table>

<?php
	if ($retries >0) {
		echo '<input type="hidden" name="retry" value="1">';
	}
	echo '</form>';
	require ($_include_path.'footer.inc.php');
?>
