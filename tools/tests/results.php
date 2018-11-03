<?php

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests';
	$_section[2][0] = $_template['results'];

	if (!$_SESSION['is_admin']) {
		Header('Location: ../../tools/my_tests.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_SAVED));
		exit;
	}

	require($_include_path.'header.inc.php');

	echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	echo '<h3>'.$_template['results_for'].' '.$_GET['tt'].'</h3>';
	echo '<p><small>';
	if (isset($_GET['m'])) {
		echo '<a href="'.$PHP_SELF.'?tid='.$_GET['tid'].SEP.'tt='.$_GET['tt'].'">'.$_template['show_marked_unmarked'].'</a>';		
	} else {
		echo $_template['show_marked_unmarked'];
	}

	echo ' | ';
	if ($_GET['m'] != 1) {
		echo '<a href="'.$PHP_SELF.'?tid='.$_GET['tid'].SEP.'tt='.$_GET['tt'].SEP.'m=1">'.$_template['show_unmarked'].'</a>';
	} else {
		echo $_template['show_unmarked'];
	}
	echo ' | ';
	if ($_GET['m'] != 2){
		echo '<a href="'.$PHP_SELF.'?tid='.$_GET['tid'].SEP.'tt='.$_GET['tt'].SEP.'m=2">'.$_template['show_marked'].'</a>';
	} else {
		echo $_template['show_marked'];
	}
	
	echo '</small></p>';
	
	$tid = intval($_GET['tid']);
	if ($_GET['m'] == 1) {
		$show = ' AND R.final_score=\'\'';
	} else if ($_GET['m'] == 2) {
		$show = ' AND R.final_score<>\'\'';
	} else {
		$show = '';
	}

	$sql	= "SELECT R.*, M.login FROM tests_results R, members M WHERE R.test_id=$tid AND R.member_id=M.member_id $show ORDER BY date_taken";
 	$result	= mysql_query($sql, $db);
	$num_results = mysql_num_rows($result);

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="90%">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['username'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['view_mark_test'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['delete'].'</small></th>';
	echo '</tr>';

	if ($row = mysql_fetch_array($result)) {
		$count		 = 0;
		$total_score = 0;
		do {
			echo '<tr>';
			echo '<td class="row1"><small><strong>'.$row['login'].'</strong></small></td>';
			echo '<td class="row1"><small>'.AT_date($_SESSION['lang'], '%j/%n/%y %G:%i', $row['date_taken'], AT_MYSQL_DATETIME).'</small></td>';

			echo '<td class="row1" align="center"><small>';
			if ($row['final_score'] != '') {
				echo $row['final_score'];
			} else {
				echo $_template['unmarked'];
			}
			echo '</small></td>';


			echo '<td class="row1" align="center"><small><a href="tools/tests/view_results.php?tid='.$tid.SEP.'rid='.$row['result_id'].SEP.'tt='.$row['login'].SEP.'tt2='.$_GET['tt'].SEP.'m='.$_GET['m'].'">'.$_template['view_mark_test'].'</a></small></td>';

			echo '<td class="row1" align="center"><small><a href="tools/tests/delete_result.php?tid='.$tid.SEP.'tt2='.$_GET['tt'].SEP.'rid='.$row['result_id'].SEP.'tt='.$row['login'].SEP.'m='.$_GET['m'].'">'.$_template['delete'].'</a></small></td>';

			echo '</tr>';
			$count++;
			if ($count < $num_results) {
				echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
			}
		} while ($row = mysql_fetch_array($result));

	} else {
		echo '<tr><td colspan="5" class="row1"><small><em>'.$_template['no_unmarked_results'].'</em></small></td></tr>';
	}

	echo '</table>';

	require($_include_path.'footer.inc.php');
?>