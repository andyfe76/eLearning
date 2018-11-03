<?php
	$course_enrollment = false;
	$course = false;
	$test = false;
	$members = false;
	$sql_buf = "SELECT DISTINCT members.member_id ";
  
	// columns:
	if (isset($_POST['group_id'])) $group_id = $_POST['group_id'];
	if (isset($_GET['group_id'])) $group_id = $_GET['group_id'];
	if ($group_id == '') {
		echo 'Error: Undefined group.';
		exit;
	}
		
	$sql = "SELECT * FROM dyn_columns";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		// if ($count >0) $sql_buf .= ', ';
		if ($row['ATTR'] == 'Enrolled member') {
			$course_enrollment = true;
			$members = true;
		}
		if ($row['CAT'] == 'Course') {
			$course = true;
		}
		
		 if ($row['CAT'] == 'Test') {
			$test = true;
		} 
		if ($row['CAT'] == 'Student') {
			$members = true;
		}
	}

	// queries
	$sql = "SELECT * FROM dyn_query WHERE report=$group_id";
	$res = $db->query($sql);
	$q = '';
	while( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		if ($row['ATTR'] == "ENROLLED MEMBER") {
			$course_enrollment = true;
			$members = true;
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
		$sql = "SELECT tbl, field FROM dyn_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
		$res2 = $db->query($sql);
		if ($res2) {
			$row2 =$res2->fetchRow(DB_FETCHMODE_ASSOC);
			$q .=  ' '.$row['FUNCTION'].' '.$row2['TBL'].'.'.$row2['FIELD'].' '.$row['OP'];
			if (($row['OP'] == 'LIKE') || ($row['OP'] == 'NOT LIKE')) {
				$q .= ' apstr%'.$row['VAL'].'%apstr';
			} else if (($row2['FIELD'] == 'DATE_TAKEN') || ($row2['FIELD']=='START_DATE')  || ($row2['FIELD']=='END_DATE')) {
				// date format
				$q .= ' &apstr'.$row['VAL'].'&apstr';
			} else if (($row['OP'] == '>') || ($row['OP'] == '<') || ($row2['FIELD']=='FINAL_SCORE')) {
				// final_score, though it's a char record, it represents a numeric
				$q .= intval($row['VAL']);
			} else {
				$q .= ' &apstr'.$row['VAL'].'&apstr';
			}
		}
		
	}

	//if ($_SESSION['debug']) echo '<br>course: '.$course.'; test: '.$test.'; members: '.$members.'<br>';
	
	$sql_buf .= " FROM ";
	
	$tables = '';
	$sql = "SELECT * FROM dyn_query WHERE report=$group_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT * FROM dyn_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
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
	$sql = "SELECT * FROM dyn_links";
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
	
	$sql = "SELECT * FROM dyn_columns";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT * FROM dyn_definitions WHERE cat='$row[CAT]' AND attr='$row[ATTR]'";
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
	$sql = "SELECT * FROM dyn_links";
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
	
	$sql = "SELECT * FROM dyn_sql WHERE dyn_id=$group_id";
	$res = $db->query($sql);
	if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		// update record. This is the normal course of action. 
		$sql = "UPDATE dyn_sql SET sqltext='$sql_buf' WHERE dyn_id=$group_id";
		$res = $db->query($sql);
	} else {	
		// insert new record. !! here the parser should never arrive. It would mean DB problem.		
		$sql = "INSERT INTO dyn_sql VALUES ($group_id, $static_id, '$sql_buf')";
		$res = $db->query($sql);
	}
	

 ?>