<?php
	$_include_path	= '../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['feedback'];
	$_section[0][1] = 'feedback/';

	if ($_POST['submit']) {
		$_POST['question'] = trim($_POST['question']);


		if ($_POST['question'] == ''){
			$errors[]=AT_ERRORS_QUESTION_EMPTY;
		}

		if (!$errors) {

						
			$qid = $db->nextId("AUTO_FEEDBACK_FORM_SEQ");
			$sql	= "INSERT INTO feedback_form VALUES ($_SESSION[course_id],'$_POST[question]',$qid,2,'')";
			$result	= $db->query($sql);

			if (PEAR::isError($result)) {
					print_r($result);
					exit;
				}
			
			Header('Location: questions.php?f='.urlencode_feedback(AT_FEEDBACK_QUESTION_ADDED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');
?>

<h3><?php echo $_template['add_open_question']; ?>
<?php echo $_template['feedback']; ?></h3>

<?php
print_errors($errors);

?>
<form action="feedback/add_question_long.php" method="post" name="form">
<br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ADD_OPEN_QUESTION);  ?>
<?php echo $_template['new_open_question']; ?></th>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="ques"><b><?php echo $_template['question']; ?>:</b></label></td>
	<td class="row1"><textarea id="ques" cols="50" rows="6" name="question" class="formfield"><?php 
		echo htmlspecialchars(stripslashes($_POST['question'])); ?></textarea></td>
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
