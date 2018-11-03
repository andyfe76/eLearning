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
	
	$sql_parse = "SELECT member_id FROM members";
	$res_parse = $db->query($sql_parse);
	
	$member_counter = 0;
	while ($row_parse = $res_parse->fetchRow(DB_FETCHMODE_ASSOC)) {
			$user_id = $row_parse['MEMBER_ID'];
			$consider = false;
			$sql = "SELECT COUNT(*) FROM course_enrollment WHERE member_id=$user_id";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			if ($row[0] >0) $consider = true;
			$sql = "SELECT COUNT(*) FROM mcourse_completion WHERE member_id=$user_id";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			if ($row[0] >0) $consider = true;
			
			if (!$consider) continue;
			$member_counter++;
			$sql="SELECT test_id, title FROM tests WHERE course_id=".$_SESSION['course_id'];//." AND title='Test Final'"//;
			$res = $db->query($sql);
			
			$countsql = "SELECT COUNT(test_id) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$countrow = $countres->fetchRow();
			$total_tests = $countrow[0];
			$sql_tests_final = '';
			$sql_tests_final = array();
			$sql_tests = '';
			$sql_tests = array();
			
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
			}


			$total_inter_grade = 0;
			$sql = "SELECT TO_CHAR(enrolltime, 'DD/MM/YYYY') FROM course_enrollment WHERE member_id=$user_id AND course_id=$_SESSION[course_id] ORDER BY enrolltime DESC";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			if ($row[0] != '') {
			} else {	
				$sql = "SELECT TO_CHAR(completion_date, 'DD/MM/YYYY') FROM mcourse_completion WHERE member_id=$user_id AND course_id=$_SESSION[course_id] ORDER BY completion_date DESC";
				$res = $db->query($sql);
				$row = $res->fetchRow();
				if ($row[0] != '') {
				} else {	
					$row[0] = "01/01/1990"; // some old date to compare; see next sql;
				}
			}
			
			$cstart_date = $row[0];
			// calc average for inter. *0.4
			foreach ($sql_tests as $k => $test_id) {
					// SELECT only the test results later than the enroll time
					// therefore we may have older history of test results.s
					$sql = "SELECT final_score FROM tests_results WHERE member_id=$user_id AND test_id=$test_id AND date_taken > TO_DATE('$cstart_date', 'DD/MM/YYYY')";
					$res = $db->query($sql);
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
			//echo "<br>Inter Tests : ".$total_inter_grade;

			//calc final exam *0.6
			
			$sql = "SELECT final_score FROM tests_results WHERE member_id=$user_id AND test_id=$sql_tests_final AND date_taken >=TO_DATE('$cstart_date', 'DD/MM/YYYY')";
			$res = $db->query($sql);
			$sql_count = "SELECT COUNT(*) FROM (".$sql.")";
			$res_count = $db->query($sql_count);
			$row_count = $res_count->fetchRow();
			if ($row_count[0] >0) {
				// ok. Calculate final score and send results
			} else {
				continue; // user did not complete all tests. Go to next user.
			}
			$old_score = 0;
			while ($row = $res->fetchRow()) {
				if (intval($row[0]) > $old_score) $old_score = intval($row[0]);
			}
			$total_final_grade = $old_score*0.6;
						
			//echo "<br>Final Exam : ".$total_final_grade;
			
			$final_score=round($total_inter_grade+$total_final_grade);
			
			echo '<br>FINAL SCORE: '.$final_score;
			
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
				$sql = "SELECT TO_CHAR(completion_date, 'DD/MM/YYYY') FROM mcourse_completion WHERE member_id=$user_id AND course_id=$_SESSION[course_id] ORDER BY completion_date DESC";
				$res = $db->query($sql);
				$row = $res->fetchRow();
				if ($row[0] >0) {
					// already completed -- just update the final_score
					$sql  = "UPDATE mcourse_completion SET completed='yes', grade=$final_score, max_grade=$min_grade WHERE member_id=$user_id AND course_id=$_SESSION[course_id] AND completion_date>=TO_DATE('$row[0]', 'DD/MM/YYYY')";
					$res = $db->query($sql);
					if (PEAR::isError($res)) {
						$subject = "Error tests/view_results";
						$message = $sql;
						$fromemail = 'name@mail.com';
						klore_mail("admin@mail.com", $subject, $message, '<'.$fromemail.'>');
					}

				} else {
					// This sql should be changed -- max_grade inserted instead of min_grade.
					$sql = "INSERT INTO mcourse_completion VALUES ($user_id, $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
					$res = $db->query($sql);
					if (PEAR::isError($res)) {
						$subject = "Error tests/view_results";
						$message = $sql;
						$fromemail = 'name@mail.com';
						klore_mail("admin@mail.com", $subject, $message, '<'.$fromemail.'>');
					}
				}
				// ALSO: we should start counting down a timer so that the user is automatically un-enrolled after a couple of days or so
				// instead: right now we just delete enrollment here
				$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$user_id";
				$res = $db->query($sql);
				//echo "<br>".$sql;
				
				$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$user_id";
				$result3	= $db->query($sql);
				$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
				$knume=$row3['LAST_NAME'];
				$kprenume=$row3['FIRST_NAME'];	

				
				$subject = "$knume $kprenume, Nota finala : ".$final_score.". Curs -".$_SESSION['course_title'].'.';
				$sql = "SELECT G.name FROM member_groups G INNER JOIN mrel_groups R ON G.group_id=R.group_id WHERE R.member_id=$user_id";
				$res_tmp = $db->query($sql);
				$row_tmp = $res_tmp->fetchRow();
				
				$message = "<br>In urma unor imbunatatiri ale platformei eLearning, va anuntam ca rezultatele testelor au fost reverificate. Daca ati mai primit odata aceasta informatie, va rugam ignorati acest email.
					<br><br>Felicitari, ai absolvit cursul de ".$_SESSION['course_title']." cu un procent de ".$final_score."
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
				
		    	// klore_mail($row_tr['EMAIL'], $subject, $message, '<'.$fromemail.'>');
				klore_mail($row_tr['EMAIL'], $subject, $message, '<'.$fromemail.'>');
				echo "Group: ".$row_tmp[0].'  :  '.$subject.' -- '.$message.'<br><br>';
						
						
			//$_SESSION['course_id']=0;

						
			} else { // $final_score < 70
				
			$sql="SELECT retries FROM test_process WHERE test_id=$sql_tests_final AND member_id=$user_id";
			if ($res = $db->query($sql)) $row = $res->fetchRow();
			else $row[] = '';
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
				$sql = "INSERT INTO mcourse_completion VALUES ($user_id, $_SESSION[course_id], 'yes', $final_score, $min_grade, SYSDATE)"; 
				$res = $db->query($sql);
				if (PEAR::isError($res)) {
					$subject = "Error tests/view_results";
					$message = $sql;
					$fromemail = 'name@mail.com';
			    	klore_mail("admin@mail.com", $subject, $message, '<'.$fromemail.'>');
				}
				
				$sql = "DELETE FROM course_enrollment WHERE course_id=$_SESSION[course_id] AND member_id=$user_id";
				$res = $db->query($sql);
				if (PEAR::isError($res)) print_r($res);
					//echo "<br>".$sql;
				
				//clear all test records
				//tests_answers
				//$sql = "DELETE FROM tests_answers WHERE  member_id=$_GET[mid]";
				//$res = $db->query($sql);
				//tests_results
				
				//$sql = "DELETE FROM tests_results WHERE member_id=$_SESSION[member_id]"; //KEEP RESULTS FOR HISTORY DISPLAY
				//$res = $db->query($sql);
				//tests_status
				//$sql = "DELETE FROM tests_status WHERE  member_id=$_GET[mid]";
				//$res = $db->query($sql);
				//test_process
				//$sql = "DELETE FROM test_process WHERE  member_id=$_GET[mid]";
				//$res = $db->query($sql);

			  	$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$user_id";
					$result3	= $db->query($sql);
					$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
					$knume=$row3['LAST_NAME'];
					$kprenume=$row3['FIRST_NAME'];
				$sql = "SELECT G.name FROM member_groups G INNER JOIN mrel_groups R ON G.group_id=R.group_id WHERE R.member_id=$user_id";
				$res_tmp = $db->query($sql);
				$row_tmp = $res_tmp->fetchRow();
				
				$message = "In urma unor imbunatatiri ale platformei eLearning, va anuntam ca rezultatele testelor au fost reverificate. Daca ati mai primit odata aceasta informatie, va rugam ignorati acest email.<br><br>
				<p>Regretam, dar procentul de ".$final_score."% raspunsuri corecte din minimum
					de 70%, nu iti asigura promovarea cursului.</p>
					<p>Pentru detalii suplimentare, te rugam sa iei legatura cu DCM-ul tau!</p>
					 <p>
					 <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
					 </p>";
				//$fromname = 'K-Lore Learning Management System';
						
						
						$fromemail = 'admin@mail.com';
						$subject = "$knume $kprenume, Nota finala : ".$final_score.'. Curs -'.$_SESSION['course_title'].'.';
						
						//klore_mail($row_tr['EMAIL'], $subject, $message, '<'.$fromemail.'>');
						klore_mail($row_tr['EMAIL'], $subject, $message, '<'.$fromemail.'>');						
						echo '<br>'.$user_id.': group: '.$row_tmp[0].' -- '.$subject.' -- '.$message.'<br><br>';
				}
			}
	}
	
	echo 'Total members: '.$member_counter;
	echo '<br>Just a test: '.intval('unmk');
	
?>