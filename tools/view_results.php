<?php
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/test_result_functions.inc.php');

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_results'];

	require($_include_path.'header.inc.php');
	echo '<a href="tools/?g=11" class="hide" ><h2>'.$_template['tools'].'</h2></a>';
	echo '<a href="tools/my_tests.php?g=11" class="hide" ><h3>'.$_template['my_tests'].'</h3></a>';
	echo '<h3>'.$_template['results_for'].' '.$_GET['tt'].'</h3>';

	$tid = intval($_GET['tid']);
	$rid = intval($_GET['rid']);

	$mark_right = '<span style="font-family: Wingdings; color: green; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="correct answer">w </span>';
	$mark_wrong = '<span style="font-family: Wingdings; color: red; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="incorrect answer">w </span>';

	$sql	= "SELECT * FROM tests_results WHERE result_id=$rid AND member_id=$_SESSION[member_id] AND final_score<>''";
	$result	= mysql_query($sql, $db); 
	if (!$row = mysql_fetch_array($result)){
		$errors[]=AT_ERROR_RESULT_NOT_FOUND;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

	$sql	= "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
	$result	= mysql_query($sql, $db); 

	$count = 1;
	echo '<form>';

	if ($row = mysql_fetch_array($result)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%" align="center">';

		do {
			/* get the results for this question */
			$sql		= "SELECT * FROM tests_answers WHERE result_id=$rid AND question_id=$row[question_id] AND member_id=$_SESSION[member_id]";
			$result_a	= mysql_query($sql, $db); 
			$answer_row = mysql_fetch_array($result_a);

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
						$check_ans[$sub_ans] = 1;
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
						print_result($row['choice_'.$i], $row['answer_'.$i], $i, $check_ans[$i], true);
					}

					echo '<br />';

					print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false);
					echo '</p>';

					$my_score=($my_score+$answer_row['score']);
					$this_total=($this_total+$row['weight']);
					break;

				case 2:
					/* true or false quastion */
					if($answer_row['answer']== $row['answer_0']){
						$correct=1;
					}else{
						$correct='';
					}
					print_score($correct, $row['weight'], $row['question_id'], $answer_row['score'], $put_zero = true, $open=false);

					echo '</td>';
					echo '<td>';

					echo $row['question'].'<br /><p>';

					print_result($_template['true'], $row['answer_0'], 1, $answer_row['answer'],
								false);

					print_result($_template['false'], $row['answer_0'], 2, $answer_row['answer'],
								false);

					echo '<br />';
					print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false);
					$my_score=($my_score+$answer_row['score']);
					$this_total=($this_total+$row['weight']);
					//echo $my_score;
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
					$my_score=($my_score+$answer_row['score']);
					$this_total=($this_total+$row['weight']);
					echo '</p><br />';
					break;
			}

			echo '<p><strong>'.$_template['feedback'].':</strong> ';
			if ($row['feedback'] == '') {
				echo '<em>'.$_template['none'].'</em>.';
			} else {
				echo nl2br($row['feedback']);
			}

			echo '</p>';
			echo '</td></tr>';
			echo '<tr><td colspan="2"><hr /></td></tr>';
		} while ($row = mysql_fetch_array($result));
		echo '<tr><td colspan="2"><strong>'.$my_score.'/'.$this_total.'</strong></td></tr>';
		echo '</table>';
	} else {
		echo '<p>'.$_template['no_questions'].'</p>';
	}
	echo '</form>';

	require($_include_path.'footer.inc.php');
?>
