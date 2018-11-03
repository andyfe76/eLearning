<?php

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/test_result_functions.inc.php');
	require($_include_path.'lib/klore_mail.inc.php');

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
				$result	= $db->query($sql);
			}
		}

		// check existance:
		$sql	= "SELECT result_id FROM tests_results WHERE result_is=$rid";
		$res	= $db->query($sql);
		$update = false;
		$sql	= "UPDATE tests_results SET final_score=$final_score WHERE result_id=$rid";
		$result	= $db->query($sql);
		
		$sql = "SELECT min_grade,title FROM tests WHERE test_id=$tid";
		$res_mg = $db->query($sql);
		$row_mg = $res_mg->fetchRow(DB_FETCHMODE_ASSOC);
		
		$min_gr=intval($row_mg['MIN_GRADE']);//*** added
		if ($final_score >= $min_gr){
			$passed = 'yes';//retries=0 (dupa ce a fost trecut nu se mai poate da)
			$sql = "UPDATE test_process SET retries=0 WHERE member_id=$_SESSION[member_id] AND test_id=$tid";
			$res = $db->query($sql);
		}
		else {
			$passed = 'no';
		}

		
		
		$sql = "SELECT T.member_id, M.email FROM tests_results T INNER JOIN members M ON T.member_id=M.member_id WHERE result_id=$rid";
		$sql_tr = $sql;
		$res_tr = $db->query($sql);
		$row_tr = $res_tr->fetchRow(DB_FETCHMODE_ASSOC);
		
		$sql = "SELECT P.retries as ret_left, T.retries FROM test_process P INNER JOIN tests T ON P.test_id=T.test_id WHERE P.test_id=$tid AND P.member_id=$_SESSION[member_id]";
		$pres = $db->query($sql);
		$row_p =$pres->fetchRow(DB_FETCHMODE_ASSOC);
		$retries_done = $row_p['RETRIES'] - $row_p['RET_LEFT'];
		
		$sql = "SELECT COUNT(test_id) FROM tests_status WHERE member_id=$row_tr[MEMBER_ID] AND test_id=$tid AND passed='yes'";
		$res_cc = $db->query($sql);
		if (PEAR::isError($res_cc)) echo $sql.'<br>'.$sql_tr;
		$row_cc = $res_cc->fetchRow();
		if ($row_cc[0] == 0) {
			$sql = "INSERT INTO tests_status VALUES ($tid, $row_tr[MEMBER_ID], '$passed', $retries_done)";
			$res_ts = $db->query($sql);
			if (PEAR::isError($res_ts)) {
				echo 'DB Error : ';
				print_r($res_ts);
				exit;
			}
		}
		
		
		
			$sql="SELECT test_id, title FROM tests WHERE course_id=".$_SESSION['course_id'];//." AND title='Test Final'"//;
			
			$countsql = "SELECT COUNT(test_id) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$countrow = $countres->fetchRow();
			$total_tests = $countrow[0];
			
			if ($total_tests >0) {
				$res = $db->query($sql);
				$can_send_mail=false;
				while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					//echo $row[1]."<br>";//print_r($row);
					if (strtoupper($row['TITLE'])=='TEST FINAL') {
						$sql_tests_final = $row['TEST_ID'];
						//$can_send_mail=true;
					}else {
						$sql_tests[] = $row['TEST_ID'];
					}
	
				}
			} else {
				Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);
				exit;
			}
			
			if ((!$sql_tests_final)||($sql_tests_final!=$tid)) {// if no Final exam or This was not the F.E. then Exit
				Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);
				exit;
			}
			/*$sql = "SELECT COUNT(S.member_id) FROM tests_status S INNER JOIN tests T ON S.test_id=T.test_id WHERE T.course_id=$_SESSION[course_id] AND S.passed='yes'";
			$result = $db->query($sql);
			$row = $result->fetchRow();
			$passed_tests = $row[0];
			//===---
			
			//form the query
			$failed_tests = ($passed_tests==$total_tests) ? 0:1;*/
			//===---
			
			// check if final exam passed
			/*$sql = "SELECT COUNT(member_id) FROM tests_status WHERE course_id=$_SESSION[course_id] AND passed='yes' AND test_id=".$sql_tests_final." AND member_id=".$_SESSION['member_id'];
			$result = $db->query($sql);
			
			$row = $result->fetchRow();
			$passed_tests = $row[0];*/
			
			// calc average for inter. *0.4
			$sql = "SELECT TO_CHAR(enrolltime, 'DD/MM/YYYY') FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$_SESSION[course_id] ORDER BY enrolltime DESC";
			$res_sd = $db->query($sql);
			$row_sd = $res_sd->fetchRow();
			$cstart_date = $row_sd[0];

			foreach ($sql_tests as $k => $test_id) {
					// SELECT only the test results later than the enroll time
					// therefore we may have older history of test results.
					$sql = "SELECT final_score FROM tests_results WHERE member_id=$_SESSION[member_id] AND test_id=$test_id AND date_taken > TO_DATE('$cstart_date', 'DD/MM/YYYY')";
					$res = $db->query($sql);
					if (PEAR::isError($res)) echo $sql;
					$old_score = 0; // calculate max -- final_score is char[4] ==> cannot use MAX(final_score !!!)
					while ($row = $res->fetchRow()) {
						if (intval($row[0]) > $old_score) $old_score = intval($row[0]);
					}
					$total_inter_grade += $old_score;
					//echo $row[0];
				}
			if (($total_tests <= 1)) {
				$total_inter_grade = $total_inter_grade * 0.4;
			} else {
				$total_inter_grade=($total_inter_grade/($total_tests-1))*0.4;//(-Final exam)
			}
			//calc final exam *0.6
			$sql = "SELECT final_score FROM tests_results WHERE member_id=$_SESSION[member_id] AND test_id=$sql_tests_final AND date_taken > TO_DATE('$cstart_date', 'DD/MM/YYYY') ORDER BY date_taken DESC";
					//echo "<br>===>".$sql;
					$res = $db->query($sql);
					$row = $res->fetchRow();
					$old_score = 0; // CANNOT USE MAX(FINAL_SCORE) !!! -- final_score is CHAR(4)
					while ($row = $res->fetchRow()) {
						if (intval($row[0]) > $old_score) $old_score = intval($row[0]);
					}
					$total_final_grade = $old_score*0.6;
						
			
			//echo "<br>Final Exam : ".$total_final_grade;
			
			$final_score=round($total_inter_grade+$total_final_grade);
			
			//echo "<br>Final Grade : ".$final_grade;
			
			if ($final_score >= 70 )	{
				//SQL->Mark this course as passd // 
				//$sql = "DELETE FROM mcourse_completion WHERE member_id=$_SESSION[member_id] AND course_id=$_SESSION[course_id]";
				//$res = $db->query($sql); -- keep history
				//$final_grade = 0;//
				//echo "<br>".$sql;
				$sql = "SELECT min_grade FROM skills WHERE course_id=$_SESSION[course_id]";
				$res = $db->query($sql);
				$row = $res->fetchRow($res);
				$min_grade = $row[0]; // we should use instead: max_grade = sum (tests weights)
				//$final_score=$final_grade/$total_tests;
				//echo "<br>".$sql;
				// This sql should be changed and max_grade inserted instead of min_grade.
				$sql = "INSERT INTO mcourse_completion VALUES ($_SESSION[member_id], $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
				$res = $db->query($sql);
				if (PEAR::isError($res)) {
					$subject = "KLORE: error tests/view_results";
					$message = $sql;
					$fromemail = 'name@mail.com';
			    	klore_mail("admin@mail.com", $subject, $message, '<'.$fromemail.'>');
				}
				//echo "<br>".$sql;
					// ALSO: we should start counting down a timer so that the user is automatically un-enrolled after a couple of days or so
					// instead: right now we just delete enrollment here
				$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
				//echo "<br>".$sql;
				
				$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$_SESSION[member_id]";
				$result3	= $db->query($sql);
				$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
				$knume=$row3['LAST_NAME'];
				$kprenume=$row3['FIRST_NAME'];	

				
				$subject = "$knume $kprenume, Nota finala : ".$final_score.". Curs -".$_SESSION['course_title'].'.';
				$message = "<br>
					Felicitari, ai absolvit cursul de ".$_SESSION['course_title']." cu un procent de ".$final_score."
					raspunsuri corecte!
					<p>Acum esti gata sa aplici cunostintele dobandite. Poti oricand sa revii asupra
					  informatiilor din curs folosind documentatia tiparita sau salvata in format
					  .pdf.</p>
					<p>Iti multumim pentru participare si bafta la urmatoarele cursuri!</p>
					 <p>
					  <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
					  </p>
					";
				//$fromname = 'K-Lore Learning Management System';
				$fromemail = 'name@mail.com';
				
		    	klore_mail($row_tr['EMAIL'], 
						$subject, 
						$message, 
						'<'.$fromemail.'>');
						
						
			//$_SESSION['course_id']=0;

						
			} else {// Last test (probabil va fi "Test Final")
				
			$sql="SELECT retries FROM test_process WHERE test_id=$sql_tests_final AND member_id=$_SESSION[member_id]";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			//echo "<br>F.Exam =".$row[0];
			  if ($row[0]<2) {//send only if ther are no retries left 
			  
			  	//SQL->Mark this course as passd // 
				//$sql = "DELETE FROM mcourse_completion WHERE member_id=$_SESSION[member_id] AND course_id=$_SESSION[course_id]";
				//$res = $db->query($sql);
				$sql = "SELECT min_grade FROM skills WHERE course_id=$_SESSION[course_id]";
				$res = $db->query($sql);
				$row = $res->fetchRow($res);
				$min_grade = $row[0]; // we should use instead: max_grade = sum (tests weights)
				//$final_score=$final_grade/$total_tests;
				//echo "<br>".$sql;
				// This sql should be changed and max_grade inserted instead of min_grade.
				$sql = "INSERT INTO mcourse_completion VALUES ($_SESSION[member_id], $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
				$res = $db->query($sql);
				if (PEAR::isError($res)) {
					$subject = "KLORE: error tests/view_results";
					$message = $sql;
					$fromemail = 'name@mail.com';
			    	klore_mail("admin@mail.com", $subject, $message, '<'.$fromemail.'>');
				}
				
				$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
				//echo "<br>".$sql;
				
				//clear all test records
				//tests_answers
				$sql = "DELETE FROM tests_answers WHERE  member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
				//tests_results
				// KEEP RESULTS FOR HISTORY DISPLAY
				//$sql = "DELETE FROM tests_results WHERE member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
				//tests_status
				$sql = "DELETE FROM tests_status WHERE  member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
				//test_process
				$sql = "DELETE FROM test_process WHERE  member_id=$_SESSION[member_id]";
				$res = $db->query($sql);

			  	$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$_SESSION[member_id]";
					$result3	= $db->query($sql);
					$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
					$knume=$row3['LAST_NAME'];
					$kprenume=$row3['FIRST_NAME'];
					
				$message = "<p>Regretam, dar procentul de ".$final_score."% raspunsuri corecte din minimum
					de 70%, nu iti asigura promovarea cursului.</p>
					<p>Pentru detalii suplimentare, te rugam sa iei legatura cu DCM-ul tau!</p>
					 <p>
					 <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
					 </p>";
				//$fromname = 'K-Lore Learning Management System';
						
						
						$fromemail = 'name@mail.com';
						$subject = "$knume $kprenume, Nota finala : ".$final_score.'. Curs -'.$_SESSION['course_title'].'.';
						
						klore_mail($row_tr['EMAIL'], 
						$subject, 
						$message, 
						'<'.$fromemail.'>');
						
						header('location : ../../');
				}
			}
			//===---
			

			
			
		
		
		
		Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);
		exit;
	}


	$sql = "SELECT * FROM course_options WHERE name='show_correct_answers'";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$show_ans = $row['VALUE'];
	$sql = "SELECT * FROM course_options WHERE name='show_immediate_results'";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$show_results = $row[0];
	//**
	require($_include_path.'header.inc.php');

	


	if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
		echo '<h3><a href="tools/tests/index.php?g=11" class="hide" >'.$_template['test_manager'].'</a></h3>';
	}
	echo '<br>';
	echo '<h3>'.$_template['results_for'].' '.$_GET['tt'].'</h3>';

	$tid = intval($_GET['tid']);
	$rid = intval($_GET['rid']);

	//$mark_right = '<img src="images/check_ok.gif" border="0">';
	//$mark_wrong = '<img src="images/check_wrong.gif" border="0">';
	$mark_right = '<span style="font-family: Wingdings; color: green; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="correct answer">w </span>';
	$mark_wrong = '<span style="font-family: Wingdings; color: red; font-weight: bold; font-size: 8pt; vertical-align: middle;" title="incorrect answer">w </span>';

	$sql	= "SELECT * FROM tests_questions WHERE question_id IN (SELECT DISTINCT Q.question_id FROM tests_questions Q INNER JOIN tests_answers A ON Q.question_id=A.question_id, tests_results R WHERE Q.course_id=$_SESSION[course_id] AND Q.test_id=$tid AND R.result_id=A.result_id AND R.test_id=Q.test_id AND A.present='yes') ORDER BY ordering, question_id";

	$result	= $db->query($sql);
	if (PEAR::isError($result)) {
		print_r($result);
	}

	$count = 1;
	echo '<form method="post" action="'.$PHP_SELF.'">';
	echo '<input type="hidden" name="tid" value="'.$tid.'">';
	echo '<input type="hidden" name="rid" value="'.$rid.'">';
	echo '<input type="hidden" name="tt" value="'.$_GET['tt2'].'">';

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%">';

		do {
			/* get the results for this question */
			$sql = "SELECT * FROM tests_answers WHERE result_id=$rid AND question_id=$row[QUESTION_ID]";
			//$sql		= "SELECT DISTINCT C.question_id as q, C.* FROM tests_answers C WHERE C.result_id=$rid AND C.question_id=$row[QUESTION_ID] group by question_id";
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
/*

marianv76: ---
marianv76: incepand de la linia 228
					/*for ($i=0; $i<10; $i++) $check_ans[$i] = 0;

					for ($i=0; $i<10; $i++) {
						$sub_ans = substr( $anscvs, $i *2, 1 );
						if ($sub_ans == '') $check_ans[10] = 1; // 'A' represents the code for "Left Blank" checkbox
						else $check_ans[$sub_ans] = 1;
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
						$check_ans[10] = 0;
						} else {
						$check_ans[10] = 1;
						}
						
						$zero = substr( $anscvs, 0, 1 );
						if ( strcmp($zero, "0") ) {
						$check_ans[0] = 0;
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
						print_result($row['CHOICE_'.$i], $row['ANSWER_'.$i], $i, $check_ans[$i], true, $show_ans);
					}

					echo '<br />';
					
					if ($check_ans[10] == 1) {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, 1, 1, false, $show_ans);
					} else {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['ANSWER'], false, $show_ans);
					}
					echo '</p>';
					break;

				case 2:
					/* true or false quastion */
					if($answer_row['ANSWER']== $row['ANSWER_0']){
						$correct=1;
					}else{
						$correct='';
					}
					//print_score($row['ANSWER_'.$ANSWER_ROW['ANSWER']], $row['WEIGHT'], $row['QUESTION_ID'], $answer_row['score']);
					print_score($correct, $row['WEIGHT'], $row['QUESTION_ID'], $answer_row['SCORE'], $put_zero = true, $open=false);
					//debug($row);
					//echo '<br>'.$row['ANSWER_0'].'<br>';
					//echo $answer_row['answer'].'<br>';
					//echo $row['QUESTION_ID'];

					echo '</td>';
					echo '<td>';

					echo $row['QUESTION'].'<br /><p>';

					//print_result('True', $row['ANSWER_0'], 1, $answer_row['answer'],
					//			$row['ANSWER_'.$ANSWER_ROW['ANSWER']]);
					print_result($_template['true'], $row['ANSWER_0'], 1, $answer_row['ANSWER'],
								false, $show_ans);

					//print_result('False', $row['ANSWER_0'], 2, $answer_row['answer'],
					//			$row['ANSWER_'.$ANSWER_ROW['ANSWER']]);
					print_result($_template['false'], $row['ANSWER_0'], 2, $answer_row['ANSWER'],
								false, $show_ans);

					echo '<br />';
					if ($answer_row['ANSWER'] == -1) {
						print_result('<em>'.$_template['left_blank'].'</em>', -2, -1, -1, false, $show_ans);
					} else {
						print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['ANSWER'], false, $show_ans);
					}
					// print_result('<em>'.$_template['left_blank'].'</em>', -1, -2, $answer_row['answer'], false);

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

					echo '</p><br />';
					break;
			}
			echo '</td></tr>';
			echo '<tr><td colspan="2"><hr /></td></tr>';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));

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
/*
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
$check_ans[10] = 1;
} else {
$check_ans[10] = 0;
}

$zero = substr( $anscvs, 0, 1 );
if ( strcmp($zero, "0") ) {
$check_ans[0] = 1;
} else {
$check_ans[0] = 0;
}

marianv76: ---
marianv76: incepand de la linia 228
marianv76: gotta go now
marianv76: ne auzim mai pe la 5 daca mai esti acolo
*/
?>
