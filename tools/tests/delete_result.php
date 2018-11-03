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
	$_section[2][0] = $_template['results'];
	$_section[2][1] = 'tools/tests/results.php?tid='.$_GET['tid'];
	$_section[3][0] = $_template['delete_results'];

	if ($_GET['d']) {
		$tid = intval($_GET['tid']);
		$rid = intval($_GET['rid']);

		$sql	= "DELETE FROM tests_answers WHERE result_id=$rid";
		$result	= mysql_query($sql, $db);

		$sql	= "DELETE FROM tests_results WHERE result_id=$rid";
		$result	= mysql_query($sql, $db);
		Header('Location: ../tests/results.php?tid='.$_GET['tid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_RESULT_DELETED));
		exit;
	} else {
		require($_include_path.'header.inc.php');
		echo '<h2>'.$_template['delete_results'].'</h2>';
		$warnings[]=array(AT_WARNING_DELETE_RESULTS, $_GET['tt']);
		print_warnings($warnings);

		echo '<a href="tools/tests/delete_result.php?tid='.$_GET['tid'].SEP.'rid='.$_GET['rid'].SEP.'d=1'.SEP.'tt='.$_GET['tt2'].SEP.'m='.$_GET['m'].'">'.$_template['yes_delete'].'</a>, <a href="tools/tests/results.php?tid='.$_GET['tid'].SEP.'tt='.$_GET['tt2'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'m='.$_GET['m'].'">'.$_template['no_cancel'].'</a>';

	}

	require($_include_path.'footer.inc.php');
?>