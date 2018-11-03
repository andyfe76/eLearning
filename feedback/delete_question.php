<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */


	$_include_path	= '../include/';
	require($_include_path.'vitals.inc.php');

	$_section[0][0] = $_template['feedback'];
	$_section[0][1] = 'feedback/';


	if ($_GET['d']) {

		$qid = intval($_GET['qid']);

		$sql	= "DELETE FROM feedback_form WHERE q_id=$qid AND course_id=$_SESSION[course_id]";
		$result	= $db->query($sql);
		$sql	= "DELETE FROM user_feedback WHERE q_id=$qid AND course_id=$_SESSION[course_id]";
		$result	= $db->query($sql);
		
		Header('Location: questions.php?f='.urlencode_feedback(AT_FEEDBACK_QUESTION_DELETED));
		exit;
		//echo '<p>The test question has been deleted successfully. <a href="tools/tests/questions.php?tid='.$tid.'">Back to your test questions</a>.</p>';
	} else {
		require($_include_path.'header.inc.php');
		echo '<h2>Delete Question</h2>';
		print_warnings(AT_WARNING_DELETE_QUESTION);
		//echo '<p>Are you sure you want to delete this question?<br />';
		echo '<a href="feedback/delete_question.php?tid='.$_GET['tid'].SEP.'qid='.$_GET['qid'].SEP.'d=1">Yes/Delete</a>, <a href="tools/tests/questions.php?tid='.$_GET['tid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">No/Cancel</a>';
		echo '</p>';
	}

	require($_include_path.'footer.inc.php');
?>
