<?
if ($_SESSION['status']==STATUS_STUDENT){
	
	//require ($_include_path.'header.inc.php');
	echo "<br><br>";	
	print_errors(AT_ERROR_ACCESS_DENIED);
	//require ($_include_path.'footer.inc.php');
	exit;
	}
?>