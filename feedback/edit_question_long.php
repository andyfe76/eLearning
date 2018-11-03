<?php
	$_include_path	= '../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['feedback'];
	$_section[0][1] = 'feedback/';

	$qid = intval($_GET['qid']);
	if ($qid == 0){
		$qid = intval($_POST['qid']);
	}


	if ($_POST['submit']) {
		$_POST['question'] = trim($_POST['question']);

		if ($_POST['question'] == ''){
			$errors[]=AT_ERRORS_QUESTION_EMPTY;
		}

		if (!$errors) {

			
			$sql	= "UPDATE feedback_form SET	question='$_POST[question]' WHERE q_id=$_POST[qid] AND course_id=$_SESSION[course_id]";
			$result	= $db->query($sql);
			
			if (PEAR::isError($result)) {
					echo $sql.'<br><br>';
					print_r($result);
					exit;
				}
				
			Header('Location: questions.php?tid=f='.urlencode_feedback(AT_FEEDBACK_QUESTION_UPDATED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');
?>
<h3><?php echo $_template['edit_open_question']; ?> <?php echo $_template['feedback']; ?></h3>


<?php
	if (!$_POST['submit']) {
		$sql	= "SELECT * FROM feedback_form WHERE q_id=$qid AND course_id=$_SESSION[course_id]";
		$result	= $db->query($sql);

		if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$errors[]=AT_ERROR_QUESTION_NOT_FOUND;
			print_errors($errors);
			require ($_include_path.'footer.inc.php');
			exit;
		}

		$_POST	= $row;
	}


print_errors($errors);

?>
<form action="feedback/edit_question_long.php" method="post" name="form">
<input type="hidden" name="qid" value="<?php echo $qid; ?>" />
<br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php echo $_template['edit_open_question1']; ?></th>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>

<tr>
	<td class="row1" align="right" valign="top"><label for="ques"><b><?php echo $_template['question']; ?>:</b></label></td>
	<td class="row1"><textarea id="ques" cols="50" rows="6" name="question" class="formfield"><?php 
		echo htmlspecialchars(stripslashes($_POST['QUESTION'])); ?></textarea></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><input type="submit" value="<?php echo $_template['save_test_question']; ?> Alt-s" class="button" name="submit" accesskey="s" /></td>
</tr>
</table>
<br />
<br />
</form>

<?php
	require ($_include_path.'footer.inc.php');
?>
