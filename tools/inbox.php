<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



	$_include_path = 'include/';
	
	require ($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['inbox'];
	$_section[0][1] = 'inbox.php';



	$_GET['view'] = intval($_GET['view']);

	if ($_GET['view']) {
		$result = $db->query("UPDATE messages SET new=0 WHERE to_member_id=$_SESSION[member_id] AND message_id=$_GET[view]");
	}

	$current_path = '';

	require ($_include_path.'header.inc.php');


	require ($_include_path.'lib/inbox.inc.php');

	require ($_include_path.'footer.inc.php'); 
?>
