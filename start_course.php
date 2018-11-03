<?php
	$_include_path	='include/';
	$_section = 'Home';
	require($_include_path.'vitals.inc.php');
	
		// select first chapter -- should always be Course Synthesis
		$sql = "SELECT content_id FROM content WHERE course_id=$_SESSION[course_id] AND content_parent_id=0 ORDER BY ordering";
		$res = $db->query($sql);
		if (PEAR::isError($res)){
			print_r($res);
			exit;
		}
		$row = $res->fetchRow();
		$cid = $row[0];
		// /Course Synthesis selected.
		
		$_SESSION['presentation'] = true;
		Header('Location: ./index.php?cid='.$cid);
?>