<?php
/****************************************************************/
/* klore														*/
/****************************************************************/

//error_reporting(E_NOTICE);

	//init
	$ans=array();
 	$count=0;
	
	$sql	= "SELECT * FROM feedback_form WHERE course_id=$_SESSION[course_id]  ORDER BY q_id";
	$result	= $db->query($sql); 

	echo '<table border="0" cellspacing="3" cellpadding="3" class="bodyline" width="90%"><tr><td>USER\QUESTION</td>';

	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		
		if (($row['QUESTION']!='')&&($row['TYPE']==1)) {
			$count++;
			echo "<td>".$row['QUESTION']."</td>";			
			$pos[$row['Q_ID']]=$count;
		}
		if ($row['CHECKS']!='') $ans[$row['Q_ID']]=explode('<~>',$row['CHECKS']);
		
		
	}
	echo "\n</tr>";

		$sql	= "SELECT * FROM user_feedback WHERE course_id=$_SESSION[course_id] ORDER BY member_id,q_id";
		$uresult	= $db->query($sql); 
		
		$tds=-1;
		echo "\n<tr>\n";
		while ($urow =$uresult->fetchRow(DB_FETCHMODE_ASSOC))	{
			
			if (($o_mid!=$urow['MEMBER_ID'])) {
				
				if ($tds!=-1) {
				
					for($i=$tds;$i<$count;$i++) echo "     \n<td>&nbsp;-</td>"; // fill the remainning gaps if any
				
					echo "\n</tr>";
				}
				$pname=$urow['MEMBER_ID'];
				//*** Extract the name
				$sql	= "SELECT * FROM members_pers WHERE member_id=$urow[MEMBER_ID]";
				$presult	= $db->query($sql); 
				if($prow=$presult->fetchRow(DB_FETCHMODE_ASSOC)) $pname=$prow['FIRST_NAME'].' '.$prow['LAST_NAME'];
				
				if (PEAR::isError($pesult)) {
					print_r($pesult);
					exit;
				}
				
				
				echo "\n<tr>     \n<td>".$pname."</td>";
				$o_mid=$urow['MEMBER_ID'];
				$tds=0;
			}
				$tds++;
				for($i=$tds;$i<$pos[$urow['Q_ID']];$i++) {
					echo "     \n<td>&nbsp;-</td>"; //fill the gap if there are missing answers
					
				}
				$tds=$i;
				echo "\n<td>".$ans[$urow['Q_ID']][$urow['ANSWER']]."</td>";
			
			
		}
		
		
				for($i=$tds;$i<$count;$i++) echo "     \n<td>&nbsp;-</td>"; // fill the remainning gaps if any
		echo "\n</tr>\n";		

			
			
	
			
echo "</table>";		
//print_r($pos);	
//print_r($ans);	

?>
