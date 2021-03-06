<?php
	$_include_path	= '../../include/';
	require($_include_path.'vitals.inc.php');

	$tid = intval($_GET['tid']);
	if ($tid == 0){
		$tid = intval($_POST['tid']);
	}

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests/';
	$_section[2][0] = $_template['questions'];
	$_section[2][1] = 'tools/tests/questions.php?tid='.$tid;
	$_section[3][0] = $_template['add_question'];

	if ($_POST['submit']) {
		$_POST['required'] = intval($_POST['required']);
		$_POST['feedback'] = trim($_POST['feedback']);
		$_POST['question'] = trim($_POST['question']);
		$_POST['tid']	   = intval($_POST['tid']);
		$_POST['weight']   = intval($_POST['weight']);
		$_POST['answer_size'] = intval($_POST['answer_size']);

		if ($_POST['question'] == ''){
			$errors[]=AT_ERRORS_QUESTION_EMPTY;
		}

		if (!$errors) {

			for ($i=0; $i<10; $i++) {
				$_POST['choice'][$i] = trim($_POST['choice'][$i]);
				$_POST['answer'][$i] = intval($_POST['answer'][$i]);

				if ($_POST['choice'][$i] == '') {
					/* an empty option can't be correct */
					$_POST['answer'][$i] = 0;
				}
			}

			$sql	= "INSERT INTO tests_questions VALUES (	0,
				$_POST[tid],
				$_SESSION[course_id],
				0,
				3,
				$_POST[weight],
				$_POST[required],
				'$_POST[feedback]',
				'$_POST[question]',
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
				$_POST[answer_size])";
			$result	= mysql_query($sql, $db);

			Header('Location: questions.php?tid='.$_POST['tid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_QUESTION_ADDED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');
?>

<h2><a href="tools/?g=11"><?php echo $_template['tools']; ?></a></h2>
<h3><a href="tools/tests/?g=11"><?php echo $_template['test_manager']; ?></a></h3>
<h3><?php echo $_template['add_open_question']; ?>
<?php echo $_SESSION['test_name']; ?></h3>

<?php
print_errors($errors);

?>
<form action="tools/tests/add_question_long.php" method="post" name="form">
<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ADD_OPEN_QUESTION);  ?>
<?php echo $_template['new_open_question']; ?></th>
</tr>
<input type="hidden" name="required" value="1" />
<!-- other question options for a future release of klore -->
<!--tr>
	<td class="row1" align="right"><b>Required:</b></td>
	<td class="row1"><input type="radio" name="required" value="1" id="req1" checked="checked" /><label for="req1">yes</label>, <input type="radio" name="required" value="0" id="req2" /><label for="req2">no</label></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr-->
<tr>
	<td class="row1" align="right"><label for="weight"><b><?php echo $_template['weight']; ?>:</b></label></td>
	<td class="row1"><input type="text" value="5" name="weight" id="weight" class="formfieldR" size="2" maxlength="2" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="feedback"><b><?php echo $_template['feedback']; ?>:</b></label></td>
	<td class="row1"><textarea id="feedback" cols="50" rows="3" name="feedback" class="formfield"><?php 
		echo htmlspecialchars(stripslashes($_POST['feedback'])); ?></textarea></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="ques"><b><?php echo $_template['question']; ?>:</b></label></td>
	<td class="row1"><textarea id="ques" cols="50" rows="6" name="question" class="formfield"><?php 
		echo htmlspecialchars(stripslashes($_POST['question'])); ?></textarea></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="answer_size"><b><?php echo $_template['answer_size']; ?>:</b></label></td>
	<td class="row1"><select name="answer_size" id="answer_size">
						<option value="1"><?php echo $_template['one_word']; ?></option>
						<option value="2"><?php echo $_template['one_sentence']; ?></option>
						<option value="3"><?php echo $_template['short_paragraph']; ?></option>
						<option value="4"><?php echo $_template['one_page']; ?></option>
					 </select></td>
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
