<?php

	$sql	= "SELECT * FROM feedback_form WHERE course_id=$_SESSION[course_id]  ORDER BY q_id";
	$result	= $db->query($sql); 

	$count = 1;
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<table border="0"  cellspacing="3" cellpadding="3"  width="90%"><tr><td>';

		do {
			echo '<b>'.$count.')</b> ';
			$count++;
			switch ($row['TYPE']) {
				case 1:
					/* multiple choice question */
						// init vars
					 	for ($i=0; $i < 11; $i++) {$totals[$i]=0;}
 						$left_balnk=0;
						$num_answers=0;
						// ----
						$sql="SELECT * FROM user_feedback WHERE q_id=$row[Q_ID]";
						$ansres	= $db->query($sql); 
						while ($ansrow =$ansres->fetchRow(DB_FETCHMODE_ASSOC)) {
							$num_answers++;
							if ($ansrow['ANSWER']!=-1){
								$totals[$ansrow['ANSWER']]++;
							}else {
								$left_balnk++;
							}
 						} 
					
					echo $row['QUESTION'].' - '.$num_answers.'<br /><p>';
 					$chk=explode('<~>',$row['CHECKS']);
 					
 					
 					
					echo '<table border="0" bordercolor=#C3C3C3 cellspacing="0" cellpadding="0"  width="400px">';
 					if ($num_answers==0) $num_answers=1;
					for ($i=0; $i < 11; $i++) {
						if ($chk[$i] != '') {
							

							if ($col=='#F3F3F0') $col='#F8F8FF';else $col='#F3F3F0';						
							echo '<tr bgcolor='.$col.'><td width="200px"><input type="radio" id="choice_'.$row['Q_ID'].'_'.$i.'" /><label for="choice_'.$row['Q_ID'].'_'.$i.'">'.$chk[$i].'</label></td><td width="50px">'.$totals[$i].'</td><td width="50px">'.(($totals[$i]*100)/$num_answers).'%</td>';
						}
					}

						
					
					//echo '<br />';
					//echo '<tr bgcolor=#E0E0E0><td width="300px"><input type="radio" id="choice_'.$row['Q_ID'].'_x" checked="checked" /><label for="choice_'.$row['Q_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label></td><td width="50px">'.$left_balnk.'</td><td width="50px">'.(($left_balnk*100)/$num_answers).'%</td>';
					echo '</p><table>';
					break;
				
				case 2:
					/* long answer question */
					
					echo '<a href='.$PHP_SELF.'?expand='.$row['Q_ID'].'>'.$row['QUESTION'].'</a><br /><p>';
					
					if ($_GET['expand']==$row['Q_ID']) {
						$num_answers=0;
						$sql="SELECT * FROM user_feedback WHERE q_id=$row[Q_ID]";
						$ansres	= $db->query($sql); 
						while ($ansrow =$ansres->fetchRow(DB_FETCHMODE_ASSOC)) {
							if ($ansrow['ANSWER']!=''){
								$num_answers++;
								echo "<p>".$num_answers.".".$ansrow['ANSWER']."</p>";
							}
						}
					}
					
						/* paragraph */
					//echo '<textarea cols="55" rows="5" name="question_'.$row['Q_ID'].'" class="formfield"></textarea>';
				

					echo '</p><br />';
					break;
			}
			echo '<hr />';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		echo '</td></tr>
		
		
		</table>';
	} else {
		print_feedback(AT_FEEDBACK_NO_QUESTIONS);
		//echo '<p>No questions found.</p>';
	}

	//require($_include_path.'footer.inc.php');
?>
