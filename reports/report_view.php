<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	function quote_csv($line) {
		$line = str_replace('"', '""', $line);
	
		$line = str_replace("\n", '\n', $line);
		$line = str_replace("\r", '\r', $line);
		$line = str_replace("\x00", '\0', $line);
	
		return '"'.$line.'"';
	}

	$course_enrollment = false;
	$course = false;
	$test = false;
	$members = false;
	$sql_buf = "SELECT DISTINCT members.member_id, ";
  	
	// columns:
	$report_id = $_POST['report_id'];
	if ($report_id == '') $report_id = $_GET['report_id'];

	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	$count = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($row['ATTR'] == 'ENROLLED MEMBER') {
			$course_enrollment = true;
			$members = true;
		}
		if ($row['CAT'] == 'COURSE') {
			$course = true;
		}
		
		if ($row['CAT'] == 'TEST') {
			$test = true;
		} 
		if ($row['CAT'] == 'STUDENT') {
			$members = true;
			if ($row['ATTR'] == 'LOGIN') {
				// $sql_buf .= "DISTINCT ";
			}
		}
		
		$sql = "SELECT * FROM report_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
		$res2 = $db->query($sql);
		if ( $row2 =$res2->fetchRow(DB_FETCHMODE_ASSOC) ) {
			if ($row2['FIELD'] == 'MEMBER_ID'){
				// $sql_buf .= 'DISTINCT MEMBERS.LOGIN';
			} else {
				if ($count >0) $sql_buf .= ',';
				$sql_buf .= $row2['TBL'].'.'.$row2['FIELD'];
			}
		}
		$count++;
	}

	// queries
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = $db->query($sql);
	$q = '';
	while( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		if ($row['ATTR'] == "ENROLLED MEMBER") {
			$course_enrollment = true;
			//$members = true;
		}
		if ($row['CAT'] == 'COURSE') {
			$course = true;
		} 
		if ($row['CAT'] == 'TEST') {
			$test = true;
		}
		if (($row['CAT'] == 'STUDENT') || ($row['ATTR']=='TRAINER') || ($row['ATTR']=='INSTRUCTOR')) {
			$members = true;
		}
		
		$sql = "SELECT tbl, field FROM report_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
		$res2 = $db->query($sql);
		if ($res2) {
			$row2 =$res2->fetchRow(DB_FETCHMODE_ASSOC);
			$q .=  ' '.$row['FUNCTION'].' '.$row2['TBL'].'.'.$row2['FIELD'].' '.$row['OP'];
			if (($row['OP'] == 'LIKE') || ($row['OP'] == 'NOT LIKE')) {
				$q .= ' \'%'.$row['VAL'].'%\'';
			} else if (($row2['FIELD'] == 'DATE_TAKEN') || ($row2['FIELD']=='START_DATE')  || ($row2['FIELD']=='END_DATE')) {
				// date format
				$q .= ' \''.$row['VAL'].'\'';
			} else if (($row['OP'] == '>') || ($row['OP'] == '<') || ($row2['FIELD']=='FINAL_SCORE')) {
				// final_score, though it's a char record, it represents a numeric
				// actually no. Oracle wants chars here.
				$q .= ' \''.intval($row['VAL']).'\'';
			} else {
				$q .= ' \''.$row['VAL'].'\'';
			}
		}
		
	}
	//if ($_SESSION['debug']) echo '<br>course: '.$course.'; test: '.$test.'; members: '.$members.'<br>';
	
	$sql_buf .= " FROM ";
	
	$tables = '';
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT * FROM report_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
		$res2 = $db->query($sql);
		if ($res2) {
			$row2 =$res2->fetchRow(DB_FETCHMODE_ASSOC);
			$table = $row2['TBL'];
			$field = $row2['FIELD'];
		}
		$publish = true;
		if (!$course_enrollment) {
			if ($table == 'COURSE_ENROLLMENT') $publish = false;
		} else {
			if ( ($table == 'COURSES') && ($field == 'MEMBER_ID') ) $publish = false;
		}
		if (!$course) {
			if (($table=='COURSES') || ($table=='CREL_GROUPS') || ($table=='COURSE_GROUPS')) $publish = false;
		}
		if (!$test) {
			if (($table=='TESTS') || ($table=='TESTS_RESULTS') || ($table=='TESTS_STATUS')) $publish = false;
		}
		if (!$members) {
			if (($table=='MEMBERS') || ($table=='MREL_GROUPS') || ($table=='MEMBER_GROUPS') || ($table=='MEMBER_CATEG')) $publish = false;
		}
		
		if ($publish) $tables .= $table.',';
	}
	
	// check table inter-relations
	$sql = "SELECT * FROM report_links";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$table = $row['CAT1'];
		$publish = true;
		if (!$course_enrollment) {
			if ($table=='COURSE_ENROLLMENT') $publish = false;
		} else {
			if ( ($table == 'COURSES') && ($field == 'MEMBER_ID') ) $publish = false;
		}
		if (!$course) {
			if (($table=='COURSES') || ($table=='CREL_GROUPS') || ($table=='COURSE_GROUPS')) $publish = false;
		}
		if (!$test) {
			if (($table=='TESTS') || ($table=='TESTS_RESULTS') || ($table=='TESTS_STATUS')) $publish = false;
		}
		if (!$members){
			if (($table=='MEMBERS') || ($table=='MREL_GROUPS') || ($table=='MEMBER_GROUPS') || ($table=='MEMBER_CATEG')) $publish = false;
		}
		if ($publish) $tables .= $table.',';
 
		/*echo '<br>Q: '.$q;
		echo 'Vars: '.$course_enrollment.': '.$course.': '.$test.': '.$members;
		echo '<br>SQL so far: '.$sql_buf.'<br>';
		echo '<br>tables: '.$tables.'<br><br>';*/
		
	  	$table = $row['CAT2'];
	  	$publish = true;
	  	if (!$course_enrollment) {
			if ($table=='COURSE_ENROLLMENT') $publish = false; 
	  	} else {
			if ( ($table == 'COURSES') && ($field == 'MEMBER_ID') ) $publish = false;
		}
		if (!$course) {
			if (($table=='COURSES') || ($table=='CREL_GROUPS') || ($table=='COURSE_GROUPS')) $publish = false;
		}
		if (!$test) {
			if (($table=='TESTS') || ($table=='TESTS_RESULTS') || ($table=='TESTS_STATUS')) $publish = false;
		}
		if (!$members){
			if (($table=='MEMBERS') || ($table=='MREL_GROUPS') || ($table=='MEMBER_GROUPS') || ($table=='MEMBER_CATEG')) $publish = false;
		}
		if ($publish) $tables .= $table.',';
	}
	
	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT * FROM report_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
		$res2 = $db->query($sql);
		if ($res2) {
			$row2 =$res2->fetchRow(DB_FETCHMODE_ASSOC);
			$table = $row2['TBL'];
			$field = $row2['FIELD'];
		}
		$publish = true;
		$cat = $row['CAT'];
		$attr = $row['ATTR'];
		if (!$course_enrollment) {
			if ($cat=='COURSE_ENROLLMENT') $publish = false;
		} else {
			if ( ($cat == 'COURSES') && ($attr == 'MEMBER_ID') ) $publish = false;
		}
		if (!$course) {
			if (($cat=='COURSES') || ($cat=='CREL_GROUPS') || ($cat=='COURSE_GROUPS')) $publish = false;
		}
		if (!$test) {
			if (($table=='TESTS') || ($table=='TESTS_RESULTS') || ($table=='TESTS_STATUS')) $publish = false;
		}
		if (!$members) {
			if (($cat=='MEMBERS') || ($cat=='MREL_GROUPS') || ($cat=='MEMBER_GROUPS') || ($cat=='MEMBER_CATEG')) $publish=false;
		}
		if ($publish) $tables .= $table.',';
	}
	
	$tables2 = '';
	$a1 = 0;
	$t = 0;
	
	do {
		$a2 = strpos($tables, ',', $a1);
		$table_tmp = substr($tables, $a1, $a2-$a1);
		ltrim($table_tmp);
		rtrim($table_tmp);
		if (strlen($table_tmp) >1) {
			//if ($_SESSION['debug']) echo '<br>Found: '.$tables2. ' ---'.$table_tmp.'::: strpos: '.strpos('members, mrel_groups', $table_tmp, 0) ;
			$spos = strpos($tables2, $table_tmp, 0);
			if ($spos===false){
				if (strlen($tables2) >1) {
					$tables2 .= ",";
				}
				$tables2 .= $table_tmp;
				//if ($_SESSION['debug']) echo '<br>tables2: '.$tables2.'<br>';
			}
		}
		$a1 = $a2 +1;
		$t++;
	} while ( ($a1 < strlen($tables)) && ($t<100) ); // just to be sure it doesn't loop indefinitelly
	
	$sql_buf .= $tables2;
	
	$sql_buf .= " WHERE ";
	
	// links
	$sql = "SELECT * FROM report_links";
	$res = $db->query($sql);
	$count = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$publish = true;
		if (!$course_enrollment) {
			if (($row['CAT1']=='COURSE_ENROLLMENT') || ($row['CAT2']=='COURSE_ENROLLMENT')) $publish = false;
		} else {
			if ( (($row['CAT1']=='COURSES') && ($row['ATTR1']=='MEMBER_ID')) || (($row['CAT2']=='COURSES') && ($row['ATTR2']=='MEMBER_ID')) ) $publish = false;
		}
		if (!$course) {
			if (($row['CAT1']=='COURSES') || ($row['CAT1']=='CREL_GROUPS') || ($row['CAT1']=='COURSE_GROUPS') ||
			($row['CAT2']=='COURSES') || ($row['CAT2']=='CREL_GROUPS') || ($row['CAT2']=='COURSE_GROUPS')) $publish = false;
		}
		if (!$test) {
			if (($row['CAT1']=='TESTS') || ($row['CAT1']=='TESTS_RESULTS') || ($row['CAT1']=='TESTS_STATUS') || 
			($row['CAT2']=='TESTS_RESULTS') || ($row['CAT2']=='TESTS_STATUS')) $publish=false;
		}
		if (!$members) {
			if (($row['CAT1']=='MEMBERS') || ($row['CAT1']=='MREL_GROUPS') || ($row['CAT1']=='MEMBER_GROUPS') || ($row['CAT1']=='MEMBER_CATEG') ||
			($row['CAT2']=='MEMBERS') || ($row['CAT2']=='MREL_GROUPS') || ($row['CAT2']=='MEMBER_GROUPS') || ($row['CAT2']=='MEMBER_CATEG')) $publish=false;
		}

		if ($publish) {
			if ($count >0) $sql_buf .= ' AND ';
			$sql_buf .= $row['CAT1'].'.'.$row['ATTR1'].'='.$row['CAT2'].'.'.$row['ATTR2'];
			$count++;
		}
	}
	
 	// sql queries

 	$sql_buf .= $q;

	//if ($_SESSION['debug']) echo $sql_buf;
	
	if($_GET['csv']=='1'){
		$name=ereg_replace(" ", "_", $_SESSION['course_title']);
		$name=ereg_replace("'", "", $name);
		header('Content-Type: text/csv');
		header('Content-Disposition: inline; filename="'.$name.'_report.csv"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		
		$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	 	$res = $db->query($sql);
	 	$this_row = '';
	 	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	 		if ( ($row['ATTR'] != 'MEMBER_ID') ) {
	 		$this_row .= quote_csv($row['CAT'].".".$row['ATTR']).",";
	 	}
	 	$this_row .= "\n";
	 
	 	$res = $db->query($sql_buf);
	 	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	 		foreach ($row as $f=>$fv) {
	 			if ( !is_int($f) && ($f != 'MEMBER_ID') ) {
	 				$this_row .= quote_csv($fv).",";
	 			}
	 		}
	 		$this_row .= "\n";
	 	}
	
	 	$fp = @unlink('../content/export/'.$name.'_reporting.csv');
		$fp = @fopen('../content/export/'.$name.'_reporting.csv', 'w');
		if (!$fp) {
			$errors[]=array(AT_ERROR_CSV_FAILED, $name);
			print_errors($errors);
			exit;
		}
		@fputs($fp, $this_row); @fclose($fp);
		@readfile('../content/export/'.escapeshellcmd($name).'_reporting.csv');
		@unlink('../content/export/'.escapeshellcmd($name).'_reporting.csv');
		exit;
	}
 	?>
 	<?php
 	require($_include_path.'cc_html/header.inc.php');
 	?>
 	 	
 <TABLE class="bodyline" border="0" cellpadding="0" cellspacing="1" align="center" width="75%">
  <?php
 
 	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
 	$res = $db->query($sql);
 	echo '<tr>';
 	$cols = 0;
 	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
 		echo '<th>'.$row['CAT'].'.'.$row['ATTR'].'</th>';
 		$cols++;
 	}
 	echo '</tr>';
 	echo '<tr><td colspan="'.$cols.'"><hr></td></tr>';
 
 	$res = @$db->query($sql_buf);
 	if (PEAR::isError($res)){
 		$_errors[] = AT_ERROR_SQL_BAD_DEFINITION;
		print_errors($_errors);
		echo '<br>'.$sql_buf;
 	} else {
		$alternate = 1;
	 	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
	 		echo '<tr>';
	 		foreach ($row as $f=>$fv) {
	 			if ( !is_int($f) && ($f != 'MEMBER_ID') ) {
	 				echo '<td class="rowa'.$alternate.'">'.$fv.'&nbsp;</td>';
	 			}
	 		}
			$alternate++;
			if ($alternate > 2) $alternate = 1;
	 		echo '</tr>';
	 	}
 	}
 ?>
 </TABLE>


 <br>
<center>
<table border="0" align="center" width="75%">
<tr><td>
	<a href='reports/report_view.php?report_id=<?php echo $report_id; ?>&csv=1'>Export To Excel</a></td>
<td>
	<A href="reports/index.php">Return to Reports Home</a>
</td><td>
	<input type="button" class="button" name="print" value="Print" onclick="javascript:void(window.print());">
</td>
</tr></table>
<?php
	require($_include_path.'cc_html/footer.inc.php');
?>