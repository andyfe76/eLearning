<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



	$_include_path	='include/';
	$_section = 'Home';
	$_ignore_page = true; /* without this we wouldn't know where we're supposed to go */
	require($_include_path.'vitals.inc.php');

	Header('Location: '.$_SESSION['my_referer']);
?>
