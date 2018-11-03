<?php

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests/';
	$_section[2][0] = $_template['questions'];

	require($_include_path.'header.inc.php');
	
	if($_GET['tt']){
		$_SESSION['test_name']=$_GET['tt'];
	} else if ($_POST['tt']) {
		$_SESSION['test_name']=$_POST['tt'];
	}
	if($_GET['tid']) {
		$tid = intval($_GET['tid']);
	} else if ($_POST['tid']) {
		$tid = intval($_POST['tid']);
	}
	
	
	echo '<h3>'.$_template['questions_for'].' '.$_SESSION['test_name'].'</h3>';
	$help[]=AT_HELP_ADD_QUESTIONS2;
	//$help[]=array(AT_HELP_PREVEIW_QUESTIONS, $_SESSION['test_name']);
	print_help($help);
	echo '<h4>'.$_template['add_questions'].'</h4>';
	echo '<p><a href="tools/tests/add_question_tf.php?tid='.$tid.'">'.$_template['add_tf_questions'].'</a><br />';
	echo '<a href="tools/tests/add_question_long.php?tid='.$tid.'">'.$_template['add_open_questions'].'</a><br />';
	echo '<a href="tools/tests/add_question_multi.php?tid='.$tid.'">'.$_template['add_mc_questions'].'</a></p>';
	
	echo '<br />';
	echo '<br />';

	$sql	= "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
	$result	= mysql_query($sql, $db);
	$num_qs = mysql_num_rows($result);
	if($num_qs){
		echo '<p>(<a href="tools/tests/preview.php?tid='.$tid.SEP.'tt='.$_SESSION['test_name'].'">'.$_template['preview_test'].'</a>)</p>';
	}
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="90%">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['num'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['question'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['type'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['weight'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['required'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['edit'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['delete'].'</small></th>';
	echo '</tr>';

	if ($row = mysql_fetch_array($result)) {
		do {
			$total_weight += $row['weight'];
			$count++;
			echo '<tr>';
			echo '<td class="row1" align="center"><small><b>'.$count.'</b></small></td>';
			echo '<td class="row1"><small>';
			if (strlen($row['question']) > 45) {
				echo substr($row['question'], 0, 43) . '...';
			} else {
				echo $row['question'];
			}
			echo '</small></td>';
			echo '<td class="row1"><small>';
			switch ($row['type']) {
				case 1:
					echo $_template['test_mc'];
					break;
				
				case 2:
					echo $_template['test_tf'];
					break;
			
				case 3:
					echo $_template['test_open'];
					break;
			}
				
			echo '</small></td>';
			echo '<td class="row1" align="center"><small>'.$row['weight'].'</small></td>';
			echo '<td class="row1" align="center"><small>';
			switch ($row['required']) {
				case 0:
					echo $_template['no1'];
					break;
				
				case 1:
					echo $_template['yes1'];
					break;
			}
				
			echo '</small></td>';
			echo '<td class="row1"><small>';
			
			switch ($row['type']) {
				case 1:
					echo '<a href="tools/tests/edit_question_multi.php?tid='.$tid.SEP.'qid='.$row['question_id'].'">';
					break;
				
				case 2:
					echo '<a href="tools/tests/edit_question_tf.php?tid='.$tid.SEP.'qid='.$row['question_id'].'">';
					break;
			
				case 3:
					echo '<a href="tools/tests/edit_question_long.php?tid='.$tid.SEP.'qid='.$row['question_id'].'">';
					break;
			}

			echo $_template['edit'].'</a></small></td>';
			echo '<td class="row1"><small><a href="tools/tests/delete_question.php?tid='.$tid.SEP.'qid='.$row['question_id'].'">'.$_template['delete'].'</a></small></td>';
			echo '</tr>';
			
			echo '<tr><td height="1" class="row2" colspan="7"></td></tr>';
		} while ($row = mysql_fetch_array($result));
		echo '<tr><td height="1" class="row2" colspan="7"></td></tr>';
		echo '<tr>';
		echo '<td class="row1"></td>';
		echo '<td class="row1"></td>';
		echo '<td class="row1" align="right"><small><b>'.$_template['total'].':</b></small></td>';
		echo '<td class="row1" align="center"><small>'.$total_weight.'</small></td>';
		echo '<td class="row1"></td>';
		echo '<td class="row1"></td>';
		echo '<td class="row1"></td>';
		echo '</tr>';
	} else {
		echo '<tr><td colspan="7" class="row1"><small><i>'.$_template['no_questions_avail'].'</i></small></td></tr>';
	}

	echo '</table><br />';

	require($_include_path.'footer.inc.php');
?>
