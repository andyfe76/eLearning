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
	$tid = intval($_GET['tid']);

	function quote_csv($line) {
		$line = str_replace('"', '""', $line);

		$line = str_replace("\n", '\n', $line);
		$line = str_replace("\r", '\r', $line);
		$line = str_replace("\x00", '\0', $line);

		return '"'.$line.'"';
	}

	header('Content-Type: application/x-excel');
    header('Content-Disposition: inline; filename="'.$_GET['tt'].'.csv"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');


	$sql	= "SELECT * FROM tests_questions Q WHERE Q.test_id=$tid AND Q.course_id=$_SESSION[course_id] ORDER BY ordering";
 	$result	= mysql_query($sql, $db);
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

	$nl = "\n";

	echo quote_csv($_template['username']).', ';
	echo $_template['date_taken'].', ';
	echo $_template['mark'].'/'.$total_weight;
	for($i = 0; $i< $num_questions; $i++) {
		echo ', Q'.($i+1).'/'.$questions[$i]['weight'];
	}
	echo $nl;

	$sql	= "SELECT R.*, M.login FROM tests_results R, members M WHERE R.test_id=$tid AND R.final_score<>'' AND R.member_id=M.member_id ORDER BY M.login, R.date_taken";
	$result = mysql_query($sql, $db);
	if ($row = mysql_fetch_array($result)) {
		$count		 = 0;
		$total_score = 0;
		do {
			echo quote_csv($row['login']).', ';
			echo AT_date($_SESSION['lang'], '%j/%n/%y %G:%i', $row['date_taken'], AT_MYSQL_DATETIME).', ';
			echo $row['final_score'];

			$total_score += $row['final_score'];

			$answers = array(); /* need this, because we dont know which order they were selected in */
			$sql = "SELECT question_id, score FROM tests_answers WHERE result_id=$row[result_id] AND question_id IN ($q_sql)";
			$result2 = mysql_query($sql, $db);
			while ($row2 = mysql_fetch_array($result2)) {
				$answers[$row2['question_id']] = $row2['score'];
			}
			for($i = 0; $i < $num_questions; $i++) {
				$questions[$i]['score'] += $answers[$questions[$i]['question_id']];
				echo ', '.$answers[$questions[$i]['question_id']];
			}

			echo $nl;
			$count++;
		} while ($row = mysql_fetch_array($result));

		echo $nl;

		echo ' , '.$_template['average'].', ';
		echo number_format($total_score/$count, 1);

		for ($i = 0; $i < $num_questions; $i++) {
			echo ', '.number_format($questions[$i]['score']/$count, 1);
		}

		echo $nl;

		echo ' , , '.number_format($total_score/$count/$total_weight*100, 1).'%';

		for($i = 0; $i < $num_questions; $i++) {
			echo ', '.number_format($questions[$i]['score']/$count/$questions[$i]['weight']*100, 1).'%';
		}
		echo $nl;

	}

?>