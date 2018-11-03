<?php
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/test_result_functions.inc.php');

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_results'];

	require($_include_path.'header.inc.php');
	echo '<h3>'.$_template['results_for'].' '.$_GET['tt'].'</h3>';

	$tid = intval($_GET['tid']);
	$rid = intval($_GET['rid']);

	//**
	
	$sql = "SELECT * FROM course_options WHERE name='show_correct_answers'";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$show_ans = $row['VALUE'];
	$sql = "SELECT * FROM course_options WHERE name='show_immediate_results'";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$show_results = $row[0];

	//**
	//error_reporting(E_ALL);
	$mark_right = '<span style="font-family: Wingdings; color: green; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="correct answer">w </span>';
	$mark_wrong = '<span style="font-family: Wingdings; color: red; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="incorrect answer">w </span>';

	$sql	= "SELECT * FROM tests_results WHERE result_id=$rid AND member_id=$_SESSION[member_id]";
	$result	= $db->query($sql); 
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	if ($count0[0] == 0) {
		$errors[]=AT_ERROR_RESULT_NOT_FOUND;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}
	
	$row =$result->fetchRow(DB_FETCHMODE_ASSOC);

	$sql	= "SELECT * FROM tests_questions WHERE question_id IN (SELECT DISTINCT Q.question_id FROM tests_questions Q INNER JOIN tests_answers A ON Q.question_id=A.question_id, tests_results R WHERE Q.course_id=$_SESSION[course_id] AND Q.test_id=$tid AND R.result_id=A.result_id AND R.test_id=Q.test_id AND A.present='yes') ORDER BY ordering, question_id";
	
	$result	= $db->query($sql);
	if (PEAR::isError($result)) {
		print_r($result);
	}

	$count = 1;
	echo '<form>';

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%" align="center">';

		do {
			/* get the results for this question */
			$sql		= "SELECT * FROM tests_answers WHERE result_id=$rid AND question_id=$row[QUESTION_ID] AND member_id=$_SESSION[member_id]";
			$result_a	= $db->query($sql); 
			$answer_row =$result_a->fetchRow(DB_FETCHMODE_ASSOC);

			echo '<tr>';
			echo '<td valign="top">';
			echo '<b>'.$count.')</b><br />';
			
			$count++;

			switch ($row['TYPE']) {
				case 1:
					/* multiple choice question */
					/* parse answer to calculate results */
					$anscvs = $answer_row['ANSWER'];
					
					$ans = '';
					for ($i=0; $i<10; $i++){
						if ($row['ANSWER_'.$i] == 1){
							$ans .= $i.',';
						}
					}
					if ($ans == $anscvs) {
						$correct = 1;
					} else {
						$correct = '';
					}
					
					//echo 'composedAnswer: '.$ans;
					print_score($correct, $row['WEIGHT'], $row['QUESTION_ID'], $answer_row['SCORE'], $open=false);
					echo '</td>';
					echo '<td>';

					echo $row['QUESTION'].'<br /><p>';
					
					/*for ($i=0; $i<10; $i++) $check_ans[$i] = 0;

					for ($i=0; $i<10; $i++) {
						$sub_ans = substr( $anscvs, $i *2, 1 );
						$check_ans[$sub_ans] = 1;
					}
					if ( '0' == substr( $anscvs, 0, 1 )) {
						$check_ans[0] = 1;
					} else {
						$check_ans[0] = 0;
					}*/
					for ($i=0; $i<10; $i++) $check_ans[$i] = 0;

						$found_answer = false;
						for ($i=0; $i<10; $i++) {
							$sub_ans = substr( $anscvs, $i *2, 1 );
						
							if ($sub_ans == '') {
							//nothing here
							} else { 
							$check_ans[$sub_ans] = 1;
							$found_answer = true;
							}
						}
						
						if ($found_answer) {
						$check_ans[10] = 0;// de ce merge asa ???
						
						} else {
						$check_ans[10] = 1;
						}
						
						$zero = substr( $anscvs, 0, 1 );
						if ( strcmp($zero, "0") ) {
						$check_ans[0] = 0;//??
						} else {
						$check_ans[0] = 1;
						}
						
					 
					 //if ($check_ans[10] == 1) $check_ans[0] = 0;
					 
					 //echo "<br>'".$anscvs."'<br>";
					 //print_r($check_ans);
					/* for each non-empty choice: */
					for ($i=0; ($i < 10) && ($row['CHOICE_'.$i] != ''); $i++) {
						if ($i > 0) {
							echo '<br />';
						}
						print_result($row['CHOICE_'.$i], $row['ANSWER_'.$i], $i, $check_ans[$i], true,$show_ans);
					}

					echo '<br />';
					
					if ($check_ans[10] == 1) {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, 1, 1, false, $show_ans);
					} else {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['ANSWER'], false, $show_ans);
					}					echo '</p>';

					$my_score=($my_score+$answer_row['SCORE']);
					$this_total=($this_total+$row['WEIGHT']);
					break;

				case 2:
					/* true or false quastion */
					if($answer_row['answer']== $row['ANSWER_0']){
						$correct=1;
					}else{
						$correct='';
					}
					print_score($correct, $row['WEIGHT'], $row['QUESTION_ID'], $answer_row['SCORE'], $put_zero = true, $open=false);

					echo '</td>';
					echo '<td>';

					echo $row['QUESTION'].'<br /><p>';

					print_result($_template['true'], $row['ANSWER_0'], 1, $answer_row['ANSWER'],
								false,$show_ans);

					print_result($_template['false'], $row['ANSWER_0'], 2, $answer_row['ANSWER'],
								false,$show_ans);

					echo '<br />';
					print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['ANSWER'], false);
					$my_score=($my_score+$answer_row['SCORE']);
					$this_total=($this_total+$row['WEIGHT']);
					//echo $my_score;
					echo '</p>';
					break;
 
				case 3:
					/* long answer question */

					print_score($row['ANSWER_'.$ANSWER_ROW['ANSWER']], $row['WEIGHT'], $row['QUESTION_ID'], $answer_row['SCORE'], false, $open=true);

					echo '</td>';
					echo '<td>';

					echo $row['QUESTION'].'<br /><p>';
					switch ($row['ANSWER_SIZE']) {
						case 1:
								/* one word */
								echo '<input type="text" value="'.$answer_row['ANSWER'].'" class="formfield" size="15" />';
							break;

						case 2:
								/* sentence */
								echo '<input type="text" name value="'.$answer_row['ANSWER'].'" class="formfield" size="45" />';
							break;
					 
						case 3:
								/* paragraph */
								echo '<textarea cols="55" rows="5" class="formfield">'.$answer_row['ANSWER'].'</textarea>';
							break;

						case 4:
								/* page */
								echo '<textarea cols="55" rows="25" class="formfield">'.$answer_row['ANSWER'].'</textarea>';
							break;
					}
					$my_score=($my_score+$answer_row['SCORE']);
					$this_total=($this_total+$row['WEIGHT']);
					echo '</p><br />';
					break;
			}

			echo '<p><strong>'.$_template['feedback'].':</strong> ';
			if ($row['FEEDBACK'] == '') {
				echo '<em>'.$_template['none'].'</em>.';
			} else {
				echo nl2br($row['FEEDBACK']);
			}

			echo '</p>';
			echo '</td></tr>';
			echo '<tr><td colspan="2"><hr /></td></tr>';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		echo '<tr><td colspan="2"><strong>'.$_template['final_score'].': '.$my_score.'/'.$this_total.'</strong></td></tr>';
		echo '</table>';
	} else {
		echo '<p>'.$_template['no_questions'].'</p>';
	}
	echo '</form>';

	require($_include_path.'footer.inc.php');
?>
