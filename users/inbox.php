<?php
	$section = 'users';
	$_include_path = '../include/';
	require ($_include_path.'vitals.inc.php');

	$_GET['view'] = intval($_GET['view']);

	if ($_GET['view']) {
		$result = mysql_query("UPDATE messages SET new=0 WHERE to_member_id=$_SESSION[member_id] AND message_id=$_GET[view]",$db);
	}

	$current_path = 'users/';

	require ($_include_path.'cc_html/header.inc.php');


	require ($_include_path.'lib/inbox.inc.php');

	require ($_include_path.'cc_html/footer.inc.php');
?>