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

	$_include_path = 'include/';
	
	require ($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['inbox'];
	$_section[0][1] = 'inbox.php';



	$_GET['view'] = intval($_GET['view']);

	if ($_GET['view']) {
		$result = mysql_query("UPDATE messages SET new=0 WHERE to_member_id=$_SESSION[member_id] AND message_id=$_GET[view]",$db);
	}

	$current_path = '';

	require ($_include_path.'header.inc.php');


	require ($_include_path.'lib/inbox.inc.php');

	require ($_include_path.'footer.inc.php'); 
?>
