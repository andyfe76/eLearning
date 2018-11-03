<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */


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
	$result	= $db->query($sql); 

	$count = 1;
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%"><tr><td>';

		do {
			echo '<b>'.$count.')</b> ';
			$count++;
			switch ($row['TYPE']) {
				case 1:
					/* multiple choice question */
					echo $row['QUESTION'].'<br /><p>';
 
					for ($i=0; $i < 10; $i++) {
						if ($row['CHOICE_'.$i] != '') {
							if ($i > 0) {
								echo '<br />';
							}
						 
							echo '<input type="radio" name="question_'.$row['QUESTION_ID'].'" value="'.$i.'" id="choice_'.$row['QUESTION_ID'].'_'.$i.'" /><label for="choice_'.$row['QUESTION_ID'].'_'.$i.'">'.$row['CHOICE_'.$i].'</label>';
						}
					}

					echo '<br />';
					echo '<input type="radio" name="question_'.$row['QUESTION_ID'].'" value="-1" id="choice_'.$row['QUESTION_ID'].'_x" checked="checked" /><label for="choice_'.$row['QUESTION_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
					echo '</p>';
					break;
				
				case 2:
					/* true or false quastion */
					echo $row['QUESTION'].'<br />';

					echo '<input type="radio" name="question_'.$row['QUESTION_ID'].'" value="1" id="choice_'.$row['QUESTION_ID'].'_1" /><label for="choice_'.$row['QUESTION_ID'].'_1">'.$_template['true'].'</label>';

					echo ', ';
					echo '<input type="radio" name="question_'.$row['QUESTION_ID'].'" value="0" id="choice_'.$row['QUESTION_ID'].'_0" /><label for="choice_'.$row['QUESTION_ID'].'_0">'.$_template['false'].'</label>';

					echo '<br />';
					echo '<input type="radio" name="question_'.$row['QUESTION_ID'].'" value="-1" id="choice_'.$row['QUESTION_ID'].'_x" checked="checked" /><label for="choice_'.$row['QUESTION_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label>';

					echo '<br />';
					break;

				case 3:
					/* long answer question */
					echo $row['QUESTION'].'<br /><p>';
					switch ($row['ANSWER_SIZE']) {
						case 1:
								/* one word */
								echo '<input type="text" name="question_'.$row['QUESTION_ID'].'" class="formfield" size="15" />';
							break;

						case 2:
								/* sentence */
								echo '<input type="text" name="question_'.$row['QUESTION_ID'].'" class="formfield" size="45" />';
							break;
					
						case 3:
								/* paragraph */
								echo '<textarea cols="55" rows="5" name="question_'.$row['QUESTION_ID'].'" class="formfield"></textarea>';
							break;

						case 4:
								/* page */
								echo '<textarea cols="55" rows="25" name="question_'.$row['QUESTION_ID'].'" class="formfield"></textarea>';
							break;
					}

					echo '</p><br />';
					break;
			}
			echo '<hr />';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		echo '</td></tr></table>';
	} else {
		print_errors(AT_ERROR_NO_QUESTIONS);
		//echo '<p>No questions found.</p>';
	}

	require($_include_path.'footer.inc.php');
?>
