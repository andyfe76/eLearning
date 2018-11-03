<?php
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];

require($_include_path.'header.inc.php');


?>
<?php
	echo '<br />';
?>
<h1><?php echo $_template['completed_tests']; ?></h1><br>
<?php
	
	$sql = "SELECT T.min_grade, T.title, T.course_id, R.* FROM tests T INNER JOIN tests_results R ON T.test_id=R.test_id WHERE R.member_id=$_SESSION[member_id] AND T.course_id=$_SESSION[course_id] ORDER BY R.date_taken";

//	$sql	= "SELECT T.min_grade, T.title, T.course_id, R.*, SUM(Q.weight) AS outof FROM tests T, tests_results R, tests_questions Q WHERE Q.test_id=T.test_id AND R.member_id=$_SESSION[member_id] AND R.test_id=T.test_id AND T.course_id=$_SESSION[course_id] GROUP BY R.result_id ORDER BY R.date_taken";
	
	$result	= $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	$num_results = $count0[0];

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$this_course_id=0;

		do {
			$tid = $row['TEST_ID'];
			$sql = "SELECT SUM(weight) AS outof FROM tests_questions WHERE test_id=$tid";
			
			$res_q = $db->query($sql);
			$row_q = $res_q->fetchRow(DB_FETCHMODE_ASSOC);
			
			
			if ($this_course_id != $row['COURSE_ID']) {
				if ($this_course_id > 0) {
					echo '</table><br />';
				}
				echo '<h4>'.$system_courses[$row['COURSE_ID']]['title'].'</h4>';
				echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
				echo '<tr>';
				echo '<th scope="col"><small>'.$_template['title'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
				echo '<th scope="col"><small>'.$_template['test_passed'].'</small></th>';//*** added
				echo '</tr>';

				$this_course_id = $row['COURSE_ID'];
				$count =0;
			}

			if ($count > 0){
				echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
			}

			$count++;
			echo '<tr>';
			echo '<td class="row1"><small><b>'.$row['TITLE'].'</b></small></td>';
			echo '<td class="row1"><small>'.$row['DATE_TAKEN'].'</small></td>';
			echo '<td class="row1" align="right"><small>';
			if (!(strpos($row['FINAL_SCORE'], 'unmk') === false)) {
				echo '<em>'.$_template['unmarked'].'</em>';
			} else {
				echo '<strong>'.$row['FINAL_SCORE'].'</strong>/'.$row_q['OUTOF'];
			}
			echo '</small></td>';

			echo '<td class="row1" align="center"><small>';

			if (strpos($row['FINAL_SCORE'], 'unmk') === false) {
				echo '<a href="tools/view_results.php?tid='.$row['TEST_ID'].SEP.'rid='.$row['RESULT_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['view_results'].'</a>';
			} else {
				echo '<em>'.$_template['no_results_yet'].'</em>';
			}

			echo '</small></td>';
			
			echo '<td class="row1">';
			
			//*** added
			$min_gr=intval($row['MIN_GRADE']);//*** added
			if (intval($row['FINAL_SCORE'])>=$min_gr)
			{
				echo $_template['yes'];
			}
			else 
			{
				echo $_template['no'];
			}
			echo '</td>';

			echo '</tr>';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		echo '</table>';
	} else {
		echo '<i>'.$_template['no_results_available'].'</i>';
	}

	echo '<br />';

	require($_include_path.'footer.inc.php');
?>
