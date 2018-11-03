<?php
	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/test_result_functions.inc.php');

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests';
	$_section[2][0] = $_template['results'];
	$_section[2][1] = 'tools/tests/results.php?tid='.$_GET['tid'];
	$_section[3][0] = $_template['test_results'];

	if ($_POST['submit']) {
		$tid = intval($_POST['tid']);
		$rid = intval($_POST['rid']);
		
		$final_score = 0;
		if (is_array($_POST['scores'])) {
			foreach ($_POST['scores'] as $qid => $score) {
				$score		  = intval($score);
				$final_score += $score;

				$sql	= "UPDATE tests_answers SET score=$score WHERE result_id=$rid AND question_id=$qid";
				$result	= mysql_unbuffered_query($sql, $db);
			}
		}

		$sql	= "UPDATE tests_results SET final_score=$final_score WHERE result_id=$rid";
		$result	= mysql_unbuffered_query($sql, $db);

		Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);
		exit;
	}
	
	$sql = "SELECT * FROM course_options WHERE name='show_correct_answers'";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
	$show_ans = $row['value'];

	require($_include_path.'header.inc.php');

	echo '<h2><a href="tools/?g=11" class="hide" >'.$_template['tools'].'</a></h2>';
	if ($_SESSION[is_admin]) {
		echo '<h3><a href="tools/tests/index.php?g=11" class="hide" >'.$_template['test_manager'].'</a></h3>';
	}
	echo '<br>';
	echo '<h3>'.$_template['results_for'].' '.$_GET['tt'].'</h3>';

	$tid = intval($_GET['tid']);
	$rid = intval($_GET['rid']);

	$mark_right = '<span style="font-family: Wingdings; color: green; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="correct answer">w </span>';
	$mark_wrong = '<span style="font-family: Wingdings; color: red; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="incorrect answer">w </span>';

	$sql	= "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
	$result	= mysql_query($sql, $db);

	$count = 1;
	echo '<form method="post" action="'.$PHP_SELF.'">';
	echo '<input type="hidden" name="tid" value="'.$tid.'">';
	echo '<input type="hidden" name="rid" value="'.$rid.'">';
	echo '<input type="hidden" name="tt" value="'.$_GET['tt2'].'">';

	if ($row = mysql_fetch_array($result)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%">';

		do {
			/* get the results for this question */
			$sql		= "SELECT DISTINCT C.question_id as q,C.* FROM tests_answers C WHERE C.result_id=$rid AND C.question_id=$row[question_id] group by question_id";
			$result_a	= mysql_query($sql, $db);
			$answer_row = mysql_fetch_array($result_a);
			//while($answer_row = mysql_fetch_array($result_a)){
			//	$this_answer[$answer_row['q']]=$answer_row['answer'];
			//}
			//debug($answer_row);
			//debug($this_answer);
			echo '<tr>';
			echo '<td valign="top">';
			echo '<b>'.$count.')</b><br />';

			$count++;

			switch ($row['type']) {
				case 1:
					/* multiple choice question */
					/* parse answer to calculate results */
					$anscvs = $answer_row['answer'];
					$ans = '';
					for ($i=0; $i<10; $i++){
						if ($row['answer_'.$i] == 1){
							$ans .= $i.',';
						}
					}
					if ($ans == $anscvs) {
						$correct = 1;
					} else {
						$correct = '';
					}
					
					//echo 'composedAnswer: '.$ans;
					print_score($correct, $row['weight'], $row['question_id'], $answer_row['score'], $open=false);
					echo '</td>';
					echo '<td>';

					echo $row['question'].'<br /><p>';
					
					for ($i=0; $i<10; $i++) $check_ans[$i] = 0;

					for ($i=0; $i<10; $i++) {
						$sub_ans = substr( $anscvs, $i *2, 1 );
						if ($sub_ans == 'A') $check_ans[10] = 1; // 'A' represents the code for "Left Blank" checkbox
						else $check_ans[$sub_ans] = 1;
					}
					if ( '0' == substr( $anscvs, 0, 1 )) {
						$check_ans[0] = 1;
					} else {
						$check_ans[0] = 0;
					}

					/* for each non-empty choice: */
					for ($i=0; ($i < 10) && ($row['choice_'.$i] != ''); $i++) {
						if ($i > 0) {
							echo '<br />';
						}
						print_result($row['choice_'.$i], $row['answer_'.$i], $i, $check_ans[$i], true, $show_ans);
					}

					echo '<br />';
					
					if ($check_ans[10] == 1) {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, 1, 1, false, $show_ans);
					} else {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false, $show_ans);
					}
					echo '</p>';
					break;

				case 2:
					/* true or false quastion */
					if($answer_row['answer']== $row['answer_0']){
						$correct=1;
					}else{
						$correct='';
					}
					//print_score($row['answer_'.$answer_row['answer']], $row['weight'], $row['question_id'], $answer_row['score']);
					print_score($correct, $row['weight'], $row['question_id'], $answer_row['score'], $put_zero = true, $open=false);
					//debug($row);
					//echo '<br>'.$row['answer_0'].'<br>';
					//echo $answer_row['answer'].'<br>';
					//echo $row['question_id'];

					echo '</td>';
					echo '<td>';

					echo $row['question'].'<br /><p>';

					//print_result('True', $row['answer_0'], 1, $answer_row['answer'],
					//			$row['answer_'.$answer_row['answer']]);
					print_result($_template['true'], $row['answer_0'], 1, $answer_row['answer'],
								false, $show_ans);

					//print_result('False', $row['answer_0'], 2, $answer_row['answer'],
					//			$row['answer_'.$answer_row['answer']]);
					print_result($_template['false'], $row['answer_0'], 2, $answer_row['answer'],
								false, $show_ans);

					echo '<br />';
					if ($answer_row['answer'] == -1) {
						print_result('<em>'.$_template['left_blank'].'</em>', -2, -1, -1, false, $show_ans);
					} else {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false, $show_ans);
					}
					// print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false);

					echo '</p>';
					break;

				case 3:
					/* long answer question */

					print_score($row['answer_'.$answer_row['answer']], $row['weight'], $row['question_id'], $answer_row['score'], false, $open=true);

					echo '</td>';
					echo '<td>';

					echo $row['question'].'<br /><p>';
					switch ($row['answer_size']) {
						case 1:
								/* one word */
								echo '<input type="text" value="'.$answer_row['answer'].'" class="formfield" size="15" />';
							break;

						case 2:
								/* sentence */
								echo '<input type="text" name value="'.$answer_row['answer'].'" class="formfield" size="45" />';
							break;

						case 3:
								/* paragraph */
								echo '<textarea cols="55" rows="5" class="formfield">'.$answer_row['answer'].'</textarea>';
							break;

						case 4:
								/* page */
								echo '<textarea cols="55" rows="25" class="formfield">'.$answer_row['answer'].'</textarea>';
							break;
					}

					echo '</p><br />';
					break;
			}
			echo '</td></tr>';
			echo '<tr><td colspan="2"><hr /></td></tr>';
		} while ($row = mysql_fetch_array($result));

		echo '<tr>';
		echo '<td align="center" colspan="2">';
		echo '<input type="submit" class="button" value="'.$_template['submit_test_results'].' Alt-s" name="submit" accesskey="s" />';
		echo '</td>';

		echo '</tr>';
		echo '</table>';
	} else {
		echo '<p>'.$_template['no_questions'].'</p>';
	}
	echo '</form>';

	require($_include_path.'footer.inc.php');
?>
