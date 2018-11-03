<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['test_manager'];
	$_section[1][1] = 'tools/tests/';
	$_section[2][0] = $_template['preview'];

	require($_include_path.'header.inc.php');
	echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	echo '<h3><a href="tools/tests/?g=11">'.$_template['test_manager'].'</a></h3>';
	echo '<h3>'.$_template['preview_of'].' '.$_GET['tt'].'</h3>';

	$tid	= intval($_GET['tid']);

	$sql	= "SELECT * FROM tests_questions WHERE course_id=$_SESSION[course_id] AND test_id=$tid ORDER BY ordering, question_id";
	$result	= mysql_query($sql, $db); 

	$count = 1;
	if ($row = mysql_fetch_array($result)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%"><tr><td>';

		do {
			echo '<b>'.$count.')</b> ';
			$count++;
			switch ($row['type']) {
				case 1:
					/* multiple choice question */
					echo $row['question'].'<br /><p>';
 
					for ($i=0; $i < 10; $i++) {
						if ($row['choice_'.$i] != '') {
							if ($i > 0) {
								echo '<br />';
							}
						 
							echo '<input type="radio" name="question_'.$row['question_id'].'" value="'.$i.'" id="choice_'.$row['question_id'].'_'.$i.'" /><label for="choice_'.$row['question_id'].'_'.$i.'">'.$row['choice_'.$i].'</label>';
						}
					}

					echo '<br />';
					echo '<input type="radio" name="question_'.$row['question_id'].'" value="-1" id="choice_'.$row['question_id'].'_x" checked="checked" /><label for="choice_'.$row['question_id'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
					echo '</p>';
					break;
				
				case 2:
					/* true or false quastion */
					echo $row['question'].'<br />';

					echo '<input type="radio" name="question_'.$row['question_id'].'" value="1" id="choice_'.$row['question_id'].'_1" /><label for="choice_'.$row['question_id'].'_1">'.$_template['true'].'</label>';

					echo ', ';
					echo '<input type="radio" name="question_'.$row['question_id'].'" value="0" id="choice_'.$row['question_id'].'_0" /><label for="choice_'.$row['question_id'].'_0">'.$_template['false'].'</label>';

					echo '<br />';
					echo '<input type="radio" name="question_'.$row['question_id'].'" value="-1" id="choice_'.$row['question_id'].'_x" checked="checked" /><label for="choice_'.$row['question_id'].'_x"><i>'.$_template['leave_blank'].'</i></label>';

					echo '<br />';
					break;

				case 3:
					/* long answer question */
					echo $row['question'].'<br /><p>';
					switch ($row['answer_size']) {
						case 1:
								/* one word */
								echo '<input type="text" name="question_'.$row['question_id'].'" class="formfield" size="15" />';
							break;

						case 2:
								/* sentence */
								echo '<input type="text" name="question_'.$row['question_id'].'" class="formfield" size="45" />';
							break;
					
						case 3:
								/* paragraph */
								echo '<textarea cols="55" rows="5" name="question_'.$row['question_id'].'" class="formfield"></textarea>';
							break;

						case 4:
								/* page */
								echo '<textarea cols="55" rows="25" name="question_'.$row['question_id'].'" class="formfield"></textarea>';
							break;
					}

					echo '</p><br />';
					break;
			}
			echo '<hr />';
		} while ($row = mysql_fetch_array($result));
		echo '</td></tr></table>';
	} else {
		print_errors(AT_ERROR_NO_QUESTIONS);
		//echo '<p>No questions found.</p>';
	}

	require($_include_path.'footer.inc.php');
?>
