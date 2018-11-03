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
	$_SESSION['member_id'] = $_GET['mid'];
	$_SESSION['course_id'] = 24;
	echo 'Starting...';
	
		$tid = intval($_POST['tid']);
		$rid = intval($_POST['rid']);
		
		$final_score = 0;
		
			$sql="SELECT test_id,title FROM tests WHERE course_id=".$_SESSION['course_id'];//." AND title='Test Final'"//;

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
				//Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);
				echo 'Oops';
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
			echo '<br>'.$sql;
			$res_sd = $db->query($sql);
			$row_sd = $res_sd->fetchRow();
			$cstart_date = '11/06/2004';
			echo $cstart_date.'<br>';

			foreach ($sql_tests as $k => $test_id) {
					// SELECT only the test results later than the enroll time
					// therefore we may have older history of test results.s
					$sql = "SELECT final_score FROM tests_results WHERE member_id=$_SESSION[member_id] AND test_id=$test_id AND date_taken > TO_DATE('$cstart_date', 'DD/MM/YYYY')";
					echo '<br>'.$sql;
					$res = $db->query($sql);
					if (PEAR::isError($res)) echo $sql;
					$old_score = 0;
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
			echo "<br>Inter Tests : ".$total_inter_grade;

// manuela lazarescu: Csato Romeo, lms 1223				
// Marius Berila: Chioaru Mariana, lms1269
			//calc final exam *0.6
			$sql = "SELECT final_score FROM tests_results WHERE member_id=$_SESSION[member_id] AND test_id=$sql_tests_final AND date_taken >= TO_DATE('$cstart_date', 'DD/MM/YYYY')";
			echo "<br>===>".$sql;
					$res = $db->query($sql);
					$old_score = 0;
					while ($row = $res->fetchRow()) {
						if (intval($row[0]) > $old_score) $old_score = intval($row[0]);
					}
					$total_final_grade = $old_score*0.6;
						
			
			echo "<br>Final Exam : ".$total_final_grade;
			
			$final_score=round($total_inter_grade+$total_final_grade);
			
			echo "<br>Final Grade : ".$final_grade.'<br>';
			
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
				//$sql = "INSERT INTO mcourse_completion VALUES ($_SESSION[member_id], $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
				/*$res = $db->query($sql);
				if (PEAR::isError($res)) {
					$subject = "KLORE Connex: error tests/view_results";
					$message = $sql;
					$fromemail = 'dealer.training@connex.ro';
			    	klore_mail("marian.vasile@koncept.ro", $subject, $message, '<'.$fromemail.'>');
				}*/
				//echo "<br>".$sql;
					// ALSO: we should start counting down a timer so that the user is automatically un-enrolled after a couple of days or so
					// instead: right now we just delete enrollment here
				//$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
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
				$fromemail = 'dealer.training@connex.ro';
				echo $message;
		    	/*klore_mail($row_tr['EMAIL'], 
						$subject, 
						$message, 
						'<'.$fromemail.'>');
					*/	
						
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
				//$sql = "INSERT INTO mcourse_completion VALUES ($_SESSION[member_id], $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
				//$res = $db->query($sql);
				/*if (PEAR::isError($res)) {
					$subject = "KLORE Connex: error tests/view_results";
					$message = $sql;
					$fromemail = 'dealer.training@connex.ro';
			    	klore_mail("marian.vasile@koncept.ro", $subject, $message, '<'.$fromemail.'>');
				}*/
				
				//$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
				//echo "<br>".$sql;
				
				//clear all test records
				//tests_answers
				//$sql = "DELETE FROM tests_answers WHERE  member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
				//tests_results
				// KEEP RESULTS FOR HISTORY DISPLAY
				//$sql = "DELETE FROM tests_results WHERE member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
				//tests_status
				//$sql = "DELETE FROM tests_status WHERE  member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);
				//test_process
				//$sql = "DELETE FROM test_process WHERE  member_id=$_SESSION[member_id]";
				//$res = $db->query($sql);

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
						
						
						$fromemail = 'dealer.training@connex.ro';
						$subject = "$knume $kprenume, Nota finala : ".$final_score.'. Curs -'.$_SESSION['course_title'].'.';
						echo $message;
						/*klore_mail($row_tr['EMAIL'], 
						$subject, 
						$message, 
						'<'.$fromemail.'>');
						
						header('location : ../../');
						*/
				}
			}
			//===---
			

			
			
		
		
		
		//Header('Location: results.php?tid='.$tid.SEP.'tt='.$_POST['tt'].SEP.'f='.AT_FEEDBACK_RESULTS_UPDATED);

	?>