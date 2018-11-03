<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'cc_html/header.inc.php');
	
	$action = $_POST['action'];
	
	$report_id = $_GET['report_id'];
	if (!$report_id) {
		$report_id = $_POST['report_id'];
	} 
	if ($report_id=='') {
		$report_id = 0;
	} else {
		$sql = "SELECT * from report_reports WHERE id=$report_id";
		$res = $db->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$report_name = $row['NAME'];
		$report_desc = $row['DESCRIPTION'];
	}
	
	if (isset($_POST['report_name']) || isset($_POST['report_desc'])) {
		$report_name = $_POST['report_name'];
		$report_desc = $_POST['report_desc'];
		
		if ($report_id==0) {
			$rid = $db->nextId("AUTO_REPORT_REPORTS_ID");
			$report_id = $rid;
			$sql = "INSERT INTO report_reports VALUES ($rid, '$report_desc', '$report_name')";
			$db->query($sql);
		} else {
			$sql = "UPDATE report_reports SET name='$report_name', description='$report_desc' WHERE id=$report_id";
			$db->query($sql);
			
		}
		
	}
	
	/*if (($action == '') && ($_POST['update'])) {
		if ($report_id==0) {
			$rid = $db->nextId("AUTO_REPORT_REPORTS_ID");
			$report_id = $rid;
			$sql = "INSERT INTO report_reports VALUES ($rid, '$report_desc', '$report_name')";
			$db->query($sql);
		} else {
			$sql = "UPDATE report_reports SET name='$report_name', description='$report_desc' WHERE id=$report_id";
			$db->query($sql);
			
		}
	}*/
	
	if (($action == 'Add Query') || (isset($_POST['add_constrains']))) {
		/* Get Constrains */
		// use a frienly expression of the query as well as the sql one.
		
		// first : figure out what constrains should be placed last --> these will determine the exclusive constrains for the entire report
		if ($_POST['c_instructor'] <> -1) {
			$trainer_in = true;
		}
		if ($_POST['cb_t_retries'] <> '') {
			$testRetries_in = true;
		}
		if ($_POST['cb_t_mark'] <> '') {
			$testMark_in = true;
		}
		if ($_POST['cb_t_start'] <> '') {
			$testDate_in = true;
		}
		if ($_POST['cb_c_mark'] <> '') {
			$courseMark_in = true;
		}
		if ($_POST['cb_c_start'] <> '') {
			$courseDate_in = true;
		}
		
		
		$query = '';
		$s_from = 'members,';
		$friendly = '';
		if ($_POST['s_groups'] <> -1){	
			$sql = "SELECT name FROM member_groups WHERE group_id=$_POST[s_groups]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$usergroup = $row[0];
			$friendly .= $_template['user_in_group'].': <b>'.$usergroup.'</b>~';
			$query_ss = "SELECT DISTINCT member_id FROM mrel_groups WHERE group_id=".$_POST['s_groups'];
		} else if ($_POST['s_categories'] <> -1) {
			$friendly .= $_template['user_in_category'].': <b>'.$_POST['s_categories'].'</b>~';
			$query_ss = "SELECT DISTINCT G.member_id FROM member_groups C INNER JOIN mrel_groups G ON C.group_id=G.group_id WHERE C.category='".$_POST['s_categories']."'";
		} else {
			// use any member 
			$query_ss = "SELECT DISTINCT member_id FROM mrel_groups";
		}
		
		// gather the custom registration fields
		$sql = "SELECT name FROM user_custom_fields ORDER BY id";
		$res = $db->query($sql);
		$userfields = array();
		while ($row = $res->fetchRow()){
			$userfields[] = $row[0]; //apend field names, 0-based indexed
		}
		
		for ($i=1; $i<11; $i++) {
			if ($_POST['custom_'.$i] <> '') {
				if ($query <> '') $query .= ' AND ';
				$friendly .= $userfields[$i].': <b>'.$_POST['custom_'.$i].'</b>~';
				$query_ss = "SELECT DISTINCT M.member_id FROM (".$query_ss.") T INNER JOIN members M ON T.member_id=M.member_id WHERE M.custom".$i." LIKE '%".$_POST['custom_'.$i]."%'";
			}
		}
		
		/* gather course related constrains */
		if ($_POST['enr_courses'] <> -1) {
			$sql = "SELECT DISTINCT title FROM courses WHERE course_id=$_POST[enr_courses]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$c_title = $row[0];
			if ($_POST['qtype'] == 'qtype_enr') {
				// user is enrolled to course
				$friendly .= $_template['enrolled_to'];
				$friendly .= ': <b>'.$c_title.'</b>~';
				// query_ss ==> At the end of SQL string (see below)
			} else {
				// user has completed the course
				$friendly .= $_template['completed_course'];
				$friendly .= ': <b>'.$c_title.'</b>~';
				// query_ss ==> At the end of SQL string (see below)
			}
			$course_specified = true;
			$course_in = true;
		} else if ($_POST['enr_modules'] <> -1) {
			$sql = "SELECT name FROM course_groups WHERE group_id=$_POST[enr_modules]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$m_title = $row[0];
			if ($_POST['qtype'] == 'qtype_enr') {
				// user is enrolled to course
				$friendly .= $_template['enrolled_to_any_course_in'];
				$friendly .= ': <b>'.$m_title.'</b>~';
				// query_ss ==> At the end of SQL string (see below)
			} else {
				// user has completed the course
				$friendly .= $_template['completed_any_course_in'];
				$friendly .= ': <b>'.$m_title.'</b>~';
				// query_ss ==> At the end of SQL string (see below)
			}
			$module_specified = true;
			$course_in = true;
		} else {
			// no course constraints
		}
		
		if ($_POST['qtype'] == 'qtype_enr') {
			$course_flag = 0;
		} else {
			$course_flag = 1;
		}
		
		if ($_POST['cb_c_mark']) {
			if (!$course_specified && !$module_specified) {
				$s_from .= 'mcourse_completion,';
			}
			$course_in = true;
			$friendly .= $_template['course_qualificative'].': <b>'.$_POST['cmark_op'].$_POST['c_mark'].'</b>~';
			$query_ss = "SELECT Y.member_id, Y.course_id FROM (".$query_ss.") T INNER JOIN mcourse_completion Y ON T.member_id=Y.member_id WHERE Y.grade".$_POST['cmark_op'].'\''.$_POST['c_mark'].'\'';
			$query .= ' AND mcourse_completion.grade'.$_POST['cmark_op'].'\''.$_POST['c_mark'].'\'';
			$c_mark_specified = true;
		}
		
		
		/* gather trainer related constraints */
		if ($_POST['c_instructor'] <> -1) {
			// select only users enrolled/completed for course with specific trainer
			$course_in = true;
			$sql = "SELECT M.login, P.first_name, P.last_name FROM members M INNER JOIN members_pers P ON M.member_id=P.member_id WHERE M.member_id=$_POST[c_instructor]";
			$res = $db->query($sql);
			$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
			$friendly .= $_template['course_trainer'];
			$friendly .= ': <b>'.$row['FIRST_NAME'].' '.$row['LAST_NAME'].' ('.$row['LOGIN'].')</b>~';
			// $query_ss -- see below
		}
		
		/* gather date constraints */
		if ($_POST['cb_c_start']) {
			$course_in = true;
			if ($_POST['qtype'] == 'qtype_enr') {
				$friendly .= $_template['enrolled_date'];
				$query_ss = "SELECT T.member_id, V.course_id FROM (".$query_ss.") T INNER JOIN course_enrollment V ON T.member_id=V.member_id WHERE V.enrolltime".$_POST['coursedate_op']."TO_DATE('".$_POST['c_start']."', 'dd-mm-yyyy hh24:mi:ss')";
			} else {
				$friendly .= $_template['completion_date'];
				$query_ss = "SELECT T.member_id, V.course_id FROM (".$query_ss.") T INNER JOIN mcourse_completion V ON T.member_id=V.member_id WHERE V.completion_date".$_POST['coursedate_op']."TO_DATE('".$_POST['c_start']."', 'dd-mm-yyyy hh24:mi:ss')";
			}
			$friendly .= ': <b>'.$_POST['coursedate_op'].$_POST['c_start'].'</b>~';
		}

		
		/* gather test related constraints */
		if ($_POST['tests'] <> -1) {
			$test_in = true;
			$sql = "SELECT title FROM tests WHERE test_id=$_POST[tests]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$test_title = $row[0];
			$friendly .= $_template['test_taken'];
			$friendly .= ': <b>'.$test_title.'</b>~';
			// query_ss ==> At the end of SQL string (see below)
			$test_specified = true;
		}
		
		if ($_POST['cb_t_mark'] && ($_POST['tests'] <> -1)) {
			$test_in = true;
			if (!$test_specified) $s_from .= 'tests_results,';
			$friendly .= $_template['final_score'];
			$friendly .= ': <b>'.$_POST['test_op'].$_POST['testmark'].'</b>~';
			//if ($course_in) $course_sql = ", D.course_id"; else $course_sql = '';
			$query_ss = "SELECT T.member_id, F.test_id FROM (".$query_ss.") T INNER JOIN tests_results F ON T.member_id=F.member_id WHERE F.final_score".$_POST['test_op'].'\''.$_POST['testmark'].'\'';
			$query .= ' AND tests_results.final_score'.$_POST['test_op'].$_POST['testmark'];
			$test_mark_specified = true;
		}
		
		if ($_POST['cb_t_retries'] && ($_POST['tests'] <> -1)){
			$test_in = true;
			$friendly .= $_template['retries_until_passed'];
			$friendly .= ': <b>'.$_POST['testr_op'].$_POST['test_retries'].'</b>~';
			$s_from .= 'tests_status,';
			//if ($course_in) $course_sql = ", G.course_id"; else $course_sql = '';
			$query_ss = "SELECT T.member_id, Z.test_id FROM (".$query_ss.") T INNER JOIN tests_status Z ON T.member_id=Z.member_id WHERE Z.retries".$_POST['testr_op'].'\''.$_POST['test_retries'].'\'';
			$query .= ' AND tests_status.retries'.$_POST['testr_op'].$_POST['test_retries'];
		}
		
		if ($_POST['cb_t_start']) {
			$test_in = true;
			if (!$test_specified && !$test_mark_specified) $s_from .= 'tests_results,';
			$friendly .= $_template['test_date'];
			//if ($course_in) $course_sql = ", T.course_id"; else $course_sql = '';
			$query_ss = "SELECT T.member_id, N.test_id FROM (".$query_ss.") T INNER JOIN tests_results N ON T.member_id=N.member_id WHERE N.date_taken".$_POST['testdate_op']."TO_DATE('".$_POST['t_start']."', 'dd-mm-yyyy hh24:mi:ss')";
			$query .= ' AND tests_results.date_taken'.$_POST['testdate_op'].'TO_DATE(\''.$_POST['t_start'].'\', \'dd-mm-yyyy hh24:mi:ss\')';
			$friendly .= ': <b>'.$_POST['t_start'].'</b>~';
		}
		
		/* Final: course related constrains -- added to end SQL so that combination results with only the course selected*/
		if ($_POST['enr_courses'] <> -1) {
			$sql = "SELECT title FROM courses WHERE course_id=$_POST[enr_courses]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$c_title = $row[0];
			if ($_POST['qtype'] == 'qtype_enr') {
				// user is enrolled to course
				$query_ss = "SELECT E.member_id, E.course_id FROM (".$query_ss.") T INNER JOIN course_enrollment E ON T.member_id=E.member_id WHERE E.course_id=".$_POST['enr_courses'];
			} else {
				// user has completed the course
				$query_ss = "SELECT R.member_id, R.course_id FROM (".$query_ss.") T INNER JOIN mcourse_completion R ON T.member_id=R.member_id WHERE R.course_id=".$_POST['enr_courses'];
			}
		} else if ($_POST['enr_modules'] <> -1) {
			$sql = "SELECT name FROM course_groups WHERE group_id=$_POST[enr_modules]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$m_title = $row[0];
			if ($_POST['qtype'] == 'qtype_enr') {
				// user is enrolled to course
				$query_ss = "SELECT E.member_id, E.course_id FROM (".$query_ss.") T INNER JOIN course_enrollment E ON T.member_id=E.member_id";
				$query_ss = "SELECT T.member_id, H.course_id FROM (".$query_ss.") T INNER JOIN crel_groups H ON T.course_id=H.course_id, course_groups J WHERE J.group_id=".$_POST['enr_modules']." AND J.group_id=H.group_id";
			} else {
				// user has completed the course
				$query_ss = "SELECT R.member_id, R.course_id FROM (".$query_ss.") T INNER JOIN mcourse_completion R ON T.member_id=R.member_id";
				$query_ss = "SELECT T.member_id, H.course_id FROM (".$query_ss.") T INNER JOIN crel_groups H ON T.course_id=H.course_id, course_groups J, mcourse_completion K WHERE J.group_id=".$_POST['enr_modules']." AND J.group_id=H.group_id AND K.course_id=H.course_id";
			}
		} else {
			// no course constraints
			if ($_POST['qtype'] == 'qtype_enr') {
				$enroll_table = 'course_enrollment';
				$friendly .= $_template['enrolled_to'];
				$friendly .= ': <b>'.$_template['any_course'].'</b>~';
			} else {
				$enroll_table = 'mcourse_completion';
				$friendly .= $_template['completed_course'];
				$friendly .= ': <b>'.$_template['any_course'].'</b>~';
			}
			$query_ss = "SELECT T.member_id, E.course_id FROM (".$query_ss.") T INNER JOIN ".$enroll_table." E ON T.member_id=E.member_id";
		}
		
		/* Final: trainer related constraints */
		if ($_POST['c_instructor'] <> -1) {
			// select only users enrolled/completed for course with specific trainer
			if ($_POST['qtype'] == 'qtype_enr') {
				// user is enrolled to course
				$query_ss = "SELECT DISTINCT T.member_id, C.course_id FROM (".$query_ss.") T, courses C, course_enrollment P WHERE C.member_id=".$_POST['c_instructor']." AND P.course_id=C.course_id AND P.member_id=T.member_id";
			} else {
				// user has completed the course
				$query_ss = "SELECT DISTINCT T.member_id, C.course_id FROM (".$query_ss.") T, courses C, mcourse_completion P WHERE C.member_id=".$_POST['c_instructor']." AND P.course_id=C.course_id AND P.member_id=T.member_id";
			}
		}
		
		/* Final: test related constraints -- added to end SQL so that combination results with only the course selected*/
		if ($_POST['tests'] <> -1) {
			$sql = "SELECT title FROM tests WHERE test_id=$_POST[tests]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			$test_title = $row[0];
			if ($course_in) $course_sql = ", T.course_id"; else $course_sql = '';
			$query_ss = "SELECT DISTINCT T.member_id, S.test_id".$course_sql." FROM (".$query_ss.") T INNER JOIN tests_results S ON T.member_id=S.member_id WHERE S.test_id=".$_POST['tests'];
		}
		
		/* Final: select again the specified constrains (propagation) */
		// TO BE CONTINUED 
		
		
		/* Finish construction */
		if ($report_id == 0) {
			$report_id = $db->nextId("AUTO_REPORT_REPORTS_ID");
			$sql = "INSERT INTO report_reports VALUES ($report_id, '$report_desc', '$report_name')";
			$res = $db->query($sql); 
		} 

		$sql = "SELECT COUNT(q_id) FROM report_queries WHERE r_id=$report_id";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		$rupdate = $row[0];
		$friendly = str_replace("'", "`", $friendly);
		$query = str_replace("'", "`", $query);
		$query_ss = str_replace("'", "`", $query_ss);

		// add constrains info to raw data field		
		// format date (remove ':')
		$c_start = str_replace(":", ".", $_POST['c_start']);
		$t_start = str_replace(":", ".", $_POST['t_start']);
		
		$raw = 's_categories:'.$_POST['s_categories'].'~s_groups:'.$_POST['s_groups'];
		for ($i=1; $i<11; $i++) {
			if ($_POST['custom_'.$i] <> '') $raw .= '~custom_'.$i.':'.$_POST['custom_'.$i];
		}
		$raw .= '~qtype:'.$_POST['qtype'].'~enr_modules:'.$_POST['enr_modules'].'~enr_courses:'.$_POST['enr_courses'].'~c_instructor:'.$_POST['c_instructor'];
		$raw .= '~cmark_op:'.$_POST['cmark_op'].'~c_mark:'.$_POST['c_mark'].'~cb_c_mark:'.$_POST['cb_c_mark'];
		$raw .= '~tests:'.$_POST['tests'].'~test_op:'.$_POST['test_op'].'~testmark:'.$_POST['testmark'].'~cb_t_mark:'.$_POST['cb_t_mark'].'~testr_op:'.$_POST['testr_op'].'~test_retries:'.$_POST['test_retries'].'~cb_t_retries:'.$_POST['cb_t_retries'];
		$raw .= '~testdate_op:'.$_POST['testdate_op'].'~t_start:'.$t_start.'~cb_t_start:'.$_POST['cb_t_start'].'~coursedate_op:'.$_POST['coursedate_op'].'~c_start:'.$c_start.'~cb_c_start:'.$_POST['cb_c_start'];
		
		// add columns info to raw data field
		$raw .= '~ud_login:'.$_POST['ud_login'].'~ud_first_name:'.$_POST['ud_first_name'].'~ud_last_name:'.$_POST['ud_last_name'].'~ud_email:'.$_POST['ud_email'].'~ud_category:'.$_POST['ud_category'].'~ud_group:'.$_POST['ud_group'];
		for ($i=1; $i<11; $i++) {
			if ($_POST['ud_custom'.$i] <> '') $raw .= '~ud_custom'.$i.':'.$_POST['ud_custom'.$i];
		}
		$raw .= '~cd_title:'.$_POST['cd_title'].'~cd_module:'.$_POST['cd_module'].'~cd_trainer:'.$_POST['cd_trainer'].'~cd_avmark:'.$_POST['cd_avmark'];
		for ($i=1; $i<11; $i++) {
			if ($_POST['cd_custom'.$i] <> '') $raw .= '~cd_custom'.$i.':'.$_POST['cd_custom'.$i];
		}
		$raw .= '~td_name:'.$_POST['td_name'].'~td_testmark:'.$_POST['td_testmark'].'~td_retries:'.$_POST['td_retries'];
		
		if ($rupdate == 0) {
			$qid = $db->nextId("AUTO_REPORT_QUERIES");
			$sql = "INSERT INTO report_queries VALUES ($qid, $report_id, '$query_ss', '$s_from', '$friendly', $course_flag, '$raw')";
			$res = $db->query($sql);
		} else {
			$sql = "UPDATE report_queries SET q_text='$query_ss', q_from='$s_from', q_friendly='$friendly', q_course_flag=$course_flag, q_raw='$raw' WHERE r_id=$report_id";
			$res = $db->query($sql);
		}
		
		/* Column update: gather column names */
		$posts = array( "ud_login", "ud_first_name", "ud_last_name", "ud_email", "ud_category", "ud_group", 
			"ud_custom1", "ud_custom2", "ud_custom3", "ud_custom4", "ud_custom5", "ud_custom6", "ud_custom7", "ud_custom8", "ud_custom9", "ud_custom10",
			"cd_title", "cd_module", "cd_trainer", "cd_avmark",
			"cd_custom1", "cd_custom2", "cd_custom3", "cd_custom4", "cd_custom5", "cd_custom6", "cd_custom7", "cd_custom8", "cd_custom9", "cd_custom10", 
			"td_name", "td_testmark", "td_retries"
		);
		$cols = '';
		foreach ($posts as $k => $val) {
			if ( isset($_POST[$val]) ) {
				$cols .= $val.',';
			}
		}
		$len = strlen($cols);
		if ( $cols[$len-1] == ',' ) $cols = substr($cols, 0, $len -1);
		$sql = "SELECT id FROM report_columns WHERE report=$report_id";
		$res = $db->query($sql);
		if ($row = $res->fetchRow()) {
			$sql = "UPDATE report_columns SET cols='".$cols."' WHERE report=$report_id";
		} else {
			$coldef_id = $db->nextId("AUTO_REPORT_COLUMNS_ID");
			$sql = "INSERT INTO report_columns VALUES ($coldef_id, $report_id, '".$cols."')";
		}
		$res = $db->query($sql);
	}
	
?>

<script>

function click_sel()
{
 document.all.val.value=document.all.sel.value;
}

function update(action)
{
 document.report_form.action.value=action;
 document.report_form.editing.value='no';
 // document.report_form.submit();
}

function filllist()
{
 document.report_form.val.value=document.report_form.form_list.value;
}

function change_cat()
{
 document.report_form.attr.value='';
 document.report_form.submit();
}

function enableTest() {
	report_form.tests.disabled = false;
}

function getEnrCourses(myForm, myArray, sliceLength) {
  var arrayLength = myArray.length;
  var selMakeIndex = myForm.enr_modules.selectedIndex;
  var selMake = myForm.enr_modules.options[selMakeIndex].text;
  myForm.enr_courses.options.length = 0;
  myForm.tests.options.length = 0;
  var modelIndex = 0;
  var testIndex = 0;

  myForm.enr_courses.options[modelIndex] =
  	new Option ("<?php echo $_template['any_course']; ?>", "-1");
  myForm.tests.options[modelIndex] = new Option ("<?php echo $_template['no_condition']; ?>", "-1");
  modelIndex++;
  testIndex++;

  for (var i=0;i<arrayLength;i++) {
    if (selMake == myArray[i][0]) {
      for (var j=1;j<myArray[i].length;j++) {
        var splitArray = myArray[i][j].split(":");
        var modelName = splitArray[0];
        var value = splitArray[1];
		
		var tid = 2;
		while ( splitArray[tid] ) {
			var tname = splitArray[tid++];
			var tvalue = splitArray[tid++];
			if (!tname.match(/.Discontinued./)) {
				myForm.tests.options[testIndex] = 
					new Option (tname.slice(0,sliceLength), tvalue);
				testIndex++;
			}
		}

        if (!modelName.match(/.Discontinued./)) {
          myForm.enr_courses.options[modelIndex] =
            new Option (modelName.slice(0,sliceLength), value);
          modelIndex++;
        }
      } // for j
    }
  } // for i
  
  myForm.tests.selectedIndex = 0;
  //myForm.test_op.disabled = false;
  //myForm.testmark.disabled = false;

  myForm.enr_courses.selectedIndex = 0;
  myForm.enr_courses.disabled = false;
  myForm.enr_courses.focus();
}

function getSGroups(myForm, myArray, sliceLength) {
  var arrayLength = myArray.length;
  var selMakeIndex = myForm.s_categories.selectedIndex;
  var selMake = myForm.s_categories.options[selMakeIndex].text;
  myForm.s_groups.options.length = 0;
  var modelIndex = 0;

  myForm.s_groups.options[modelIndex] =
  	new Option ("<?php echo $_template['all_groups']; ?>", "-1");
  modelIndex++;

  for (var i=0;i<arrayLength;i++) {
    if (selMake == myArray[i][0]) {
      for (var j=1;j<myArray[i].length;j++) {
        var splitArray = myArray[i][j].split(":");
        var modelName = splitArray[0];
        var value = splitArray[1];

        if (!modelName.match(/.Discontinued./)) {
          myForm.s_groups.options[modelIndex] =
            new Option (modelName.slice(0,sliceLength), value);
          modelIndex++;
        }
      } // for j
    }
  } // for i
  
  myForm.s_groups.selectedIndex = 0;
  myForm.s_groups.disabled = false;
  myForm.s_groups.focus();
}

function toggleFF(el, datafield, opfield) {
	if ( !el.checked ) {
		datafield.disabled = true;
		opfield.disabled = true;
	} else {
		datafield.disabled = false;
		opfield.disabled = false;
	}
}

</script>

<script language="JavaScript" src="include/calendar/ts_picker.js">

//Script by Denis Gritcyuk: tspicker@yahoo.com
//Submitted to JavaScript Kit (http://javascriptkit.com)
//Visit http://javascriptkit.com for this script

</script>

<?php
	echo '<script language="JavaScript">';
	$sql = "SELECT COUNT(*) FROM course_groups";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$modulesCount = $row[0];
	$sql = "SELECT COUNT(categ_id) FROM member_categ";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$categCount = $row[0];
	
	echo "\n".'var modules = new Array('.$modulesCount.');'."\n";
	echo "\n".'var categories = new Array('.$categCount.');'."\n";
	
	// Building Course Modules Array
	$sql = "SELECT * FROM course_groups";
	$res = $db->query($sql);
	$i = 0;
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT G.course_id, C.title FROM crel_groups G INNER JOIN courses C ON G.course_id=C.course_id WHERE G.group_id=$row[GROUP_ID]";
		$resm = $db->query($sql);
		echo 'modules['.$i++.'] = new Array("'.$row['NAME'].'"';
		while ($rowm = $resm->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo ', "'.$rowm['TITLE'].':'.$rowm['COURSE_ID'];
			$sql = "SELECT title, test_id FROM tests WHERE course_id=$rowm[COURSE_ID]";
			$rest = $db->query($sql);
			while ($rowt = $rest->fetchRow(DB_FETCHMODE_ASSOC)) {
				echo ':'.$rowt['TITLE'].':'.$rowt['TEST_ID'];
			}
			echo '"';
		}
		echo ');';
		echo "\n";
	}
	
	// Building Member Categories Array
	$sql = "SELECT * FROM member_categ";
	$res = $db->query($sql);
	$i = 0;
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT group_id, name FROM member_groups WHERE category='".$row[NAME]."'";
		$resm = $db->query($sql);
		echo 'categories['.$i++.'] = new Array("'.$row['NAME'].'"';
		while ($rowm = $resm->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo ', "'.$rowm['NAME'].':'.$rowm['GROUP_ID'];
			echo '"';
		}
		echo ');';
		echo "\n";
	}
	echo '</script>';
	
	// Retrieving report queries
	if ($report_id >0) {
		$sql = "SELECT * FROM report_queries WHERE r_id=$report_id";
		$res = $db->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$friendly = $row['Q_FRIENDLY'];
		$s_from = $row['Q_FROM'];
		$query = $row['Q_TEXT'];
		$q_id = $row['Q_ID'];
		$q_raw = $row['Q_RAW'];
		$q_cflag = $row['Q_COURSE_FLAG'];

		// Creting / updating dynamic groups from report queries
		if ($_GET['dyn'] == 1) {
			$sql = "SELECT COUNT(id) FROM dyn_groups WHERE id=$report_id";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			if ($row[0] >0) {
				// updating
				$sql = "UPDATE dyn_groups SET name='$report_name', description='$report_desc'";
				$res = $db->query($sql);
				$sql = "UPDATE dyn_queries SET r_id=$report_id, qtext=$query, q_from=$s_from, q_course_flag=$q_cflag";
				$res = $db->query($sql);
			} else {
				// inserting
				$sql = "INSERT INTO dyn_groups VALUES ($report_id, '$report_name', '$report_desc')";
				$res = $db->query($sql);
				$sql = "INSERT INTO dyn_queries VALUES ($q_id, $report_id, '$query', '$s_from', $q_cflag)";
				$res = $db->query($sql);
			}
			
			$feedback[] = AT_FEEDBACK_DYN_GROUP_CREATED;
			print_feedback($feedback);
		}
	}
?>


<br>
<br><h1>K-Lore Report Builder</h1><br>
<form action="<?php echo $PHP_SELF; ?>" name="report_form" method="post">
<input type="hidden" name="action">
<input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
<INPUT type="hidden" name="query_id" value="<?php echo $query_id ?>">
<INPUT type="hidden" name="column_id" value="<?php echo $column_id ?>">
<INPUT type="hidden" name="editing" value="<?php echo $editing ?>">

<table cellspacing="1" cellpadding="1" border="0" align="center" width="75%" align="left">
<tr>
	<td width="100">
		<b><?php echo $_template['report_name']; ?></b></td>
	<td>
		<INPUT type="text" name="report_name" class="formfield2" value="<?php echo $report_name ?>" size="20">
		<!-- input type="submit" name="update" class="button" accesskey="s" onClick="javascript:void(update('ReportUpdate'))" value="Update"-->
		</td>
	<td align="right" rowspan="2" valign="bottom">
	<table cellpadding="0" cellspacing="4" border="0" class="framework" align="center" width="300px">
		<tr><td align="left">
			<A href="reports/report_view2.php<?php echo '?rid='.$report_id.'&view=1';?>"><img border="0" src="images/eyeicon.gif"><?php echo $_template['view_report']; ?></A></td></tr>
		<tr><td align="left">
			<A href="<?php echo $PHP_SELF.'?report_id='.$report_id.'&dyn=1'; ?>"><img border="0" src="images/menu/dyn_group.gif"><?php echo $_template['create_dynamic_group']; ?></A><td></tr>
		<tr><td align="right">
			<A href="reports/index.php"><?php echo $_template['return_to_reports_index']; ?><img border="0" src="images/menu/back_to_report_index.gif"></a></td></tr>
	</table>
	</td>
</tr>
<tr>
	<td><b><?php echo $_template['report_description']; ?></b></td>
	<td>
		<textarea cols="32" rows="4" class="formfield2" name="report_desc"><?php echo $report_desc; ?></textarea></td>
	<td>&nbsp;</td>
</tr>
</table>

<table cellspacing="1" cellpadding="1" border="0" align="center" width="75%" align="left">
<tr>
	<td>
		<b><?php echo $_template['current_query']; ?></b>
		<hr>
	</td></tr>
<tr><td>
		<?php
			$farray = split("~", $friendly);
			foreach($farray as $f => $fval) {
				echo $fval.'<br>';
			}
		?>
	</td>
</tr>
</table>

<?php
	$rawdata = split("~", $q_raw);
	$raw = array();
	foreach ($rawdata as $k => $pair) {
		$tk = split(":", $pair);
		$raw[$tk[0]] = $tk[1];
	}
?>

<br>
<TABLE align="center" cellpadding="1" cellspacing="4" border="0" align="center" class="bodyline" width="75%">
<tr><td class="mrow1" colspan="3"><?php echo '<b>'.$_template['student1'].' - '.$_template['new_query'].' </b> ' ?></th></tr>
<tr>
	<td valign="top">
		<?php echo $_template['category']; ?><br><br><?php echo $_template['group']; ?></td>
	<td valign="top">
		<select name="s_categories" onChange="getSGroups(report_form, categories, 24)">
			<option value="-1"><?php echo $_template['all_categories']; ?></option>
			<?php
				$sql = "SELECT * FROM member_categ";
				$res_tmp = $db->query($sql);
				while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
					$selected = '';
					if ($raw['s_categories'] == $row_tmp['NAME']) {
						$selected = 'selected="selected"';
						$selcateg = $row_tmp['NAME'];
					}
					echo '<option value="'.$row_tmp['NAME'].'" '.$selected.'>'.$row_tmp['NAME'].'</option>'."\n";
				}
			?>
		</select><br><br>
		<select name="s_groups">
			<option value="-1"><?php echo $_template['all_groups']; ?></option>
			<?php
				$sql = "SELECT * FROM member_groups WHERE category='$selcateg'";
				$res_tmp = $db->query($sql);
				while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
					$selected = '';
					if ($raw['s_groups'] == $row_tmp['GROUP_ID']) $selected='selected="selected"';
					echo '<option value="'.$row_tmp['GROUP_ID'].'" '.$selected.'>'.$row_tmp['NAME'].'</option>'."\n";
				}
			?>
		</select>
	</td>
	<td>
		<?php
			$sql = "SELECT * FROM user_custom_fields ORDER BY id";
			$res_cf = $db->query($sql);
			$fcount = 1;
			echo '<table cellspacing="1" cellpading="1" border="0">';
			while ($row_cf = $res_cf->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($row_cf['MANDATORY'] == 1) {
					echo '<tr><td>'.$row_cf['NAME'].':</td>';
					echo '<td><input type="text" class="formfield2" size="32" name="custom_'.$fcount.'" value="'.$raw['custom_'.$fcount].'"></td>'."\n";
					echo '</tr>';
				}
				$fcount++;
			}
			echo '</table>';
		?>
	</td>
</tr>
<tr><td colspan="3"><hr></td></tr>
<tr>
	<td align="left" colspan="2"><b>
	<?php 
		if ($raw['qtype'] == 'qtype_enr'){
			$checked_enr = 'checked="checked"';
		} else if ($raw['qtype'] == 'qtype_cmp') {
			$checked_cmp = 'checked="checked"';
		} else {
			$checked_enr = 'checked="checked"';
		}
		echo '<input type="radio" '.$checked_enr.' name="qtype" value="qtype_enr">'.$_template['enrolled_to'].'<br>';
		echo '<input type="radio" '.$checked_cmp.' name="qtype" value="qtype_cmp">'.$_template['completed_course'];
	?>
	</td>
	<td align="right"><b><?php echo $_template['individual_test']; ?></b></td>

<tr>
<tr>
	<td><img src="images/spacer.gif" width="40" height="1"></td>
	<td><img src="images/spacer.gif" width="250" height="1"></td>
	<td><img src="images/spacer.gif" width="250" height="1"></td>
</tr>

<td align="left" valign="bottom">
		<?php echo $_template['module'].' &nbsp; ' ?></td>
<td align="left">
		<select name="enr_modules" onChange="getEnrCourses(report_form, modules, 24)">
		<option value="-1"><?php echo $_template['all_modules']; ?></option>
		<?php 
			$sql = "SELECT name, group_id FROM course_groups";
			$res = $db->query($sql);
			while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
				$selected = '';
				if ($raw['enr_modules'] == $row['GROUP_ID']) {
					$selected = 'selected="selected"';
					$selmodule = $row['GROUP_ID'];
				}
				echo '<option value="'.$row['GROUP_ID'].'" '.$selected.'>'.$row['NAME'].'</option>';
				echo "\n";
			}
		?>
		</select>
</td>
	
<td align="right">
		<select name="tests">
		<?php 
			$sql = "SELECT title, test_id FROM tests";
			$res = $db->query($sql);
			echo '<option value="-1">'.$_template['no_condition'].'</option>';
			while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
				$selected = '';
				if ($raw['tests'] == $row['TEST_ID']) $selected = 'selected="selected"';
				echo '<option value="'.$row['TEST_ID'].'" '.$selected.'>'.$row['TITLE'].'</option>';
				echo "\n";
			}
		?>
		</select>
</td>
</tr>


<tr>
	<td>
			<br><?php echo $_template['course'].' &nbsp; ' ?></td>
	<td align="left">
			<select name="enr_courses">
			<option value="-1"><?php echo $_template['any_course']; ?></option>
			<?php
				if ($selmodule == '') $selmodule = 0;
				$sql = "SELECT courses.title, crel_groups.course_id FROM courses, crel_groups WHERE crel_groups.group_id=$selmodule AND crel_groups.course_id=courses.course_id";
				$res_tmp = $db->query($sql);
				while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
					$selected = '';
					if ($raw['enr_courses'] == $row_tmp['COURSE_ID']) $selected='selected="selected"';
					echo '<option value="'.$row_tmp['COURSE_ID'].'" '.$selected.'>'.$row_tmp['TITLE'].'</option>'."\n";
				}
			?>
			</select>
	</td>

	<td align="right">
		<?php 
			echo $_template['mark']; 
		?>:&nbsp;
		<select  name="test_op" <?php if ($raw['cb_t_mark']=='') echo 'disabled'; ?> >
		<option value=">" <?php if ($raw['test_op']==">") echo 'selected="selected"'; ?> >></option>
		<option value="<" <?php if ($raw['test_op']=="<") echo 'selected="selected"'; ?> ><</option>
		<option value="=" <?php if ($raw['test_op']=="=") echo 'selected="selected"'; ?> >=</option>
		<option value="<>" <?php if ($raw['test_op']=="<>") echo 'selected="selected"'; ?> ><></option>
		</select>
		<input  type="text" class="formfield2" size="4" name="testmark" value="<?php echo $raw['testmark']; ?>" <?php if ($raw['cb_t_mark']=='') echo 'disabled'; ?> >
		<input type="checkbox" class="formfield2" name="cb_t_mark" <?php if ($raw['cb_t_mark'] <> '') echo 'checked="'.$raw['cb_t_mark'].'"'; ?> onClick="toggleFF(cb_t_mark, testmark, test_op)">
	</td>
</tr>

<tr>
	<td><?php echo $_template['course_trainer']; ?></td>
	<td align="left">
		<select name="c_instructor">
			<option value="-1"><?php echo $_template['any_trainer']; ?></option>
			<?php
			$statuslist = STATUS_ADMINISTRATOR.','.STATUS_TRAINER.','.STATUS_TRAINING_MANAGER;
			$sql = "SELECT M.member_id, P.first_name, P.last_name FROM members M INNER JOIN members_pers P ON M.member_id=P.member_id WHERE M.status IN ($statuslist)";
			$res_i = $db->query($sql);
			while ($row_i = $res_i->fetchRow(DB_FETCHMODE_ASSOC)) {
				$selected = '';
				if ($raw['c_instructor']==$row_i['MEMBER_ID']) $selected = 'selected="selected"'; else $selected = '';
				echo '<option value="'.$row_i['MEMBER_ID'].'" '.$selected.'>'.$row_i['FIRST_NAME'].' '.$row_i['LAST_NAME'].'</option>'."\n";
			}
			?>
		</select>
	</td>
	<td align="right"> 
		<?php echo $_template['retries']; ?>: 
		<select name="testr_op" disabled>
			<option value=">" <?php if ($raw['testr_op']==">") echo 'selected="selected"'; ?> >></option>
			<option value="<" <?php if ($raw['testr_op']=="<") echo 'selected="selected"'; ?> ><</option>
			<option value="=" <?php if ($raw['testr_op']=="=") echo 'selected="selected"'; ?> >=</option>
			<option value="<>" <?php if ($raw['testr_op']=="<>") echo 'selected="selected"'; ?> ><></option>
		</select>
		<input type="text" size="4" name="test_retries" class="formfield2" value="<?php echo $raw['test_retries']; ?>" <?php if ($raw['cb_t_retries']=='') echo 'disabled'; ?> >
		<input type="checkbox" class="formfield2" name="cb_t_retries" <?php if ($raw['cb_t_retries'] <> '') echo 'checked="'.$raw['cb_t_retries'].'"'; ?> onClick="toggleFF(cb_t_retries, test_retries, testr_op)">
	</td>
</tr>

<tr>
	<td><?php echo $_template['average_mark']; ?></td>
	<td>
		<select name="cmark_op" <?php if ($raw['cb_c_mark']=='') echo 'disabled'; ?> >
			<option value=">" <?php if ($raw['cmark_op']==">") echo 'selected="selected"'; ?> >></option>
			<option value="<" <?php if ($raw['cmark_op']=="<") echo 'selected="selected"'; ?> ><</option>
			<option value="=" <?php if ($raw['cmark_op']=="=") echo 'selected="selected"'; ?> >=</option>
			<option value="<>" <?php if ($raw['cmark_op']=="<>") echo 'selected="selected"'; ?> ><></option>
		</select>
		<input type="text" class="formfield2" size="4" name="c_mark" value="<?php echo $raw['c_mark']; ?>" <?php if ($raw['c_mark']=='') echo 'disabled'; ?> >
		<input type="checkbox" class="formfield2" name="cb_c_mark" <?php if ($raw['cb_c_mark'] <> '') echo 'checked="'.$raw['cb_c_mark'].'"'; ?> onClick="toggleFF(cb_c_mark, c_mark, cmark_op)">
	</td>
	<td align="right"><?php echo $_template['date']; ?>: 
		<select name="testdate_op" <?php if ($raw['cb_t_start']=='') echo 'disabled'; ?>>
			<option value=">" <?php if ($raw['testdate_op']==">") echo 'selected="selected"'; ?> >></option>
			<option value="<" <?php if ($raw['testdate_op']=="<") echo 'selected="selected"'; ?> ><</option>
			<option value="=" <?php if ($raw['testdate_op']=="=") echo 'selected="selected"'; ?> >=</option>
			<option value="<>" <?php if ($raw['testdate_op']=="<>") echo 'selected="selected"'; ?> ><></option>
		</select>
		<?php $t_start = str_replace(".", ":", $raw['t_start']); ?>
		<input type="text" class="formfield2" name="t_start" size="24" value="<?php echo $t_start; ?>" <?php if ($raw['cb_t_start']=='') echo 'disabled'; ?> >
		<a href="javascript:show_calendar('document.report_form.t_start', document.report_form.t_start.value);"><img src="images/cal/cal.gif" width="16" height="16" border="0" alt="<?php echo $_template['pick_up_timestamp']; ?>"></a>
		<input type="checkbox" class="formfield2" name="cb_t_start" <?php if ($raw['cb_t_start'] <> '') echo 'checked="'.$raw['cb_t_start'].'"'; ?> onClick="toggleFF(cb_t_start, t_start, testdate_op)">
	</td>
</tr>

<tr>
	<td><?php echo $_template['date']; ?></td>
	<td>
		<select name="coursedate_op" <?php if ($raw['cb_c_start']=='') echo 'disabled'; ?> >
			<option value=">" <?php if ($raw['coursedate_op']==">") echo 'selected="selected"'; ?> >></option>
			<option value="<" <?php if ($raw['coursedate_op']=="<") echo 'selected="selected"'; ?> ><</option>
			<option value="=" <?php if ($raw['coursedate_op']=="=") echo 'selected="selected"'; ?> >=</option>
			<option value="<>" <?php if ($raw['coursedate_op']=="<>") echo 'selected="selected"'; ?> ><></option>
		</select>
		<?php $c_start = str_replace(".", ":", $raw['c_start']); ?>
		<input type="text" class="formfield2" name="c_start" size="24" value="<?php echo $c_start; ?>" <?php if ($raw['cb_c_start']=='') echo 'disabled'; ?> >
		<a href="javascript:show_calendar('document.report_form.c_start', document.report_form.c_start.value);"><img src="images/cal/cal.gif" width="16" height="16" border="0" alt="<?php echo $_template['pick_up_timestamp']; ?>"></a>
		<input type="checkbox" class="formfield2" name="cb_c_start" <?php if ($raw['cb_c_start'] <> '') echo 'checked="'.$raw['cb_c_start'].'"'; ?> onClick="toggleFF(cb_c_start, c_start, coursedate_op)">
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="3" align="center">
		<input type="submit" class="button" name="add_constrains" value="<?php echo $_template['add_query']; ?>" accesskey="s" onClick="update('Add Query')">
	</td>
</tr>
</table>
</br>

<TABLE align="center" cellpadding="1" cellspacing="4" border="0" align="center" class="bodyline" width="75%">
<tr>
	<td colspan="3" class="mrow1"><b>
		<?php echo $_template['report_columns']; ?>
		</b>
	</td>
</tr>
<tr>
	<?php
		$coldef = array( 
			"user_details" => "login, first_name, last_name, email, category, group, custom",
			"login" => "members.login",
			"first_name" => "members_pers.first_name",
			"last_name" => "members_pers.last_name",
			"email" => "members.email",
			"category" => "member_groups.category",
			"group" => "member_groups.name",
			"course_title" => "courses.title",
			"course_trainer" => "courses.member_id",
			"course_module" => "course_groups.name",
		);
		
		echo '<th>'.$_template['user_details'].'</th>';
		echo '<th>'.$_template['course_details'].'</th>';
		echo '<th>'.$_template['test_details'].'</th>';
	?>
</tr>
<tr>
	<td align="left">
		<?php 
			if ($raw['ud_login']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_login" '.$checked.'>'.$_template['login'].'<br>';
			if ($raw['ud_first_name']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_first_name" '.$checked.'>'.$_template['first_name'].'<br>';
			if ($raw['ud_last_name']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_last_name" '.$checked.'>'.$_template['last_name'].'<br>';
			if ($raw['ud_email']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_email" '.$checked.'>'.$_template['email'].'<br>';

			if ($raw['ud_category']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_category" '.$checked.'>'.$_template['category'].'<br>';
			if ($raw['ud_group']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="ud_group" '.$checked.'>'.$_template['group'].'<br>';
			$sql = "SELECT * FROM user_custom_fields ORDER BY id";
			$res_s2 = $db->query($sql);
			$i =1;
			while ($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($row['MANDATORY'] >0) {	
					if ($raw['ud_custom'.$i]<>'') $checked = 'checked="checked"'; else $checked = '';
					echo '<input type="checkbox" name="ud_custom'.$i.'" '.$checked.'>'.$row['NAME'].'<br>';
				}
				$i++;
			}
			
			$sql = "SELECT * FROM user_custom_fields ORDER BY id";
			$res_s2 = $db->query($sql);
			$i =1;
			while($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
				if (($row['MANDATORY'] ==0) && ($row['NAME'] <>'')) {
					if ($raw['ud_custom'.$i]<>'') $checked = 'checked="checked"'; else $checked = '';
					echo '<input type="checkbox" name="ud_custom'.$i.'" '.$checked.'>'.$row['NAME'].'<br>';
				}
				$i++;
			}
		?>
	</td>
	<td valign="top">
		<?php
			if ($raw['cd_title']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="cd_title" '.$checked.'>'.$_template['title'].'<br>';
			if ($raw['cd_module']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="cd_module" '.$checked.'>'.$_template['module'].'<br>';
			if ($raw['cd_trainer']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="cd_trainer" '.$checked.'>'.$_template['trainer'].'<br>';

			if ($raw['cd_avmark']<>'') $checked = 'checked="checked"'; else $checked = '';
			echo '<input type="checkbox" name="cd_avmark" '.$checked.'>'.$_template['average_mark'].'<br>';
		
			$sql = "SELECT * FROM course_custom_fields ORDER BY id";
			$res_s2 = $db->query($sql);
			$i =1;
			while ($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($row['MANDATORY'] >0) {	
					if ($raw['cd_custom'.$i]<>'') $checked = 'checked="checked"'; else $checked = '';
					echo '<input type="checkbox" name="cd_custom'.$i.'" '.$checked.'>'.$row['NAME'].'<br>';
				}
				$i++;
			}
			
			$sql = "SELECT * FROM course_custom_fields ORDER BY id";
			$res_s2 = $db->query($sql);
			$i =1;
			while($row =$res_s2->fetchRow(DB_FETCHMODE_ASSOC)) {
				if (($row['MANDATORY'] ==0) && ($row['NAME'] <>'')) {
					if ($raw['cd_custom'.$i]<>'') $checked = 'checked="checked"'; else $checked = '';
					echo '<input type="checkbox" name="cd_custom'.$i.'" '.$checked.'>'.$row['NAME'].'<br>';
				}
				$i++;
			}
		?>
	</td>
	<td valign="top">
		<?php
		if ($raw['td_name']<>'') $checked = 'checked="checked"'; else $checked = '';
		echo '<input type="checkbox" name="td_name" '.$checked.'>'.$_template['test_name'].'<br>';
		if ($raw['td_testmark']<>'') $checked = 'checked="checked"'; else $checked = '';
		echo '<input type="checkbox" name="td_testmark" '.$checked.'>'.$_template['test_mark'].'<br>';
		if ($raw['td_retries']<>'') $checked = 'checked="checked"'; else $checked = '';
		echo '<input type="checkbox" name="td_retries" '.$checked.'>'.$_template['retries'].'<br>';
		?>
	</td>
</tr>
</table>


<br>
<table cellpadding="0" cellspacing="0" border="0" class="framework" align="center" width="300px">
<tr><td align="center">
	<input type="submit" class="button" name="add_constrains" value="<?php echo $_template['save_report']; ?>" onClick="update('Add Query')">
</td></tr>
</table>
</form>

</table>
<?php 
	require ($_include_path.'cc_html/footer.inc.php');
?>