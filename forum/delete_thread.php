<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['discussions'];
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($_GET['fid']);
$_section[1][1] = 'forum/?fid='.$_GET['fid'];
$_section[2][0] = $_template['delete_thread'];

if ($_GET['d'] == '1') {
	$pid  = intval($_GET['pid']);
	$ppid = intval($_GET['ppid']);

	if ($ppid == 0) {
		$sql	= "DELETE FROM forums_threads WHERE (parent_id=$pid OR post_id=$pid) AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);


	} else {
		$sql	= "UPDATE forums_threads SET num_comments=num_comments-1 WHERE post_id=$ppid AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);

		$sql	= "DELETE FROM forums_threads WHERE post_id=$pid AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);

	}

	$sql	= "DELETE FROM forums_subscriptions WHERE post_id=$pid";
	$result = mysql_query($sql, $db);

	$sql	= "DELETE FROM forums_accessed WHERE post_id=$pid";
	$result = mysql_query($sql, $db);
	
	if ($ppid) {
		Header('Location: view.php?fid='.$fid.SEP.'pid='.$ppid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_MESSAGE_DELETED));
		exit;
	} else {
		Header('Location: '.$_base_href.'forum/?fid='.$fid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_THREAD_DELETED));
		exit;
	}
	//Header('Location: '.$_base_href.'forum/?fid='.$fid.';f='.urlencode_feedback(AT_FEEDBACK_THREAD_DELETED));
	//exit;
	//$feedback[]=AT_FEEDBACK_THREAD_DELETED;
	//print_feedback($feedback);

}




require($_include_path.'header.inc.php');
echo '<h2><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h2>';

if (!$_SESSION['is_admin']){
	$errors[]=AT_ERROR_ACCESS_DENIED;
	print_errors($errors);
	require($_include_path.'footer.inc.php');
	exit;
}

if (!$_GET['d']) {
	if($ppid=='' || $ppid =='0'){
		$warnings[]=AT_WARNING_DELETE_THREAD;
		//print_warnings($warnings);
	}else{
		$warnings[]=AT_WARNING_DELETE_MESSAGE;
		//print_warnings($warnings);
	}
	//$warnings[]=AT_WARNING_DELETE_THREAD;
	print_warnings($warnings);
	if (!$ppid){
		echo '<p><a href="'.$PHP_SELF.'?fid='.$_GET['fid'].SEP.'pid='.$_GET['pid'].SEP.'d=1'.SEP.'f='.urlencode_feedback(AT_FEEDBACK_THREAD_DELETED).'">'.$_template['yes_delete'].'</a>, <a href="forum/?fid='.$_GET['fid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></p>';

	}else{
		echo '<p><a href="'.$PHP_SELF.'?fid='.$_GET['fid'].SEP.'pid='.$_GET['pid'].SEP.'ppid='.$_GET['ppid'].SEP.'d=1'.SEP.'f='.urlencode_feedback(AT_FEEDBACK_MESSAGE_DELETED).'">'.$_template['yes_delete'].'</a>, <a href="forum/?fid='.$_GET['fid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></p>';

	}
	//echo '<p><a href="'.$PHP_SELF.'?fid='.$_GET['fid'].SEP.'pid='.$_GET['pid'].SEP.'ppid='.$_GET['ppid'].SEP.'d=1">Yes/Delete</a>, <a href="forum/?fid='.$_GET['fid'].';f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">No/Cancel</a></p>';
} else {
	$pid  = intval($_GET['pid']);
	$ppid = intval($_GET['ppid']);

	if ($ppid == 0) {
		$sql	= "DELETE FROM forums_threads WHERE (parent_id=$pid OR post_id=$pid) AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);


	} else {
		$sql	= "UPDATE forums_threads SET num_comments=num_comments-1 WHERE post_id=$ppid AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);

		$sql	= "DELETE FROM forums_threads WHERE post_id=$pid AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $db);

	}

	$sql	= "DELETE FROM forums_subscriptions WHERE post_id=$pid";
	$result = mysql_query($sql, $db);

	$sql	= "DELETE FROM forums_accessed WHERE post_id=$pid";
	$result = mysql_query($sql, $db);

	$feedback[]=AT_FEEDBACK_THREAD_DELETED;
	print_feedback($feedback);


} 

require($_include_path.'footer.inc.php');
?>
