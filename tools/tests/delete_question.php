<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = 'Tools';
	$_section[0][1] = 'tools/';
	$_section[1][0] = 'Tests';
	$_section[1][1] = 'tools/tests';
	$_section[2][0] = 'Questions';
	$_section[2][1] = 'tools/tests/questions.php?tid='.$_GET['tid'];
	$_section[3][0] = 'Delete Question';




	if ($_GET['d']) {
		$tid = intval($_GET['tid']);
		$qid = intval($_GET['qid']);

		$sql	= "DELETE FROM tests_questions WHERE question_id=$qid AND test_id=$tid AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $db);
		
		Header('Location: ../tests/questions.php?tid='.$tid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_QUESTION_DELETED));
		exit;
		//echo '<p>The test question has been deleted successfully. <a href="tools/tests/questions.php?tid='.$tid.'">Back to your test questions</a>.</p>';
	} else {
		require($_include_path.'header.inc.php');
		echo '<h2>Delete Question</h2>';
		print_warnings(AT_WARNING_DELETE_QUESTION);
		//echo '<p>Are you sure you want to delete this question?<br />';
		echo '<a href="tools/tests/delete_question.php?tid='.$_GET['tid'].SEP.'qid='.$_GET['qid'].SEP.'d=1">Yes/Delete</a>, <a href="tools/tests/questions.php?tid='.$_GET['tid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">No/Cancel</a>';
		echo '</p>';
	}

	require($_include_path.'footer.inc.php');
?>
