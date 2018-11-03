<?
//ADD $allow=array(0,1,2,3,4,5); in each file wich needs restriction;



if (is_array($allow)) {
 if ($_SESSION['status']) {

	if (!in_array($_SESSION['status'],$allow)) {
		print_r($allow);echo "<br>status=".$_SESSION['status'];
		//require ($_include_path.'header.inc.php');
		echo "<br><br>";	
		print_errors(AT_ERROR_ACCESS_DENIED);
		//require ($_include_path.'footer.inc.php');
		exit;
		
	}
 }	
}else {//remove "else when done";
	
	//echo "<br><font size=2 color=red> Set the permissions (if needed) for this file : '<b>$PHP_SELF</b>' (\$allow[]) </font><br>(see : include/policy_check.inc.php)<br>";
}

	//echo "status=".$_SESSION['status']." >=? IN ?=-> <font size=-5>";print_r($allow);echo "</font>";

?>