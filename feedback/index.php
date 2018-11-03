<?php
/****************************************************************/
/* klore														*/
/****************************************************************/

$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');
require ($_include_path.'header.inc.php');

$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['feedback'];

if (($_SESSION['c_instructor'])||($_SESSION['is_admin'])|| ($_SESSION['is_super_admin'])){
	
	echo '<br><br><a href="feedback/questions.php">Edit Questions</a>'; 
	
	if ($_GET['view']==1) {
		
		echo '<br><a href="feedback/?view=2">Summary view</a><br><br>';
		include('preview.inc.php');
		
	}else {
		
		echo '<br><a href="feedback/?view=1">Detail view</a><br><br>';
		include('preview2.inc.php');
	}
	
	
	
	
}else{
	include('submit_fb.inc.php');
}
	
	
	require($_include_path.'footer.inc.php');
?>