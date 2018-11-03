<?php

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests';
	$_section[2][0] = $_template['results'];

	if (!$_SESSION['is_admin']) {
		exit;
	}
	
	if (isset($_POST['ok'])) {
		$_POST['tid'] = intval($_POST['tid']);
		$sql = "INSERT INTO tests_results VALUES (0, $_POST[tid], $_POST[mid], NOW(), '$_POST[mark]')";
		$res = mysql_query($sql, $db);
		
		$sql	= "INSERT INTO tests_questions VALUES (	0,
				$_POST[tid],
				$_SESSION[course_id],
				0,
				2,
				$_POST[weight],
				$,
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0)";
			$result	= mysql_query($sql, $db);
	}

	require($_include_path.'header.inc.php');

	echo '<br><h2>'.$_template['results_for'].' '.$_GET['tt'].'</h2>';

	if (!$tid) $tid = intval($_GET['tid']);

	$sql	= "SELECT * FROM tests_questions Q WHERE Q.test_id=$tid AND Q.course_id=$_SESSION[course_id] ORDER BY ordering";
 	$result	= mysql_query($sql, $db);
	
	$sql = "SELECT * FROM test_type WHERE test_id=$tid";
	$res = mysql_query($sql, $db);
	$row_type = mysql_fetch_array($res);
	
	$questions = array();
	$total_weight = 0;
	while ($row = mysql_fetch_array($result)) {
		$row['score']	= 0;
		$questions[]	= $row;
		$q_sql .= $row['question_id'].',';
		$total_weight += $row['weight'];
	}
	$q_sql = substr($q_sql, 0, -1);
	$num_questions = count($questions);

	echo '<p><a href="tools/tests/results_all_csv.php?tid='.$tid.SEP.'tt='.$_GET['tt'].'">' . $_template['download_test_csv'] . '</a></p>';

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['username'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['mark'].'/'.$total_weight.'</small></th>';
	if ($row_type['test_type'] <2) {
		for($i = 0; $i< $num_questions; $i++) {
			echo '<th scope="col"><small>Q'.($i+1).'/'.$questions[$i]['weight'].'</small></th>';
		}
	}
	echo '</tr>';

	$sql	= "SELECT R.*, M.login FROM tests_results R, members M WHERE R.test_id=$tid AND R.final_score<>'' AND R.member_id=M.member_id ORDER BY M.login, R.date_taken";
	$result = mysql_query($sql, $db);
	if ($row = mysql_fetch_array($result)) {
		$count		 = 0;
		$total_score = 0;
		do {
			echo '<tr>';
			echo '<td class="row1" align="right"><small><strong>'.$row['login'].'</strong></small></td>';
			echo '<td class="row1"><small>'.AT_date($_SESSION['lang'], '%j/%n/%y %G:%i', $row['date_taken'], AT_MYSQL_DATETIME).'</small></td>';
			echo '<td class="row1" align="right"><small>'.$row['final_score'].'</small></td>';

			$total_score += $row['final_score'];
			
			if ($row_type['test_type'] <2) {
				$answers = array(); /* need this, because we dont know which order they were selected in */
				$sql = "SELECT question_id, score FROM tests_answers WHERE result_id=$row[result_id] AND question_id IN ($q_sql)";
				$result2 = mysql_query($sql, $db);
				while ($row2 = mysql_fetch_array($result2)) {
					$answers[$row2['question_id']] = $row2['score'];
				}
				for($i = 0; $i < $num_questions; $i++) {
					$questions[$i]['score'] += $answers[$questions[$i]['question_id']];
					echo '<td class="row1" align="right"><small>'.$answers[$questions[$i]['question_id']].'</small></td>';
				}
			}	
			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="'.(3+$num_questions).'"></td></tr>';
			$count++;
		} while ($row = mysql_fetch_array($result));

		echo '<tr><td height="1" class="row2" colspan="'.(3+$num_questions).'"></td></tr>';
		echo '<tr>';
		echo '<td colspan="2" class="row1" align="right"><small><strong>'.$_template['average'].':</strong></small></td>';
		echo '<td class="row1" align="right"><small><strong>'.number_format($total_score/$count, 1).'</strong></small></td>';
		
		if ($row_type['test_type'] <2){
			for($i = 0; $i < $num_questions; $i++) {
				echo '<td class="row1" align="right"><small><strong>'.number_format($questions[$i]['score']/$count, 1).'</strong></small></td>';
			}
		}
		echo '</tr>';
		echo '<tr><td height="1" class="row2" colspan="'.(3+$num_questions).'"></td></tr>';

		echo '<tr>';
		echo '<td colspan="2" class="row1"></td>';
		echo '<td class="row1" align="right"><small><strong>'.number_format($total_score/$count/$total_weight*100, 1).'%</strong></small></td>';
		
		if ($row_type['test_type'] <2){ 
			for($i = 0; $i < $num_questions; $i++) {
				echo '<td class="row1" align="right"><small><strong>'.number_format($questions[$i]['score']/$count/$questions[$i]['weight']*100, 1).'%</strong></small></td>';
			}
		}
		echo '</tr>';

	} else {
		echo '<tr><td colspan="'.(3+$num_questions).'" class="row1"><small><i>'.$_template['no_results_available'].'.</i></small></td></tr>';
	}

	echo '</table><br><br>';
	if ($row_type['test_type'] <2) {
		require($_include_path.'footer.inc.php');
		exit;
	}
	
	$sql = "SELECT C.member_id, M.* FROM course_enrollment C, members M WHERE C.course_id=$_SESSION[course_id] AND M.member_id=C.member_id";
	$res = mysql_query($sql, $db);
	
	?>
	<form method="post" action="<?php echo $PHP_SELF; ?>" name="form1">
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
	<tr><td class="row1" valign="baseline" colspan="3">
	
	<?php
	echo '<h2>'.$_template['offline_marking'].'</h2>';
	echo '</td></tr><tr><td class="row1" colspan="3">'.$_template['global_weight'].': <b>'.$total_weight.'</b>';
	echo '</td></tr><tr><td class="row1" valign="bottom">';
	echo '<label for="mid"></label><span style="white-space: nowrap;"><select name="mid" class="dropdown" id="member" title="Member">'."\n";
	while ($row = mysql_fetch_array($res)) {
		if ($row['status'] <2) {
			echo '<option value="'.$row['member_id'].'"';
			echo '>'.$row['login'];
			echo '</option>'."\n";
		}
	}
	echo '</select>&nbsp;'."\n";
	?>
	
	</td>
	<td class="row1" valign="bottom"><input type="text" name="mark">
	</td>
	<td class="row1" valign="bottom"><input type="submit" name="ok" value="<?php echo $_template['mark']; ?>">
	<input type="hidden" name="tid" value="<?php echo $tid; ?>">
	</td>
	</tr>
	</table>
	
	</form>
		
	<?php
	require($_include_path.'footer.inc.php');
?>