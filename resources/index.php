<?php

	Header('Location: links/?g=29');
	exit;

	$_include_path = '../include/';
	require ($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['resources'];

	require ($_include_path.'header.inc.php');

	echo '<h1>' . $_template['resources'] . '</h1><br>';

	require ($_include_path.'language/en_resources_page.inc.php');
	require ($_include_path.'footer.inc.php');
?>