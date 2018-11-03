<?php
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];

require($_include_path.'header.inc.php');


?>
<?php
/*echo '<h1>'.$_template['my_tests'].'</h1><br>';

	$sql	= "SELECT T.*, UNIX_TIMESTAMP(T.start_date) AS us, UNIX_TIMESTAMP(T.end_date) AS ue, SUM(Q.weight) AS outof, COUNT(Q.weight) AS numquestions FROM tests T, tests_questions Q WHERE Q.test_id=T.test_id AND T.course_id=$_SESSION[course_id] GROUP BY T.test_id ORDER BY T.start_date, T.title";
	$result	= mysql_query($sql, $db);
	$num_tests = mysql_num_rows($result);

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary=""  width="90%" align="center">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['status'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['title'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['start_date'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['end_date'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['questions'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['out_of'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['take_test'].'</small></th>';
	echo '</tr>';

	if ($row = mysql_fetch_array($result)) {
		do {
			$count++;
			echo '<tr>';
			echo '<td class="row1"><small>';
			if ( ($row['us'] <= time()) && ($row['ue'] >= time() ) ) {
				echo '<i><b>'.$_template['ongoing'].'</b></i>';
			} else if ($row['ue'] < time() ) {
				echo '<i>'.$_template['expired'].'</i>';
			} else if ($row['us'] > time() ) {
				echo '<i>'.$_template['pending'].'</i>';
			}
			echo '</small></td>';
			echo '<td class="row1"><small><b>'.$row['title'].'</b></small></td>';
			echo '<td class="row1"><small>'.substr($row['start_date'], 0, -3).'</small></td>';
			echo '<td class="row1"><small>'.substr($row['end_date'], 0, -3).'</small></td>';
			echo '<td class="row1" align="right"><small>'.$row['numquestions'].'</small></td>';
			echo '<td class="row1" align="right"><small>'.$row['outof'].'</small></td>';
			echo '<td class="row1">';
			if ( ($row['us'] <= time()) && ($row['ue'] >= time() ) ) {
				$sql = "SELECT * FROM test_process WHERE test_id=$row[test_id] AND member_id=$_SESSION[member_id]";
				$process = mysql_query($sql, $db);
				$prow = mysql_fetch_array($process);
				if (($prow['retries'] < $row['retries']) && ($prow['retries'] >0)) {
					echo '<small><a href="tools/take_test.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].SEP.'retry=1">'.$_template['retry_test'].'</a>';
				} else if ($prow['retries'] >0){
					echo '<small><a href="tools/take_test.php?tid='.$row['test_id'].SEP.'tt='.$row['title'].'">'.$_template['take_test'].'</a>';
				} else {
					echo '<small><font style="color: #dd0000">'.$_template['denied'].'</font></small>';
				}
			} else {
				echo '<small class="bigspacer">'.$_template['take_test'].'';
			}
			echo '</small></td>';
			echo '</tr>';

			if ($count < $num_tests) {
				echo '<tr><td height="1" class="row2" colspan="9"></td></tr>';
			}
		} while ($row = mysql_fetch_array($result));
	} else {
		echo '<tr><td colspan="9" class="row1"><small><i>'.$_template['no_tests'].'</i></small></td></tr>';
	}

	echo '</table>';*/

	echo '<br />';
?>
<h1><?php echo $_template['completed_tests']; ?></h1><br>
<?php

	$sql	= "SELECT T.title, T.course_id, R.*, SUM(Q.weight) AS outof FROM tests T, tests_results R, tests_questions Q WHERE Q.test_id=T.test_id AND R.member_id=$_SESSION[member_id] AND R.test_id=T.test_id AND T.course_id=$_SESSION[course_id] GROUP BY R.result_id ORDER BY R.date_taken";
	$result	= mysql_query($sql, $db);
	$num_results = mysql_num_rows($result);

	if ($row = mysql_fetch_array($result)) {
		$this_course_id=0;

		do {
			if ($this_course_id != $row['course_id']) {
				if ($this_course_id > 0) {
					echo '</table><br />';
				}
				echo '<h4>'.$system_courses[$row['course_id']]['title'].'</h4>';
				echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
				echo '<tr>';
				echo '<th scope="col"><small>'.$_template['title'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
				echo '</tr>';

				$this_course_id = $row['course_id'];
				$count =0;
			}

			if ($count > 0){
				echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
			}

			$count++;
			echo '<tr>';
			echo '<td class="row1"><small><b>'.$row['title'].'</b></small></td>';
			echo '<td class="row1"><small>'.$row['date_taken'].'</small></td>';
			echo '<td class="row1" align="right"><small>';
			if ($row['final_score'] == '') {
				echo '<em>'.$_template['unmarked'].'</em>';
			} else {
				echo '<strong>'.$row['final_score'].'</strong>/'.$row['outof'];
			}
			echo '</small></td>';

			echo '<td class="row1" align="center"><small>';

			if ($row['final_score'] != '') {
				echo '<a href="tools/view_results.php?tid='.$row['test_id'].SEP.'rid='.$row['result_id'].SEP.'tt='.$row['title'].'">'.$_template['view_results'].'</a>';
			} else {
				echo '<em>'.$_template['no_results_yet'].'</em>';
			}

			echo '</small></td>';

			echo '</tr>';
		} while ($row = mysql_fetch_array($result));
		echo '</table>';
	} else {
		echo '<i>'.$_template['no_results_available'].'</i>';
	}

	echo '<br />';

	require($_include_path.'footer.inc.php');
?>
