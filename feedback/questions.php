<?php

	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['feedback'];
	$_section[0][1] = 'feedback/';

	require($_include_path.'header.inc.php');
	
	//$tid=$_SESSION['course_id'];
	
	echo '<h3>'.$_template['questions_for'].' '.$_template['feedback'].'</h3>';
	$help[]=AT_HELP_ADD_QUESTIONS2;
	//$help[]=array(AT_HELP_PREVEIW_QUESTIONS, $_SESSION['test_name']);
	print_help($help);
	echo '<h4>'.$_template['add_questions'].'</h4>';
	echo '<a href="feedback/add_question_long.php">'.$_template['add_open_questions'].'</a><br />';
	echo '<a href="feedback/add_question_multi.php">'.$_template['add_mc_questions'].'</a></p>';
	
	echo '<br />';
	echo '<br />';

	$sql	= "SELECT * FROM feedback_form WHERE course_id=$_SESSION[course_id]";
	$result	= $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	$num_qs = $count0[0];

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center" width="90%">';
	echo '<tr>';
	echo '<th scope="col"><small>'.$_template['num'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['question'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['type'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['edit'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['delete'].'</small></th>';
	echo '</tr>';

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			$count++;
			echo '<tr>';
			echo '<td class="row1" align="center"><small><b>'.$count.'</b></small></td>';
			echo '<td class="row1"><small>';
			if (strlen($row['QUESTION']) > 45) {
				echo substr($row['QUESTION'], 0, 43) . '...';
			} else {
				echo $row['QUESTION'];
			}
			echo '</small></td>';
			echo '<td class="row1"><small>';
			switch ($row['TYPE']) {
				case 1:
					echo $_template['test_mc'];
					break;
					
				case 2:
					echo $_template['test_open'];
					break;
			}
				
			echo '</small></td>';

			echo '<td class="row1"><small>';
			
			switch ($row['TYPE']) {
				case 1:
					echo '<a href="feedback/edit_question_multi.php?qid='.$row['Q_ID'].'">';
					break;
				
				case 2:
					echo '<a href="feedback/edit_question_long.php?qid='.$row['Q_ID'].'">';
					break;
			}

			echo $_template['edit'].'</a></small></td>';
			echo '<td class="row1"><small><a href="feedback/delete_question.php?qid='.$row['Q_ID'].'">'.$_template['delete'].'</a></small></td>';
			echo '</tr>';
			
			echo '<tr><td height="1" class="row2" colspan="7"></td></tr>';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));

	} else {
		echo '<tr><td colspan="7" class="row1"><small><i>'.$_template['no_questions_avail'].'</i></small></td></tr>';
	}

	echo '</table><br />';

	require($_include_path.'footer.inc.php');
?>
