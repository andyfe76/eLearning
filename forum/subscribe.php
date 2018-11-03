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
$_section[2][0] = $_template['subscription'];


//require($_include_path.'header.inc.php');
//echo '<h2><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h2>';

$pid = intval($_GET['pid']);

if ($_GET['us']) {
	$sql	= "DELETE FROM forums_subscriptions WHERE post_id=$pid AND member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);

} else {
	$sql	= "INSERT INTO forums_subscriptions VALUES ($pid, $_SESSION[member_id])";
	$result = mysql_query($sql, $db);
}
if ($_GET['us'] == '1'){
	Header('Location: '.$_base_href.'forum/view.php?fid='.$fid.';pid='.$pid.';f='.urlencode_feedback(AT_FEEDBACK_THREAD_UNSUBCRIBED));
	exit;
}else{
	Header('Location: '.$_base_href.'forum/view.php?fid='.$fid.';pid='.$pid.';f='.urlencode_feedback(AT_FEEDBACK_THREAD_SUBCRIBED));
	exit;
}

//require($_include_path.'footer.inc.php');
?>
