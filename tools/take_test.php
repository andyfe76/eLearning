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
			$res_s = mysql_query($sql_s, $db);
			$row_s = mysql_fetch_array($res_s);
			if ($row_s['question_id'] >0) {
				// UPDATE ONLY
				$sql = "UPDATE tmp_testansw SET answer='$ans' WHERE question_id=$q_id AND member_id=$_SESSION[member_id]";
				$res_u = mysql_query($sql, $db);
			} else {
				// INSERT NEW VALUES
				$sql	= 'INSERT INTO tmp_testansw VALUES '.$sql;
				$result	= mysql_query($sql, $db);
			}
		}
		/* Also get the answers for this page, if available. */
		$sql = "SELECT question_id FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND page=$_POST[page] AND test_id=$_POST[tid]";
		$res = mysql_query($sql, $db);
		$answers[] = '';
		while ($row = mysql_fetch_array($res)){
			$sql = "SELECT answer FROM tmp_testansw WHERE member_id=$_SESSION[member_id] AND question_id=$row[question_id]";
			$result = mysql_query($sql, $db);
			if ($row_a = mysql_fetch_array($result)) {
				$answers[ $row['question_id'] ] = $row_a['answer'];
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
		$res 	= mysql_query($sql, $db);
		if ($row = mysql_fetch_array($res)) {
			/*	tmp_testans found. Compiling answers from temporary. */
			$sql	= "INSERT INTO tests_results VALUES (0, $tid, $_SESSION[member_id], NOW(), '')";
			$result	= mysql_query($sql, $db);
			
			$sql = '';
	
			$result_id = mysql_insert_id($db);
			$open_question = false;
			
			do {
				if ($sql != '') {
					$sql .= ', ';	
				}
				$ans = $row['answer'];
				$q_id = $row['question_id'];
				$sql .= "($result_id, $q_id, $_SESSION[member_id], '$ans', '', '')";
			} while ($row = mysql_fetch_array($res));
			$sql	= 'INSERT INTO tests_answers VALUES '.$sql;
			$result	= mysql_query($sql, $db);
			
		} else {
			/*	tmp_testans empty for this user. Compiling answers from POST. */
			$sql	= "INSERT INTO tests_results VALUES (0, $tid, $_SESSION[member_id], NOW(), '')";
			$result	= mysql_query($sql, $db);
	
			$result_id = mysql_insert_id($db);
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
						}
					}
					$sql .= "($result_id, $q_id, $_SESSION[member_id], '$ans', '', '')";
				}
				$sql	= 'INSERT INTO tests_answers VALUES '.$sql;
				$result	= mysql_query($sql, $db);
			}
		}

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
	$res = mysql_query($sql, $db);
	$row_d = mysql_fetch_array($res);
	$duration = ($row_d['duration'] *60); // conversion to seconds
	if ($duration==0) $duration = 86400; // just a long time: 24 h
	
	$randomize_order = $row_d['randomize_order'];
	$num_questions = $row_d['num_questions'];
	$min_grade = $row_d['min_grade'];
	
	$sql = "SELECT * FROM test_process WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
	$pres = mysql_query($sql, $db);
	$row_p = mysql_fetch_array($pres);
	if (($_GET['retry'] == '1') || ($_POST['retry'] == '1')) {
		if ($row_p['retries'] >0){
			$_SESSION['test_timing'] = 0;
		}
	}
	if ($_SESSION['test_timing'] >0) {
		$duration = $duration - (time() - $_SESSION['test_timing']);
		if ($duration <0) {
			Header('Location: ../tools/my_tests.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_TIME_EXPIRED));
			exit;
		} else {
			$reentry = true;
		}
	} else {
		$_SESSION['test_timing'] = time();
		if ($row_p['test_id'] ==0) {
			/* it means the student is first time here */
			$retries = $row_d['retries'];
			$sql = "INSERT INTO test_process VALUES ($tid, $_SESSION[member_id], $retries)";
			$res = mysql_query($sql, $db);
		} else {
			$retries = $row_p['retries'];
			if ($retries == 0) {
				Header('Location: ../tools/my_tests.php?f='.urlencode_feedback(AT_FEEDBACK_TEST_RETRIES_NOMORE));
				exit;
			} else {
				$retries--;
				$sql = "UPDATE test_process SET retries=$retries WHERE test_id=$tid AND member_id=$_SESSION[member_id]";
				$res = mysql_query($sql, $db);
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
		$res = mysql_query($sql, $db);
		$sql = "DELETE FROM tmp_testansw WHERE member_id=$_SESSION[member_id]";
		$res = mysql_query($sql, $db);
		$sql	= "SELECT question_id FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
		$result	= mysql_query($sql, $db);
		$count = 1;
		$questions[] = '';
		$i = 0;
		if ($randomize_order || (!$num_questions)) {
			if ($row = mysql_fetch_array($result)) {
				do {
					$questions[$i] = $row['question_id'];
					$i++;
				} while ($row = mysql_fetch_array($result));
				// resolve random arrangement of questions
				$q_count = $i;
				$pageno = 1;
				$q_page = 1;
				$qfill[] = '';
				while ($i >0) {
					$qno = intval(rand(1, $q_count));
					if (!in_array($qno, $qfill)) {
						$qid = $questions[$qno-1];
						$qfill[$i] = $qno;
						$i--;
						$sql = "INSERT INTO tmp_tests VALUES ($_SESSION[member_id], $tid, $pageno, $qid)";
						$res = mysql_query($sql, $db);
						$q_page++;
						if ($q_page > $num_questions) {
							$q_page = 1;
							$pageno++;
						}		
					}
				}
			}
		} else {
			if ($row = mysql_fetch_array($result)){
				do {
					$sql = "INSERT INTO tmp_tests VALUES ($_SESSION[member_id], $tid, 1, $row[question_id])";
					$res = mysql_query($sql, $db);
				} while ($row = mysql_fetch_array($result));
			}
		}
	}
	
	$sql = "SELECT question_id FROM tmp_tests WHERE member_id=$_SESSION[member_id] AND test_id=$tid AND page=$testpageno";
	$res_tmp = mysql_query($sql, $db);
	
	while ($row_tmp = mysql_fetch_array($res_tmp)){
		$qid = $row_tmp['question_id'];
		$sql = "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND question_id=$qid";
		$result = mysql_query($sql, $db);
		
		if ($row = mysql_fetch_array($result)){
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
			
			echo '<ol>';
			do {
				$count++;
				$qid = $row['question_id'];
				switch ($row['type']) {
					case 1:
						/* multiple choice question */
						echo '<li>('.$row['weight'].' '.$_template['marks'].')<p>'.$row['question'].'</p><p>';
						echo '<input type="hidden" name="answers['.$row['question_id'].']" value="-4">';
						// check to see if prev/next page --> already answered question
						if ( is_array($answers) ){
							$ans = $answers[$qid];
						}
						for ($i=0; $i < 10; $i++) {
							if ($row['choice_'.$i] != '') {
								if ($i > 0) {
									echo '<br />';
								}
								echo '<input type="checkbox" name="answers_m'.$qid.'['.$i.']" value="'.$i.'" id="choice_'.$qid.'_'.$i.'"';
								if ( is_array($answers) ){
									if ( strpos($ans, strval($i)) || ( $ans[0] == strval($i) )){
										echo ' checked="checked"';
									}
								}
								echo ' /><label for="choice_'.$qid.'_'.$i.'">'.$row['choice_'.$i].'</label>';
							}
						}
	
						echo '<br />';
						//echo '<input type="checkbox" name="answers_m'.$row['question_id'].'['.intval($i+1);
						//echo ']" value="A" id="choice_'.$row['question_id'].'_x" checked="unchecked" />';
						//echo '<label for="choice_'.$row['question_id'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
						echo '</p></li>';
						break;
	
					case 2:
						/* true or false quastion */
						echo '<li>('.$row['weight'].' '.$_template['marks'].')<p>'.$row['question'].'</p><p>';
						if (is_array($answers)) {
							$ans = $answers[$qid];
						}
	
						echo '<input type="radio" name="answers['.$row['question_id'].']" value="1" id="choice_'.$row['question_id'].'_0"';
						if ($ans == '1') {
							echo 'checked="checked"';
						}
						echo '/><label for="choice_'.$row['question_id'].'_0">'.$_template['true'].'</label>';
						
						echo ', ';
						echo '<input type="radio" name="answers['.$row['question_id'].']" value="2" id="choice_'.$row['question_id'].'_1"';
						if ($ans == '2') {
							echo 'checked="checked"';
						}
						echo '/><label for="choice_'.$row['question_id'].'_1">'.$_template['false'].'</label>';
						
						echo '<br />';
						//echo '<input type="radio" name="answers['.$row['question_id'].']" value="-1" id="choice_'.$row['question_id'].'_x" checked="checked" /><label for="choice_'.$row['question_id'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
	
						echo '</p><br /></li>';
						break;
	
					case 3:
						/* long answer question */
						echo '<input type="hidden" name="answers['.$answers[$row['question_id']].']" value="-5">';
						echo '<li>('.$row['weight'].' '.$_template['marks'].')<p>'.$row['question'].'</p><p>';
						switch ($row['answer_size']) {
							case 1:
									/* one word */
									echo '<input type="text" name="answers_o'.$qid.'['.$row['question_id'].']" class="formfield" size="15" />';
								break;
	
							case 2:
									/* sentence */
									echo '<input type="text" name="answers_o'.$qid.'['.$row['question_id'].']" class="formfield" size="45" />';
								break;
						
							case 3:
									/* paragraph */
									echo '<textarea cols="55" rows="5" name="answers_o'.$qid.'['.$row['question_id'].']" class="formfield"></textarea>';
								break;
	
							case 4:
									/* page */
									echo '<textarea cols="55" rows="25" name="answers_o'.$qid.'['.$row['question_id'].']" class="formfield"></textarea>';
								break;
						}
	
						echo '</p><br /></li>';
						break;
				}
				echo '<hr />';
			} while ($row = mysql_fetch_array($result));
	
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
			$res_tmp = mysql_query($sql, $db);
			if ($row = mysql_fetch_array($res_tmp)) {
				if ($row['question_id'] >0) {
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
	}

	require($_include_path.'footer.inc.php');
?>