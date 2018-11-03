<?php

	$_include_path = '../../include/';
	session_unregister('test_name');
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_SESSION['test_name']='';

	if (!$_SESSION['is_admin'] && !$_SESSION['c_instructor']) {
		exit;
	}

	require($_include_path.'header.inc.php');

	//echo '<h2><a href="tools/" class="hide" >'.$_template['tools'].'</a></h2>';
	//echo '<h3>'.$_template['test_manager'].'</h3>';
	$help[] = AT_HELP_ADD_TEST1;
	print_help($help);
	/* get a list of all the tests we have, and links to create, edit, delete, preview */

	//echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;[<a href="tools/tests/add_test.php">'.$_template['add_test'].'</a>]<br /></p>';

	$sql	= "SELECT * FROM tests WHERE course_id=$_SESSION[course_id] ORDER BY start_date DESC";
	$result	= $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	$num_tests = $count0[0];

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['status'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['title'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['availability'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['questions'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['results'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['edit'].' &amp; '.$_template['delete'].'</small></th>';
	echo '</tr>';

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			$sql_t1 = "SELECT TO_CHAR(start_date, 'DD/MM/YYYY HH24:MI:SS') AS us, TO_CHAR(end_date, 'DD/MM/YYYY HH24:MI:SS') AS ue FROM tests WHERE course_id=$_SESSION[course_id] AND test_id=$row[TEST_ID]";
			$res_t1 = $db->query($sql_t1);
			$row_t1 = $res_t1->fetchRow(DB_FETCHMODE_ASSOC);
			
			$s_day   = substr($row_t1['US'], 0, 2);
			$s_mon   = substr($row_t1['US'], 3, 2);
			$s_year  = substr($row_t1['US'], 6, 4);
			$s_hour  = substr($row_t1['US'], 11, 2);
			$s_min   = substr($row_t1['US'], 14, 2);
			$sdate = mktime($s_hour, $s_min, 0, $s_mon, $s_day, $s_year);
			
			$e_day   = substr($row_t1['UE'], 0, 2);
			$e_mon   = substr($row_t1['UE'], 3, 2);
			$e_year  = substr($row_t1['UE'], 6, 4);
			$e_hour  = substr($row_t1['UE'], 11, 2);
			$e_min   = substr($row_t1['UE'], 14, 2);
			$edate = mktime($e_hour, $e_min, 0, $e_mon, $e_day, $e_year);
			
			$count++;
			echo '<tr>';
			echo '<td class="row1"><small>';
			if ( ($sdate <= time()) && ($edate >= time() ) ) {
				echo '<i>'.$_template['ongoing'].'</i>';
			} else if ($edate < time() ) {
				echo '<i>'.$_template['expired'].'</i>';
			} else if ($sdate > time() ) {
				echo '<i>'.$_template['pending'].'</i>';
			}
			$sql = "SELECT * FROM test_type WHERE test_id=$row[TEST_ID]";
			$res = $db->query($sql);
			$row_type =$res->fetchRow(DB_FETCHMODE_ASSOC);
			if ($row_type['TEST_TYPE'] >1) echo '<br><font style="color: #AA0000">'.$_template['offline'].'</font>';
			echo '</small></td>';
			
			echo '<td class="row1"><small>'.$row['TITLE'].'</small></td>';
			echo '<td class="row1"><small>'.$row['START_DATE'].'<br />'.$_template['to_2'].' ';
			echo $row['END_DATE'].'</small></td>';
			echo '<td class="row1"><small>';
			$sql	= "SELECT COUNT(*) FROM tests_questions WHERE test_id=$row[TEST_ID]";
			$result2= $db->query($sql);
			$row2	=$result2->fetchRow(DB_FETCHMODE_ASSOC);
			if ($row_type['TEST_TYPE'] <2) {
				echo '&middot; <a href="tools/tests/questions.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'">'.$row2[0]. ' '.$_template['questions'].'</a></small></td>';
			}
			echo '<td class="row1"><small>';

			/************************/
			/* Unmarked				*/
			if ($row_type['TEST_TYPE'] <2) {
				$sql	= "SELECT COUNT(*) FROM tests_results WHERE test_id=$row[TEST_ID] AND final_score=''";
				$result2= $db->query($sql);
				$row2	=$result2->fetchRow(DB_FETCHMODE_ASSOC);
				echo '&middot; <a href="tools/tests/results.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'&m=1">'.$row2[0].' '.$_template['unmarked'].'</a>';
				echo '<br />';//results.php?tid=63&tt=Test Servicii Preplatite&m=1
			} 

			/************************/
			/* Results				*/
			$sql	= "SELECT COUNT(*) FROM tests_results WHERE test_id=$row[TEST_ID] AND final_score<>''";
			$result2= $db->query($sql);
			$row2	=$result2->fetchRow(DB_FETCHMODE_ASSOC);
			echo '&middot; <a href="tools/tests/results.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'">'.$row2[0].' '.$_template['results'].'</a>';
			
			echo '<br />';

			if ($row_type <2) {
				/************************/
				/* Preview				*/
				echo '&middot; <a href="tools/tests/preview.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['preview'].'</a>';
			}
				
			echo '</small></td>';
			echo '<td class="row1">';
//			if ($row_type <2) {
				echo '<small>&middot; <a href="tools/tests/edit_test.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['edit_availability'].'</a><br />';
//			}
			echo '&middot; <a href="tools/tests/delete_test.php?tid='.$row['TEST_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['delete'].'</a></small>';
			echo '</td>';
			echo '</tr>';
 
			if ($count < $num_tests) {
				echo '<tr><td height="1" class="row2" colspan="9"></td></tr>';
			}
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {
		echo '<tr><td colspan="9" class="row1"><small><i>'.$_template['no_tests'].'</i></small></td></tr>';
	}

	echo '</table>';

	echo '<br />';

	require($_include_path.'footer.inc.php');
?>
