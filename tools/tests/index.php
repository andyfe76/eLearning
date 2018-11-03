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

	echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;[<a href="tools/tests/add_test.php">'.$_template['add_test'].'</a>]<br /></p>';

	$sql	= "SELECT *, UNIX_TIMESTAMP(start_date) AS us, UNIX_TIMESTAMP(end_date) AS ue FROM tests WHERE course_id=$_SESSION[course_id] ORDER BY start_date DESC";
	$result	= mysql_query($sql, $db);
	$num_tests = mysql_num_rows($result);

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['status'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['title'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['availability'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['questions'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['results'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['edit'].' &amp; '.$_template['delete'].'</small></th>';
	echo '</tr>';

	if ($row = mysql_fetch_array($result)) {
		do {
			$count++;
			echo '<tr>';
			echo '<td class="row1"><small>';
			if ( ($row['us'] <= time()) && ($row['ue'] >= time() ) ) {
				echo '<i>'.$_template['ongoing'].'</i>';
			} else if ($row['ue'] < time() ) {
				echo '<i>'.$_template['expired'].'</i>';
			} else if ($row['us'] > time() ) {
				echo '<i>'.$_template['pending'].'</i>';
			}
			$sql = "SELECT * FROM test_type WHERE test_id=$row[test_id]";
			$res = mysql_query($sql, $db);
			$row_type = mysql_fetch_array($res);
			if ($row_type['test_type'] >1) echo '<br><font style="color: #AA0000">'.$_template['offline'].'</font>';
			echo '</small></td>';
			
			echo '<td class="row1"><small>'.$row['title'].'</small></td>';
			echo '<td class="row1"><small>'.AT_date($_SESSION['lang'], '%j/%n/%y %G:%i', $row['start_date'], AT_MYSQL_DATETIME).'<br />'.$_template['to_2'].' ';
			echo AT_date($_SESSION['lang'], '%j/%n/%y %G:%i', $row['end_date'], AT_MYSQL_DATETIME).'</small></td>';
			echo '<td class="row1"><small>';
			$sql	= "SELECT COUNT(*) FROM tests_questions WHERE test_id=$row[test_id]";
			$result2= mysql_query($sql, $db);
			$row2	= mysql_fetch_array($result2);
			if ($row_type['test_type'] <2) {
				echo '&middot; <a href="tools/tests/questions.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$row2[0]. ' '.$_template['questions'].'</a></small></td>';
			}
			echo '<td class="row1"><small>';

			/************************/
			/* Unmarked				*/
			if ($row_type['test_type'] <2) {
				$sql	= "SELECT COUNT(*) FROM tests_results WHERE test_id=$row[test_id] AND final_score=''";
				$result2= mysql_query($sql, $db);
				$row2	= mysql_fetch_array($result2);
				echo '&middot; <a href="tools/tests/results.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$row2[0].' '.$_template['unmarked'].'</a>';
				echo '<br />';
			} 

			/************************/
			/* Results				*/
			$sql	= "SELECT COUNT(*) FROM tests_results WHERE test_id=$row[test_id] AND final_score<>''";
			$result2= mysql_query($sql, $db);
			$row2	= mysql_fetch_array($result2);
			echo '&middot; <a href="tools/tests/results_all.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$row2[0].' '.$_template['results'].'</a>';
			
			echo '<br />';

			if ($row_type <2) {
				/************************/
				/* Preview				*/
				echo '&middot; <a href="tools/tests/preview.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$_template['preview'].'</a>';
			}
				
			echo '</small></td>';
			echo '<td class="row1">';
//			if ($row_type <2) {
				echo '<small>&middot; <a href="tools/tests/edit_test.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$_template['edit_availability'].'</a><br />';
//			}
			echo '&middot; <a href="tools/tests/delete_test.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$_template['delete'].'</a></small>';
			echo '</td>';
			echo '</tr>';
 
			if ($count < $num_tests) {
				echo '<tr><td height="1" class="row2" colspan="9"></td></tr>';
			}
		} while ($row = mysql_fetch_array($result));
	} else {
		echo '<tr><td colspan="9" class="row1"><small><i>'.$_template['no_tests'].'</i></small></td></tr>';
	}

	echo '</table>';

	echo '<br />';

	require($_include_path.'footer.inc.php');
?>