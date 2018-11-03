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

	$report_id = $_POST['rid'];
	if ($report_id == '') {
		$report_id = $_GET['rid'];
	}
	
	$sql = "SELECT * FROM report_queries WHERE r_id=$report_id";
	$res = $db->query($sql);
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	
	$s_from = $row['Q_FROM'];
	$query = $row['Q_TEXT'];
	$query_ss = $row['Q_TEXT'];
	$friendly = $row['Q_FRIENDLY'];
	$course_flag = $row['Q_COURSE_FLAG'];
	
	/*if (strpos("members_pers", $s_from) === false) {
		$s_from .= "members_pers,";
	}*/
	
	/*if (strpos("member_groups", $s_from) === false) {
		$s_from .= "member_groups,";
	}*/

	if ( $s_from[ strlen($s_from)-1 ] == "," ) {
		$s_from = substr($s_from, 0, strlen($s_from)-1);
	}
	
	
	// preselect custom fields in an array for later use
	$custom_user_fields = array();
	$custom_course_fields = array();
	
	$sql = "SELECT * FROM user_custom_fields ORDER BY id";
	$res_s2 = $db->query($sql);
	$i =1;
	while ($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
		$custom_user_fields["ud_custom".$i] = $row['NAME'];
		$_template['ud_custom'.$i] = $row['NAME'];
		$i++;
	}
	
	$sql = "SELECT * FROM course_custom_fields ORDER BY id";
	$res_s2 = $db->query($sql);
	$i =1;
	while ($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
		$custom_course_fields["cd_custom".$i] = $row['NAME'];
		$_template['cd_custom'.$i] = $row['NAME'];
		$i++;
	}
	
	// create table association 	
	$table_assoc = array( "courses" => " course.title,",
					"course_enrollment" => " course_enrollment.enrolltime,",
					"mcourse_completion" => " mcourse_completion.grade, mcourse_completion.completion_date,",
					"tests" => " tests.title,",
					"tests_results" => " tests_results.date_taken, tests_results.final_score,",
					"tests_status" => " tests_status.passed, tests_status.retries,",
					"course_groups" => "course_groups.name,"
					);
	
	// prepare column header translation to table.field sql
	// key = the name of column as found in db:klore.report_columns.cols
	$cols = array( 
		"ud_login" => "members.login", 
		"ud_first_name" => "members_pers.first_name",
		"ud_last_name" => "members_pers.last_name",
		"ud_category" => "member_groups.category",
		"ud_group" => "member_groups.name", 
		
		"cd_title" => "courses.title",
		"cd_module" => "course_groups.name",
		"cd_trainer" => "courses.member_id", 
		"cd_avmark" => "mcourse_completion.grade",
		
		"td_name" => "tests.title",
		"td_testmark" => "tests_results.final_score",
		"td_retries" => "tests_status.retries"
		);
	
	$enroll_table = ($course_flag==0)?"course_enrollment":"mcourse_completion";
	
	$cols_sql = array( 
		"ud_login" 		=> "SELECT M.login FROM members M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id WHERE T.member_id=", 
		"ud_first_name" => "SELECT M.first_name FROM members_pers M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id WHERE T.member_id=",
		"ud_last_name" 	=> "SELECT M.last_name FROM members_pers M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id WHERE T.member_id=",
		"ud_email" 		=> "SELECT M.email FROM members M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id WHERE T.member_id=",		
		"ud_category" 	=> "SELECT C.category FROM mrel_groups M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id, member_groups C WHERE C.group_id=M.group_id AND T.member_id=",
		"ud_group" 		=> "SELECT C.name     FROM mrel_groups M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id, member_groups C WHERE C.group_id=M.group_id AND T.member_id=", 
		
		"cd_title" 		=> "SELECT C.title FROM ".$enroll_table." E INNER JOIN sql_tq".$_SESSION['member_id']." T ON E.member_id=T.member_id, courses C WHERE C.course_id=T.course_id AND C.course_id=E.course_id AND T.member_id=",
		"cd_module" 	=> "SELECT G.name FROM ".$enroll_table." E INNER JOIN sql_tq".$_SESSION['member_id']." T ON E.member_id=T.member_id, course_groups G INNER JOIN crel_groups R ON G.group_id=R.group_id WHERE R.course_id=E.course_id AND T.course_id=E.course_id AND T.member_id=",
		"cd_trainer" 	=> "SELECT P.first_name, P.last_name, M.login FROM ".$enroll_table." E INNER JOIN sql_tq".$_SESSION['member_id']." T ON E.member_id=T.member_id, courses C INNER JOIN members M ON C.member_id=M.member_id, members_pers P WHERE C.course_id=E.course_id AND T.course_id=C.course_id AND P.member_id=M.member_id AND T.member_id=", 
		"cd_avmark"		=> "SELECT U.grade FROM mcourse_completion U INNER JOIN sql_tq".$_SESSION['member_id']." T ON U.member_id=T.member_id WHERE U.member_id=",
		
		"td_name" 		=> "SELECT N.title FROM tests_results R INNER JOIN sql_tq".$_SESSION['member_id']." T ON R.member_id=T.member_id, tests N WHERE N.test_id=R.test_id AND T.test_id=N.test_id AND T.member_id=",
		"td_testmark" 	=> "SELECT R.final_score FROM tests_results R INNER JOIN sql_tq".$_SESSION['member_id']." T ON R.member_id=T.member_id WHERE T.test_id=R.test_id AND T.member_id=",
		"td_retries" 	=> "SELECT S.retries FROM tests_status S INNER JOIN sql_tq".$_SESSION['member_id']." T ON S.member_id=T.member_id WHERE T.test_id=S.test_id AND T.member_id="
		);
	
	$i = 1;
	foreach( $custom_user_fields as $k => $val ) {
		$cols["ud_custom".$i] = $val;
		$cols_sql["ud_custom".$i] = "SELECT M.custom".$i." FROM members M INNER JOIN sql_tq".$_SESSION['member_id']." T ON M.member_id=T.member_id AND T.member_id=";
		$i++;
	}
	$i = 1;
	foreach( $custom_course_fields as $k => $val ) {
		$cols["cd_custom".$i] = $val;
		$cols_sql["cd_custom".$i] = "SELECT C.custom".$i." FROM ".$enroll_table." E INNER JOIN sql_tq".$_SESSION['member_id']." T ON E.member_id=T.member_id, courses C WHERE E.course_id=C.course_id AND T.member_id=";
		$i++;
	}
	
	/* preparations ready. Now select columns in sql_buf */
	$sql = "SELECT cols FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	if (!$row = $res->fetchRow()) {
		$errors[] = AT_ERROR_NO_REPORT_COLUMNS;
		require($_include_path.'cc_html/header.inc.php');
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
	$col_headers = split(",", $row[0]);
	//$sql_buf = "SELECT /*+ORDERED_PREDICATES */ DISTINCT ";
	// removing comma from the end of line ($s_from)
	$len = strlen($s_from)-1;
	if ( $s_from[ $len ] == "," ) {
		$s_from  = substr($s_from, 0, $len);
	}

	$len = strlen($sql_buf)-1;
	if ( $sql_buf[ $len ] == "," ) {
		$sql_buf  = substr($sql_buf, 0, $len);
	}
	

	$sql_buf = $query_ss;
	$sql_buf = str_replace("`", "'", $sql_buf);

	if($_GET['csv']=='1'){
		$name=ereg_replace(" ", "_", $_SESSION['course_title']);
		$name=ereg_replace("'", "", $name);
		header('Content-Type: text/csv');
		header('Content-Disposition: inline; filename="'.$name.'_report.csv"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public
		');
		
	 	$this_row = '';
		
	 	$res = $db->query($sql_buf);
		
		// display headers
		foreach ($col_headers as $id => $table) {
			$this_row .= quote_csv($_template[$table]).",";
		}
		$this_row .= "\n";
		
		// create temporary table for joining with col info
		$sql_tt = "CREATE GLOBAL TEMPORARY TABLE sql_tq".$_SESSION['member_id']."(member_id NUMBER, course_id NUMBER, test_id NUMBER) ON COMMIT PRESERVE ROWS";
		$res_tt = $db->query($sql_tt);
		if (PEAR::isError($res_tt)) {
			// remove info:
			$sql_tt = "TRUNCATE TABLE sql_tq".$_SESSION['member_id'];
			$res_tt = $db->query($sql_tt);
		}
		
		while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			if ($row['COURSE_ID'] == '') $row['COURSE_ID'] = 0;
			if ($row['TEST_ID'] == '') $row['TEST_ID'] = 0;
			$sql_tt = "INSERT INTO sql_tq".$_SESSION['member_id']." VALUES ($row[MEMBER_ID], $row[COURSE_ID], $row[TEST_ID])";
			$res_tt = $db->query($sql_tt);
			if (PEAR::isError($res_tt)) {
				$_errors[] = AT_ERROR_DB_NOT_ACCESSED;
				print_errors($_errors);
				print_r($res_tt);
			}
		}
		
		$sql_tq = "SELECT * FROM sql_tq".$_SESSION['member_id'];
		$res = $db->query($sql_tq);
		while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			foreach ($col_headers as $id => $table) {
				$sql_t = $cols_sql[$table];
				$sql_t .= $row['MEMBER_ID'];
				if ($row['COURSE_ID'] <> 0) $course_sql = " AND T.course_id=".$row['COURSE_ID']; else $course_sql = '';
				if ($row['TEST_ID'] <> 0) $test_sql = " AND T.test_id=".$row['TEST_ID']; else $test_sql = '';
				$sql_t .= $course_sql.$test_sql;
				$res_t = $db->query($sql_t);
				if (!PEAR::isError($res_t)) {
					$row_t = $res_t->fetchRow();
				} else {
					print_r($res_t);
					echo '<br>TABLE: '.$table.'<br>';
					echo 'SQL: '.$cols_sql[$table].'<br>';
				}
				$this_row .= quote_csv($row_t[0]).",";
			}
			$this_row .= "\n";
		}
		
		// useless, but... keep it safe
		$sql = "DROP TABLE sql_tq".$_SESSION['member_id'];
		$res = $db->query($sql);
		
	 	$fp = @unlink('export/'.$name.'_reporting.csv');
		$fp = @fopen('export/'.$name.'_reporting.csv', 'w');
		if (!$fp) {
			$errors[]=array(AT_ERROR_CSV_FAILED, $name);
			print_errors($errors);
			exit;
		}
		@fputs($fp, $this_row); @fclose($fp);
		@readfile('export/'.escapeshellcmd($name).'_reporting.csv');
		@unlink('export/'.escapeshellcmd($name).'_reporting.csv');
		exit;
	}

	require($_include_path.'cc_html/header.inc.php');
	
?>
 	 	
 <TABLE class="bodyline" border="0" cellpadding="0" cellspacing="1" align="center" width="90%">
<?php
 
	$res = @$db->query($sql_buf);
	//echo 'DEBUG: '.$sql_buf;
	
 	if (PEAR::isError($res)){
 		$_errors[] = AT_ERROR_SQL_BAD_DEFINITION;
		print_errors($_errors);
		echo '<br>'.$sql_buf;
		echo '<br><br>';
		print_r($res);
 	} else {
		// display headers
		echo '<tr>';
		$_template['ud_email'] = 'Email';
		foreach ($col_headers as $id => $table) {
			echo '<th>'.$_template[$table].'</th>';
		}
		echo '</tr>';
		
		// create temporary table for joining with col info
		$sql_tt = "CREATE GLOBAL TEMPORARY TABLE sql_tq".$_SESSION['member_id']."(member_id NUMBER, course_id NUMBER, test_id NUMBER) ON COMMIT PRESERVE ROWS";
		$res_tt = $db->query($sql_tt);
		if (PEAR::isError($res_tt)) {
			// remove info:
			$sql_tt = "TRUNCATE TABLE sql_tq".$_SESSION['member_id'];
			$res_tt = $db->query($sql_tt);
		}
		
		// create temporary table for group_manager/coord filter
		$sql_tt = "CREATE GLOBAL TEMPORARY TABLE sql_gmc".$_SESSION['member_id']."(member_id NUMBER) ON COMMIT PRESERVE ROWS";
		$res_tt = $db->query($sql_tt);
		// remove info:
		$sql_tt = "TRUNCATE TABLE sql_gmc".$_SESSION['member_id'];
		$res_tt = $db->query($sql_tt);
		
		$sql_dtt = "TRUNCATE TABLE DEBUG_SQLTQ";
		$res_dtt = $db->query($sql_dtt);
		while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			if ($row['COURSE_ID'] == '') $row['COURSE_ID'] = 0;
			if ($row['TEST_ID'] == '') $row['TEST_ID'] = 0;
			$sql_tt = "INSERT INTO sql_tq".$_SESSION['member_id']." VALUES ($row[MEMBER_ID], $row[COURSE_ID], $row[TEST_ID])";
			$res_tt = $db->query($sql_tt);
			$sql_dtt = "INSERT INTO DEBUG_SQLTQ VALUES ($row[MEMBER_ID], $row[COURSE_ID], $row[TEST_ID])";
			$res_dtt = $db->query($sql_dtt);
			if (PEAR::isError($res_tt)) {
				$_errors[] = AT_ERROR_DB_NOT_ACCESSED;
				print_errors($_errors);
				print_r($res_tt);
			}
		}
		
		if ($_SESSION['status'] == STATUS_COORDINATOR) {
			$sql_tt = "INSERT INTO sql_gmc".$_SESSION['member_id']."(member_id) SELECT M.member_id FROM coord_groups C INNER JOIN mrel_groups M ON C.group_id=M.group_id WHERE C.member_id=$_SESSION[member_id]";
		} else if ($_SESSION['status'] == STATUS_GROUP_MANAGER) {
			$sql_tt = "INSERT INTO sql_gmc".$_SESSION['member_id']."(member_id) SELECT M.member_id FROM group_mng G INNER JOIN mrel_groups M ON G.group_id=M.group_id WHERE G.member_id=$_SESSION[member_id]";
		} else {
			// presumably trainer or training manager
			$sql_tt = "INSERT INTO sql_gmc".$_SESSION['member_id']."(member_id) SELECT member_id FROM members"; 
		}
		$res_tt = $db->query($sql_tt);

		$alternate = 1;
		$sql_tq = "SELECT T.* FROM sql_tq".$_SESSION['member_id']." T INNER JOIN sql_gmc".$_SESSION['member_id']." C ON T.member_id=C.member_id";
		$res = $db->query($sql_tq);
		while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			echo '<tr>';
			foreach ($col_headers as $id => $table) {
				echo '<td class="rowa'.$alternate.'">';
				$sql_t = $cols_sql[$table];
				$sql_t .= $row['MEMBER_ID'];
				if ($row['COURSE_ID'] <> 0) $course_sql = " AND T.course_id=".$row['COURSE_ID']; else $course_sql = '';
				if ($row['TEST_ID'] <> 0) $test_sql = " AND T.test_id=".$row['TEST_ID']; else $test_sql = '';
				$sql_t .= $course_sql.$test_sql;
				$res_t = $db->query($sql_t);
				if (!PEAR::isError($res_t)) {
					$row_t = $res_t->fetchRow();
				} else {
					print_r($res_t);
					echo '<br>TABLE: '.$table.'<br>';
					echo 'SQL: '.$cols_sql[$table].'<br>';
				}
				echo $row_t[0];
				if ($table == 'cd_trainer') {
					// show special format: first_name last_name (login)
					echo ' '.$row_t[1];
					if ($row_t[2]<>'') echo ' ('.$row_t[2].')';
				}
				echo '</td>';

			}
			echo '</tr>';
			$alternate++;
			if ($alternate >2) $alternate = 1;
		}
		
		// useless, but... keep it safe
		$sql = "TRUNCATE TABLE sql_tq".$_SESSION['member_id'];
		$res = $db->query($sql);
		$sql = "DROP TABLE sql_tq".$_SESSION['member_id'];
		$res = $db->query($sql);
		$sql = "TRUNCATE TABLE sql_gmc".$_SESSION['member_id'];
		$res = $db->query($sql);
		$sql = "DROP TABLE sql_gmc".$_SESSION['member_id'];
		$res = $db->query($sql);
 	}
?>
</TABLE>


 <br>
<center>
<table border="0" align="center" width="75%">
<tr><td>
	<a href='reports/report_view2.php?rid=<?php echo $report_id; ?>&csv=1'>Export To Excel</a></td>
<td>
	<A href="reports/index.php">Return to Reports Home</a>
</td><td>
	<input type="button" class="button" name="print" value="Print" onclick="javascript:void(window.print());">
</td>
</tr></table>
<?php
	require($_include_path.'cc_html/footer.inc.php');
?>