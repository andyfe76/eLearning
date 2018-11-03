<?
if ((!$_SESSION['c_instructor'])||(!$_SESSION['is_admin'])){
	
	require ($_include_path.'header.inc.php');
	echo "<br><br>";	
	print_errors(AT_ERROR_ACCESS_DENIED);
	require ($_include_path.'footer.inc.php');
	exit;
	}
?>