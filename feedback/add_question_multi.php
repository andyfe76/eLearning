<?php

	$_include_path	= '../include/';
	require($_include_path.'vitals.inc.php');

	$_section[0][0] = $_template['feedback'];
	$_section[0][1] = 'feedback/';

	if ($_POST['submit']) {
		
		$_POST['question'] = trim($_POST['question']);
		$_POST['tid']	   = intval($_POST['tid']);


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
			
			$qid = $db->nextId("AUTO_FEEDBACK_FORM_SEQ");
			$sql	= "INSERT INTO feedback_form VALUES (	$_SESSION[course_id], 
				'$_POST[question]',
				$qid,
				1,
				'{$_POST[choice][0]}<~>{$_POST[choice][1]}<~>{$_POST[choice][2]}<~>{$_POST[choice][3]}<~>{$_POST[choice][4]}<~>{$_POST[choice][5]}<~>{$_POST[choice][6]}<~>{$_POST[choice][7]}<~>{$_POST[choice][8]}<~>{$_POST[choice][9]}<~>{$_POST[choice][10]}'
				)";
			$result	= $db->query($sql);
			//echo $sql; exit;	
			Header('Location: questions.php?tid='.$_POST['tid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_QUESTION_ADDED));
			exit;
		}
	}

	require($_include_path.'header.inc.php');

?>
<h3><?php echo $_template['add_mc_question']; ?>
<?php echo $_template['feedback']; ?></h3>
<?PHP
		print_errors($errors);
?>
<form action="feedback/add_question_multi.php" method="post" name="form">
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ADD_MC_QUESTION);  ?>
<?php echo $_template['new_mc_question']; ?> </th>
</tr>

<tr>
	<td class="row1" align="right" valign="top"><label for="ques"><b><?php echo $_template['question']; ?>:</b></label></td>
	<td class="row1"><textarea id="ques" cols="50" rows="6" name="question" class="formfield"><?php 
		echo htmlspecialchars(stripslashes($_POST['question'])); ?></textarea></td>
</tr>

<?php for ($i=0; $i<11; $i++) { ?>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="choice_<?php echo $i; ?>"><b><?php echo $_template['choice']; ?>
<?php
			echo ($i+1); ?>:</b></label>
			<br />
		</td>
		<td class="row1"><textarea id="choice_<?php echo $i; ?>" cols="50" rows="6" name="choice[<?php echo $i; ?>]" class="formfield"><?php 
			echo htmlspecialchars(stripslashes($_POST['choice'][$i])); ?></textarea></td>
	</tr>
<?php } ?>

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
