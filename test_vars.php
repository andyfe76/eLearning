<?php
	$section = 'users';
	$_include_path = 'include/';
	
	require($_include_path.'vitals.inc.php');
	require($_include_path.'dynupdate.php');
	$sql = "INSERT INTO sql_tq19 VALUES (23)";
	$res = $db->query($sql);
	$sql = "SELECT * FROM sql_tq19";
	$res = $db->query($sql);
	print_r($res);
	echo '<br><br>';
	echo 'DEBUG: ';
	$row = $res->fetchRow();
	echo $row[0];
?>