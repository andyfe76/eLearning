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

	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	if ($_POST['submit']) {

		$_POST['cid'] = intval($_POST['cid']);

		$result = $contentManager->deleteContent($_POST['cid']);

		unset($_SESSION['s_cid']);
		unset($_SESSION['from_cid']);
		Header('Location: ../index.php?f='.AT_FEEDBACK_CONTENT_DELETED);
		exit;
	} else if ($_POST['submit_no']) {
		Header('Location: ../index.php?cid='.$_POST['cid'].SEP.'f='.AT_FEEDBACK_CONTENT_DELETED);
		exit;
	}

	$_section[0][0] = $_template['delete_content'];

	require($_include_path.'header.inc.php');

	echo '<h3>'.$_template['delete_content'].'</h3>';

	$_GET['cid'] = intval($_GET['cid']);

	if ($_GET['cid'] == 0) {
		$errors[]=AT_ERROR_ID_ZERO;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

	$children = $contentManager->getContent($_GET['cid']);

	echo '<form action="'.$PHP_SELF.'" method="post">';
	echo '<input type="hidden" name="cid" value="'.$_GET['cid'].'">';
	echo '<p>';

	if (is_array($children) && (count($children)>0) ) {
		$warnings[]=AT_WARNING_SUB_CONTENT_DELETE;
		$warnings[]=AT_WARNING_GLOSSARY_REMAINS;
		//print_warnings($warnings);

	} else {
		$warnings[]=AT_WARNING_GLOSSARY_REMAINS;
		//print_warnings($warnings);
	}
	$warnings[]=AT_WARNING_DELETE_CONTENT;
	print_warnings($warnings);
	echo '<input type="submit" name="submit" value="'.$_template['yes_delete'].'" class="button">';
	echo ' - <input type="submit" name="submit_no" value="'.$_template['no_cancel'].'" class="button">';

	echo '</form>';
	echo '</p>';


	require($_include_path.'footer.inc.php');
?>
