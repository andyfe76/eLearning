<?php
/****************************************************************/
/* klore														*/
/****************************************************************/




$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = 'Discussions';
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($_GET['fid']);
$_section[1][1] = 'forum/?fid='.$_GET['fid'];
$_section[2][0] = 'Stick Thread';
$pid  = intval($_GET['pid']);
if (!$errors) {

	$sql	= "UPDATE forums_threads SET sticky=ABS(sticky-1) WHERE post_id=$pid AND course_id=$_SESSION[course_id]";
	$result = $db->query($sql);
	//Header('Location: '.$_base_href.'discussions/?fid='.$fid.';f='.urlencode_feedback(AT_FEEDBACK_STICKY_UPDATED));
	Header('Location: '.$_base_href.'forum/?fid='.$_GET['fid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_STICKY_UPDATED));
	exit;
}
require($_include_path.'header.inc.php');
echo '<h2><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h2>';

if (!$_SESSION['is_admin']){
	$errors[]=AT_ERROR_ACCESS_DENIED;
	print_errors($errors);
	require($_include_path.'footer.inc.php');
	exit;
}







echo '<p><b>Thread stickyness has been changed.</b></p>';


require($_include_path.'footer.inc.php');
?>
