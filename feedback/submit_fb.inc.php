<?php
/****************************************************************/
/* klore														*/
/****************************************************************/


echo "<br>";
$sql="SELECT COUNT(q_id) FROM user_feedback where course_id=$_SESSION[course_id] AND member_id=$_SESSION[member_id]";
$result	= $db->query($sql);
$count = $result->fetchRow();
if ($count[0]==0) {
	
	if($_POST['subfeed']) {

		$pqs=array_keys($_POST);
		$i=0;
	
		While($fq=$pqs[$i]) {
			if (substr($fq,0,2)=='q_') {		
				$sql="INSERT INTO user_feedback VALUES($_SESSION[course_id],$_SESSION[member_id],".substr($fq,2).",'{$_POST[$fq]}')";
				$result	= $db->query($sql); 		
			}	
			$i++;
		}
	$ferr=AT_FEEDBACK_FB_SENT;
	
	}
}else {
	
	
	$ferr=AT_FEEDBACK_FB_ALREADY_SENT;
}
	
	

	if ($ferr) {
	 print_feedback($ferr);
	}else {

	$sql	= "SELECT * FROM feedback_form WHERE course_id=$_SESSION[course_id]  ORDER BY q_id";
	$result	= $db->query($sql); 

	$count = 1;
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<form name="fdb" action="'.$PHP_SELF.'" method="post">
		<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%"><tr><td>';

		do {
			echo '<b>'.$count.')</b> ';
			$count++;
			switch ($row['TYPE']) {
				case 1:
					/* multiple choice question */
					echo $row['QUESTION'].'<br /><p>';
 					$chk=explode('<~>',$row['CHECKS']);
 					
					for ($i=0; $i < 11; $i++) {
						if ($chk[$i] != '') {
							if ($i > 0) {
								echo '<br />';
							}
						 
							echo '<input type="radio" name="q_'.$row['Q_ID'].'" value="'.$i.'" id="choice_'.$row['Q_ID'].'_'.$i.'" /><label for="choice_'.$row['Q_ID'].'_'.$i.'">'.$chk[$i].'</label>';
						}
					}

					echo '<br />';
					//echo '<input type="radio" name="q_'.$row['Q_ID'].'" value="-1" id="choice_'.$row['Q_ID'].'_x" /><label for="choice_'.$row['Q_ID'].'_x"><i>'.$_template['leave_blank'].'</i></label>';
					echo '</p>';
					break;
				
				case 2:
					/* long answer question */
					echo $row['QUESTION'].'<br /><p>';
					
					
						/* paragraph */
					echo '<textarea cols="55" rows="5" name="q_'.$row['Q_ID'].'" class="formfield"></textarea>';
				

					echo '</p><br />';
					break;
			}
			echo '<hr />';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		echo '</td></tr>
		<tr>
		  <td><input type="submit" name="subfeed" value="Send Feedback Alt-s" class="button" accesskey="s"></td>
		</tr>
		</form>
		</table>';
	} else {
		print_errors(AT_ERROR_NO_QUESTIONS);
		
	}
}

?>
