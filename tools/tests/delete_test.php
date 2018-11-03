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
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests';
	$_section[2][0] = $_template['delete_test'];

	if ($_GET['d']) {
		$tid = intval($_GET['tid']);

		$sql	= "DELETE FROM tests_questions WHERE test_id=$tid AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $db);

		$sql	= "DELETE FROM tests WHERE test_id=$tid AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $db);

		/* it has to delete the results as well... */
		$sql	= "SELECT result_id FROM tests_results WHERE test_id=$tid";
		$result	= mysql_query($sql, $db);
		if ($row = mysql_fetch_array($result)) {
			$result_list = '('.$row['result_id'];

			while ($row = mysql_fetch_array($result)) {
				$result_list .= ','.$row['result_id'];
			}
			$result_list .= ')';
		}

		if ($result_list != '') {
			$sql	= "DELETE FROM tests_answers WHERE result_id IN $result_list";
			$result	= mysql_query($sql, $db);


			$sql	= "DELETE FROM tests_results WHERE test_id=$tid";
			$result	= mysql_query($sql, $db);
		}

		$feedback[]=AT_FEEDBACK_TEST_DELETED;
		Header('Location: ../tests/?f='.urlencode_feedback(AT_FEEDBACK_TEST_DELETED));
		exit;
		//print_feedback($feedback);
		//echo '<p>The test has been deleted successfully. <a href="tools/tests/">Back to your tests</a>.</p>';
	} else {
		require($_include_path.'header.inc.php');
		echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
		echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
		echo '<h3>'.$_template['delete_test'].'</h3>';
		$warnings[]=array(AT_WARNING_DELETE_TEST, $_GET['tt']);
		print_warnings($warnings);
		//echo '<p>Are you sure you want to delete this test?<br />';
		echo '<a href="tools/tests/delete_test.php?tid='.$_GET['tid'].SEP.'d=1">'.$_template['yes_delete'].'</a>, <a href="tools/tests/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a>';
		//echo '</p>';
	}
 
	require($_include_path.'footer.inc.php');
?>
