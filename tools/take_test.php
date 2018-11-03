<?php
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['take_test'];

	/* check to make sure we can access this test: */
	// TBC.
	
	/* If Multiple page test, record answers into tmp_testans
	*/
	if ($_POST['prevpage']) {
		$_POST['page']--;
	} else if ($_POST['nextpage']){
		$_POST['page']++;
	}
			
	if ($_POST['prevpage'] || $_POST['nextpage']) {
		if (is_array($_POST['answers'])){
			$sql = '';
			foreach($_POST['answers'] as $q_id	=> $ans) {
				if ($sql != '') {
					$sql .= ', ';	
				}

				if ($ans=='-4') {
					// multiple answers converted to string representation (Argint, 23.05.2003)
					$ans = '';
					if (is_array($_POST['answers_m'.$q_id])) {
 						foreach($_POST['answers_m'.$q_id] as $ans1) {
							$ans .= $ans1.',';
						}
						$ans .= $_POST['answers_mblank'];
					}
				} else if ($ans == '-5') {
					// open ended question
					$open_question = true;
					if (isset($_POST['answers_o'.$q_id])) {
						$ans = $_POST['answers_o'.$q_id];
					}
				}
				$sql .= "($q_id, $_SESSION[member_id], '$ans')";
			}
			$sql_s = "SELECT * FROM tmp_testansw WHERE question_id=$q_id AND member_id=$_SESSION[member_id]";
			$res_s = $db->query($sql_s);
			$row_s =$res_s->fetchRow(DB_FETCHMODE_ASSOC);
			if ($row_s['QUESTION_ID'] >0) {
				// UPDATE ONLY
				$sql = "UPDATE tmp_testansw SET answer='$ans' WHERE question_id=$q_id AND member_id=$_SESSION[member_id]";
				$res_u = $db->query($sql);
			} else {
				// INSERT NEW VALUES
				$sql	= 'INSERT INTO tmp_testansw VALUES '.$sql;
				$result	= $db->query($sql);
			}
		}
		/* Also get the answers for this page, if available. */
		$sql = "SELECT question_id FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND page=$_POST[page] AND test_id=$_POST[tid]";
		$res = $db->query($sql);
		$answers[] = '';
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql = "SELECT answer FROM tmp_testansw WHERE member_id=$_SESSION[member_id] AND question_id=$row[QUESTION_ID]";
			$result = $db->query($sql);
			if ($row_a =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$answers[ $row['QUESTION_ID'] ] = $row_a['ANSWER'];
			} else {
				$answers = '';
			}
		}
	}
	
	if ($_POST['submitted'] == '2') {
		$tid = intval($_POST['tid']);
		$_SESSION['test_timing'] = 0;
		
		/*
		CHECK IF TEMPORARY ANSWERS ARE SET
		*/
		$sql 	= "SELECT * FROM tmp_testansw WHERE member_id=$_SESSION[member_id]";
		$res 	= $db->query($sql);
		if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			/*	tmp_testans found. Compiling answers from temporary. */
			$result_id = $db->nextId("AUTO_TEST_RESULTS_RESULT_ID");
			$sql	= "INSERT INTO tests_results VALUES ($result_id, $tid, $_SESSION[member_id], SYSDATE, 'unmk')";
			$result	= $db->query($sql);
			
			$sql = '';
	
			$open_question = false;
			
			do {
				if ($sql != '') {
					$sql .= ', ';	
				}
				$ans = $row['ANSWER'];
				$q_id = $row['QUESTION_ID'];
				$sql .= "($result_id, $q_id, $_SESSION[member_id], '$ans', '', '', 'yes')";
			} while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC));
			$sql	= 'INSERT INTO tests_answers VALUES '.$sql;
			$result	= $db->query($sql);
			
		} else {
			/*	tmp_testans empty for this user. Compiling answers from POST. */
			$result_id = $db->nextId("AUTO_TEST_RESULTS_RID");
			$sql	= "INSERT INTO tests_results VALUES ($result_id, $tid, $_SESSION[member_id], SYSDATE, 'unmk')";
			$result	= $db->query($sql);
			
			$open_question = false;
	
			if (is_array($_POST['answers'])){
				$sql = '';
				foreach($_POST['answers'] as $q_id	=> $ans) {
					if ($sql != '') {
						$sql .= ', ';	
					}

					if ($ans=='-4') {
						// multiple answers converted to string representation (Argint, 23.05.2003)
						$ans = '';
						if (is_array($_POST['answers_m'.$q_id])) {
	 						foreach($_POST['answers_m'.$q_id] as $ans1) {
								$ans .= $ans1.',';
							}
						}
					} else if ($ans == '-5') {
						// open ended question
						$open_question = true;
						if (isset($_POST['answers_o'.$q_id])) {
							$ans = $_POST['answers_o'.$q_id];
							if (is_array($ans)) {
								$ans = $ans[$q_id];
							}
						}
					}
					$sql = "INSERT INTO tests_answers VALUES ($result_id, $q_id, $_SESSION[member_id], '$ans', '', '', 'yes')";
					$db->query($sql);
				}
				$result	= $db->query($sql);
			}
		}
		
		$sql = "UPDATE test_process SET S_TIME=0 WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
		$res = $db->query($sql);

		if (!$open_question) {
			Header('Location: ../tools/tests/view_results.php?tid='.$tid.SEP.'rid='.$result_id.SEP.'tt='.$_SESSION[login].SEP.'tt2='.$_GET['tt'].SEP.'m='.SEP.'f='.urlencode_feedback(AT_FEEDBACK_TEST_SAVED));
		} else {
			Header('Location: ../tools/my_tests.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_SAVED));
		}

		exit;
		//$feedback[]=AT_FEEDBACK_TEST_SAVED;
		//print_feedback($feedback);
		//echo '<p>Your test scores have been saved. <a href="tools/">Back to the tools page</a>.</p>';
		//require($_include_path.'footer.inc.php');
		//exit;
	}
	
	if (isset($_GET['tid'])){ 
		$tid	= intval($_GET['tid']);
	} else {
		$tid	= intval($_POST['tid']);
	}
	
	$sql = "SELECT * FROM tests WHERE test_id=$tid";
	$res = $db->query($sql);
	$row_d =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$duration = ($row_d['DURATION'] *60); // conversion to seconds
	if ($duration==0) $duration = 86400; // just a long time: 24 h
	
	$randomize_order = $row_d['RANDOMIZE_ORDER'];
	$num_questions = $row_d['NUM_QUESTIONS'];
	$min_grade = $row_d['MIN_GRADE'];
	
	$sql = "SELECT * FROM test_process WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
	$pres = $db->query($sql);
	$row_p =$pres->fetchRow(DB_FETCHMODE_ASSOC);
	/*if (($_GET['retry'] == '1') || ($_POST['retry'] == '1')) {
		if ($row_p['RETRIES'] >0){
			$_SESSION['test_timing'] = 0;
		}
	}*/
	$_SESSION['test_timing'] = intval($row_p['S_TIME']);
	if ($_SESSION['test_timing'] >0) {
		$duration = $duration - (time() - $_SESSION['test_timing']);
		if ($duration <0) {
			Header('Location: ../tools/tests/view_results.php?tid='.$tid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_TEST_TIME_EXPIRED));
			exit;
		} else {
			$reentry = true;
		}
	} else {
		//$_SESSION['test_timing'] = time(); -- already done in prepare_test. No need for this.
		if ($row_p['TEST_ID'] ==0) {
			/* it means the student is first time here */
			$retries = $row_d['RETRIES'];
			$sql = "INSERT INTO test_process VALUES ($tid, $_SESSION[member_id], $retries, $_SESSION[test_timinig])";
			$res = $db->query($sql);
		} else {
			$retries = $row_p['RETRIES'];
			if ($retries == 0) {
				Header('Location: ../tools/tests/view_results.php?tid='.$tid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE));
				exit;
			} else {
				$retries--;
				$sql = "UPDATE test_process SET retries=$retries WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
				$res = $db->query($sql);
			}
		}
	}

	require($_include_path.'header.inc.php');
	
	if (isset($_GET['tid'])) {
		$tt = $_GET['tt'];
		$tid = $_GET['tid'];
		$testpageno = $_GET['page'];
	} else if (isset($_POST['tid'])) {
		$tt = $_POST['tt'];
		$tid = $_POST['tid'];
		$testpageno = $_POST['page'];
	} else {
		$errors[] = AT_ERROR_NO_SUCH_TEST;
		print_errors($errors);
	}

	echo '<h2>'.$tt.'</h2>';

	
	echo '<table class="bodyline" width="90%">';
	echo '<tr><td align="right">';
	//if ($reentry) {
		//echo $_template['test_reentry'];
	//}
	echo $_template['time_left'].': <INPUT TYPE="text" NAME="clock" ID="clock" SIZE="5" readonly> '.$_template['minutes'].'<br>';
	echo '<input type="text" name="sec_clock" id="sec_clock" style="visibility:hidden" size="2" readonly> <br></td></tr>';
	echo '<tr><td>';
	
	if (isset($_GET['page'])) {
		$testpageno = intval($_GET['page']);
	} else if (isset($_POST['page'])) {
		$testpageno = intval($_POST['page']);		
	} else {
		$testpageno = 1;
		// INITIALIZE TEST PAGES
		$sql = "DELETE FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND test_id=$tid";
		$res = $db->query($sql);
		$sql = "DELETE FROM tmp_testansw WHERE member_id=$_SESSION[member_id]";
		$res = $db->query($sql);
		$sql = "SELECT COUNT(question_id) FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		$q_count = $row[0];
		$sql	= "SELECT question_id FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
		$result	= $db->query($sql);
		$count = 1;
		$questions[] = '';
		$i = 0;
		if ($randomize_order || ($num_questions<$q_count)) {
			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				do {
					$questions[$i] = $row['QUESTION_ID'];
					$i++;
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
				
				//*** modif
 				// resolve random arrangement of questions
				shuffle($questions);
				$sql = '';
				$pageno = 1;
				$q_page = 1;
				$counter = 0;
				$i=$num_questions;
				while ($i >0) {
					$i--;
					$q_page++;
					$counter++;
					$sql= "INSERT INTO tmp_tests VALUES ($_SESSION[member_id], $tid, $pageno, $questions[$i], $counter)";
					$res = $db->query($sql);
					if ($q_page > $num_questions) {
						$q_page = 1;
						$pageno++;
					}		

				}
					
					
			//*** end modif
			}
		} else {
			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
				$counter = 0;
				do {
					$sql = "INSERT INTO tmp_tests VALUES ($_SESSION[member_id], $tid, 1, $row[QUESTION_ID], $counter)";
					$res = $db->query($sql);
					$counter++;
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
			}
		}
	}
	
	$sql = "SELECT question_id FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND test_id=$tid AND page=$testpageno ORDER BY Q_POS";
	$res_tmp = $db->query($sql);
	
	echo '<form method="post" action="'.$PHP_SELF.'" name="form1">';
	echo '<input type="hidden" name="timp" id="timp" value="'.$duration.'">';
	?>
	<script language="JavaScript">
		var start=new Date();
		start=Date.parse(start)/1000;
		var counts=document.all.timp.value;
		function CountDown(){
			var now=new Date();
			now=Date.parse(now)/1000;
			var x=parseInt(counts-(now-start),10);
			if(document.form1){
				document.all.clock.value = parseInt(x/60 -0.001)+1;
				document.all.sec_clock.value = x;
			}
			if(x <=60){
				document.all.sec_clock.style.visibility = "visible";
			}
			if(x>0){
				timerID=setTimeout("CountDown()", 100);
			}else{
				document.all.submitted.value = "2";
				document.form1.submit();
			}
			document.all.timp.value=document.all.clock.value;
		}
		function do_submit(){
			document.all.submitted.value = "2";
		}
		window.setTimeout('CountDown()', 100);
	</script>
	<?php
	
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);

	$count0 = $countres->fetchRow();
	$num_results = $count0[0];
	
	if ($num_results >0) {
		echo '<ol>';
		while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)){
			$qid = $row_tmp['QUESTION_ID'];
			$sql = "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND question_id=$qid";
			$result = $db->query($sql);
			
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
			$num_results = $count0[0];
		
			while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
					$count++;
					$qid = $row['QUESTION_ID'];
					switch ($row['TYPE']) {
						case 1:
							/* multiple choice question */
							echo '<li>('.$row['WEIGHT'].' '.$_template['points'].')<p>'.$row['QUESTION'].'</p><p>';
							echo '<input type="hidden" name="answers['.$row['QUESTION_ID'].']" value="-4">';
							// check to see if prev/next page --> already answered question
							if ( is_array($answers) ){
								$ans = $answers[$qid];
							}
							for ($i=0; $i < 10; $i++) {
								if ($row['CHOICE_'.$i] != '') {
									if ($i > 0) {
										echo '<br />';
									}
									echo '<input type="checkbox" name="answers_m'.$qid.'['.$i.']" value="'.$i.'" id="choice_'.$qid.'_'.$i.'"';
									if ( is_array($answers) ){
										if ( strpos($ans, strval($i)) || ( $ans[0] == strval($i) )){
											echo ' checked="checked"';
										}
									}
									echo ' /><label for="choice_'.$qid.'_'.$i.'">'.$row['CHOICE_'.$i].'</label>';
								}
							}
		
							echo '<br />';
							//echo '<input type="checkbox" name="answers_m'.$row['QUESTION_ID'].'['.intval($i+1);
							//echo ']" value="A" id="choice_'.$row['QUESTION_ID'].'_x" checked="unchecked" />';
							//echo '<label for="choice_'.$row['QUESTION_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
							echo '</p></li>';
							break;
		
						case 2:
							/* true or false quastion */
							echo '<li>('.$row['WEIGHT'].' '.$_template['points'].')<p>'.$row['QUESTION'].'</p><p>';
							if (is_array($answers)) {
								$ans = $answers[$qid];
							}
		
							echo '<input type="radio" name="answers['.$row['QUESTION_ID'].']" value="1" id="choice_'.$row['QUESTION_ID'].'_0"';
							if ($ans == '1') {
								echo 'checked="checked"';
							}
							echo '/><label for="choice_'.$row['QUESTION_ID'].'_0">'.$_template['true'].'</label>';
							
							echo ', ';
							echo '<input type="radio" name="answers['.$row['QUESTION_ID'].']" value="2" id="choice_'.$row['QUESTION_ID'].'_1"';
							if ($ans == '2') {
								echo 'checked="checked"';
							}
							echo '/><label for="choice_'.$row['QUESTION_ID'].'_1">'.$_template['false'].'</label>';
							
							echo '<br />';
							//echo '<input type="radio" name="answers['.$row['QUESTION_ID'].']" value="-1" id="choice_'.$row['QUESTION_ID'].'_x" checked="checked" /><label for="choice_'.$row['QUESTION_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
		
							echo '</p><br /></li>';
							break;
		
						case 3:
							/* long answer question */
							echo '<input type="hidden" name="answers['.$answers[$row['QUESTION_ID']].']" value="-5">';
							echo '<li>('.$row['WEIGHT'].' '.$_template['points'].')<p>'.$row['QUESTION'].'</p><p>';
							switch ($row['ANSWER_SIZE']) {
								case 1:
										/* one word */
										echo '<input type="text" name="answers_o'.$qid.'['.$row['QUESTION_ID'].']" class="formfield" size="15" />';
									break;
		
								case 2:
										/* sentence */
										echo '<input type="text" name="answers_o'.$qid.'['.$row['QUESTION_ID'].']" class="formfield" size="45" />';
									break;
							
								case 3:
										/* paragraph */
										echo '<textarea cols="55" rows="5" name="answers_o'.$qid.'['.$row['QUESTION_ID'].']" class="formfield"></textarea>';
									break;
		
								case 4:
										/* page */
										echo '<textarea cols="55" rows="25" name="answers_o'.$qid.'['.$row['QUESTION_ID'].']" class="formfield"></textarea>';
									break;
							}
							echo '</p><br /></li>';
							break;
					}
					echo '<hr />';
			}
		}
		echo '</ol>';
		echo '<input type="hidden" name="tid" value="'.$tid.'">';
		echo '<input type="hidden" name="tt" value="'.$tt.'">';
		echo '<input type="hidden" name="submitted" value="1">';
		echo '<input type="hidden" name="page" value="'.$testpageno.'">';
		
		// CHECK IF MULTIPLE PAGE TEST
		if ($testpageno >1) {
			echo '<input type="submit" name="prevpage" value="'.$_template['prev_page'].' Alt-p" class="button" accesskey="p" />';
		}
		
		$testpageno++;
		$sql = "SELECT question_id FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND test_id=$tid AND page=$testpageno";
		$res_t = $db->query($sql);
		if ($row =$res_t->fetchRow(DB_FETCHMODE_ASSOC)) {
			if ($row['QUESTION_ID'] >0) {
				// new page found:
				$newpage_found = true;
				echo '<input type="submit" name="nextpage" value="'.$_template['next_page'].' Alt-n" class="button" accesskey="n" />';
			} else {
				echo '<input type="submit" name="ok" onClick="do_submit();" value="'.$_template['submit_test'].' Alt-s" class="button" accesskey="s" />';
			}
		} else {
			echo '<input type="submit" name="ok" onClick="do_submit();" value="'.$_template['submit_test'].' Alt-s" class="button" accesskey="s" />';
		}
		echo '</form><br />';
		echo '</td></tr></table>';
	} else {
		echo '<p>'.$_template['no_questions'].'</p>';
	}

	require($_include_path.'footer.inc.php');
?>
