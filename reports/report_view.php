<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>K-Lore Report Viewer</TITLE>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style>
	* {font-size: 8pt;}
</style>

</HEAD>
<BODY>
<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');


	$course_enrollment = false;
	$course = false;
	$test = false;
	$members = false;
	$sql_buf = "SELECT ";

	
	
	// columns:
	$report_id = $_POST['report_id'];
	if ($report_id == '') $report_id = $_GET['report_id'];
		
	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = mysql_query($sql);
	$count = 0;
	while ($row = mysql_fetch_array($res)) {
		if ($count >0) $sql_buf .= ', ';
		if ($row['attr'] == 'Enrolled member') {
			$course_enrollment = true;
			$members = true;
		}
		if ($row['cat'] == 'Course') {
			$course = true;
		}
		 if ($row['cat'] == 'Test') {
			$test = true;
		} 
		if ($row['cat'] == 'Student') {
			$members = true;
		}
		$sql = "SELECT * FROM report_definitions WHERE cat='$row[cat]' AND attr='$row[attr]'";
		$res2 = mysql_query($sql);
		if ( $row2 = mysql_fetch_array($res2) ) {
			$all_tables .= $row2['tbl'];
			$sql_buf .= $row2['tbl'].'.'.$row2['field'];
		}
		$count++;
	}

	// queries
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = mysql_query($sql);
	$q = '';
	while( $row = mysql_fetch_array($res) ) {
		if ($row['attr'] == "Enrolled member") {
			$course_enrollment = true;
			$members = true;
		}
		if ($row['cat'] == 'Course') {
			$course = true;
		} 
		if ($row['cat'] == 'Test') {
			$test = true;
		}
		if (($row['cat'] == 'Student') || ($row['attr']=='Trainer') || ($row['attr']=='Instructor')) {
			$members = true;
		}
		$sql = "SELECT * FROM report_definitions WHERE cat='$row[cat]' AND attr='$row[attr]'";
		$res2 = mysql_query($sql);
		if ($res2) {
			$row2 = mysql_fetch_array($res2);
			$q .=  ' '.$row['function'].' '.$row2['tbl'].'.'.$row2['field'].' '.$row['op'].' \''.$row['val'].'\'';
		}
		
	}

	if ($_SESSION['debug']) echo '<br>course: '.$course.'; test: '.$test.'; members: '.$members.'<br>';
	
	$sql_buf .= " FROM ";
	
	$tables = '';
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		$sql = "SELECT * FROM report_definitions WHERE cat=$row[cat] AND attr=$row[attr]";
		$res2 = mysql_query($sql);
		if ($res2) {
			$row2 = mysql_fetch_array($res2);
			$table = $row2['tbl'];
			$field = $row2['field'];
		}
		$publish = true;
		if (!$course_enrollment) {
			if ($table == 'course_enrollment') $publish = false;
		}
		if (!$course) {
			if (($table=='courses') || ($table=='crel_groups') || ($table=='course_groups')) $publish = false;
		}
		if (!$test) {
			if (($table=='test_results') || ($table=='test_status')) $publish = false;
		}
		if (!$members) {
			if (($table=='members') || ($table=='mrel_groups') || ($table=='member_groups') || ($table=='member_categ')) $publish = false;
		}
		
		if ($publish) $tables .= $table.', ';
	}
 
	// check table inter-relations
	$sql = "SELECT * FROM report_links";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		$table = $row['cat1'];
		$publish = true;
		if (!$course_enrollment) {
			if ($table=='course_enrollment') $publish = false;
		}
		if (!$course) {
			if (($table=='courses') || ($table=='crel_groups') || ($table=='course_groups')) $publish = false;
		}
		if (!$test) {
			if (($table=='test_results') || ($table=='test_status')) $publish = false;
		}
		if (!$members){
			if (($table=='members') || ($table=='mrel_groups') || ($table=='member_groups') || ($table=='member_categ')) $publish = false;
		}
		if ($publish) $tables .= $table.', ';
 
	  	$table = $row['cat2'];
	  	$publish = true;
	  	if (!$course_enrollment) {
			if ($table=='course_enrollment') $publish = false;
		}
		if (!$course) {
			if (($table=='courses') || ($table=='crel_groups') || ($table=='course_groups')) $publish = false;
		}
		if (!$test) {
			if (($table=='test_results') || ($table=='test_status')) $publish = false;
		}
		if (!$members){
			if (($table=='members') || ($table=='mrel_groups') || ($table=='member_groups') || ($table=='member_categ')) $publish = false;
		}
		if ($publish) $tables .= $table.', ';
	}
	
	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		$sql = "SELECT * FROM report_definitions WHERE cat=$row[cat] AND attr=$row[attr]";
		$res2 = mysql_query($sql);
		if ($res2) {
			$row2 = mysql_fetch_array($res2);
			$table = $row2['tbl'];
			$field = $row2['field'];
		}
		$publish = true;
		$cat = $row['cat'];
		$attr = $row['attr'];
		if (!$course_enrollment) {
			if ($cat=='course_enrollment') $publish = false;
		}
		if (!$course) {
			if (($cat=='courses') || ($cat=='crel_groups') || ($cat=='course_groups')) $publish = false;
		}
		if (!$test) {
			if (($cat=='test_results') || ($cat=='test_status')) $publish = false;
		}
		if (!$members) {
			if (($cat=='members') || ($cat=='mrel_groups') || ($cat=='member_groups') || ($cat=='member_catg')) $publish=false;
		}
		if ($publish) $tables .= $table.', ';
	}
	
	$tables2 = '';
	$a1 = 0;
	$t = 0;
	
	do {
		$a2 = strpos($tables, ',', $a1);
		$table_tmp = substr($tables, $a1, $a2-$a1);
		if (strlen($table_tmp) >1) {
			if (!strstr($tables2, $table_tmp) ) {
				if (strlen($tables2) >1) {
					$tables2 .= ", ";
				}
				$tables2 .= $table_tmp;
			}
		}
		$a1 = $a2 +1;
		$t++;
	} while ( ($a1 < strlen($tables)) && ($t<100) ); // just to be sure it doesn't loop indefinitelly
	
	$sql_buf .= $tables2;
	
	$sql_buf .= " WHERE ";
	
	// links
	$sql = "SELECT * FROM report_links";
	$res = mysql_query($sql);
	$count = 0;
	while ($row = mysql_fetch_array($res)) {
		$publish = true;
		if (!$course_enrollment) {
			if (($row['cat1']=='course_enrollment') || ($row['cat2']=='course_enrollment')) $publish = false;
		}
		if (!$course) {
			if (($row['cat1']=='courses') || ($row['cat1']=='crel_groups') || ($row['cat1']=='course_groups') ||
			($row['cat2']=='courses') || ($row['cat2']=='crel_groups') || ($row['cat2']=='course_groups')) $publish = false;
		}
		if (!$test) {
			if (($row['cat1']=='test_result') || ($row['cat1']=='test_status') || 
			($row['cat2']=='test_result') || ($row['cat2']=='test_status')) $publish=false;
		}
		if (!$members) {
			if (($row['cat1']=='members') || ($row['cat1']=='mrel_groups') || ($row['cat1']=='member_groups') || ($row['cat1']=='member_categ') ||
			($row['cat2']=='members') || ($row['cat2']=='mrel_groups') || ($row['cat2']=='member_groups') || ($row['cat2']=='member_categ')) $publish=false;
		}


		if ($publish) {
			if ($count >0) $sql_buf .= ' AND ';
			$sql_buf .= $row['cat1'].'.'.$row['attr1'].'='.$row['cat2'].'.'.$row['attr2'];
			$count++;
		}
	}
	
 	// sql queries

 	$sql_buf .= $q;

if ($_SESSION['debug']) echo $sql_buf;
 	?>
 	
 	
 <TABLE class="bodyline" border="0" cellpadding="0" cellspacing="1" align="center" width="75%">
  <?php
 
 	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
 	$res = mysql_query($sql);
 	echo '<tr>';
 	while ($row = mysql_fetch_array($res)){
 		echo '<th>'.$row['cat'].'.'.$row['attr'].'</th>';
 	}
 	echo '</tr>';
 
 	$res = mysql_query($sql_buf);
 	while ($row = mysql_fetch_array($res)){
 		echo '<tr>';
 		foreach ($row as $f=>$fv) {
 			if ( !is_int($f) ) {
 				echo '<td>'.$fv.'&nbsp;</td>';
 			}
 		}
 		echo '</tr>';
 	}
 ?>
 </TABLE>


 <br>
<center>
<table border="0" align="center" width="75%">
<tr><td>
	<input type="button" class="button" name="export" value="Export to Excel" onclick="javascript:void(window.location='export.php?report_id=<%=report_id%>');"></td>
<td>
	<A href="index.php">Return to Reports Home</a>
</td><td>
	<input type="button" class="button" name="print" value="Print" onclick="javascript:void(window.print());">
</td>
</tr></table>
<BR>
</center>
</BODY>
</HTML>