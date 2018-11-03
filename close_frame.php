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

	$_include_path	='include/';
	$_section = 'Home';
	$_ignore_page = true; /* without this we wouldn't know where we're supposed to go */
	require($_include_path.'vitals.inc.php');

	Header('Location: '.$_SESSION['my_referer']);
?>
