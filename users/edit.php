<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');
	if (!$_SESSION['is_admin']) unset($mid);
	if  (!$mid) $mid = $_SESSION['member_id'];
	$sql = "SELECT login FROM members WHERE member_id=$mid";
	$res = $db->query($sql);
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$member = $row['LOGIN'];

require($_include_path.'cc_html/header.inc.php');

	echo '<h1 class="center">'.$_template['member_reports'].' - '.$member.'</h1>';
	echo '<br><h2 class="center">'.$_template['member_login_name'].':</h2>'; 
	$sql	= "SELECT status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);
	$status = $row['STATUS'];

	// echo '<br><h2>'.$_template['report_for'].': '.$member.'<h2><br>';

echo '<br>';

	$sql	= "SELECT M.*, P.name, N.* FROM members M INNER JOIN members_pers N ON M.member_id=N.member_id, policy P WHERE login='$member' AND M.status=P.id-1";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
	
	
if (!$_GET['show_profile']) {
	echo '<h2><a href="'.$current_url.'?show_profile=1&member='.$member.'">'.$_template['profile'].'</a> - (';
	echo $row['NAME'];
	echo ')</h2>';
} else {
	echo '<h2><a href="'.$current_url.'?show_profile=0&member='.$member.'">'.$_template['profile'].'</a> - (';
	echo $row['NAME'];
	echo ')</h2>';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="90%" align="center" summary="">';
	echo '<tr>';
	echo '<th colspan="2" align="left" class="left">';
 	echo $_template['account_information'].'</th>';
	echo '</tr>';

	echo '<tr><td width="30%" class="row1" align="right"><b>'.$_template['first_name'].':</b></td><td class="row1">'.$row['FIRST_NAME'].'</td></tr>';
	echo '<tr><td width="30%" class="row1" align="right"><b>'.$_template['last_name'].':</b></td><td class="row1">'.$row['LAST_NAME'].'</td></tr>';
	echo '<tr><td width="30%" class="row1" align="right"><b>'.$_template['login_name'].':</b></td><td class="row1">'.$row['LOGIN'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class="row1" align="right"><b>'.$_template['email_address'].':</b></td><td class="row1"><a href="mailto:'.$row['EMAIL'].'">'.$row['EMAIL'].'</a></td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class="row1" align="right"><b>'.$_template['role'].':</td><td class="row1">';
	echo $row['NAME'];
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td width="30%" class="row1" align="right"><a href="../change_profile.php"><b>'.$_template['password'].'.</b></a></td></tr>';
	echo '</td><tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	
	$sql = "SELECT * FROM user_custom_fields ORDER BY ID";
	$res = $db->query($sql);
	$i = 1;
	$mand = 0;
	$opt = 0;
	//$custom_mandatory = new array;
	//$custom_optional = new array();
	//$custom = new array();
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$custom[$i] = $row['NAME'];
		if ($row['MANDATORY'] >0) {
			$custom_mandatory[$mand] = $i;
			$mand++;
		} else if($row['NAME'] <> '') {
			$custom_optional[$opt] = $i;
			$opt++;
		}
		$i++;
	}
	
	$sql = "SELECT * FROM members WHERE login='$member'";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	for( $i=1; $i <=10; $i++ ) {
		if( $custom_mandatory[$i -1] >0 ){
			$field_name = $custom[ $custom_mandatory[$i -1] ];
			$field_value = $row[ 'CUSTOM'.$custom_mandatory[$i -1] ];
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$field_name.' :</b></td>';
			echo '<td class="row1" align="left">'.$field_value.'</td>';
			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		}
	}
	for( $i=1; $i <=10; $i++ ) {
		if( $custom_optional[$i -1] >0 ){
			$field_name = $custom[ $custom_optional[$i -1] ];
			$field_value = $row['CUSTOM'.$custom_optional[$i -1] ];
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$field_name.' :</b></td>';
			echo '<td class="row1" align="left">'.$field_value.'</td>';
			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		}
	}

	echo '</table>';
	
}
	
	echo '<br><b>'.$_template['courses_enrolled_in'].':</b><br>';
	
	$sql	= "SELECT * FROM members WHERE login='$member'";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	$mid	= $row['MEMBER_ID'];
	
	if ($status == 0) $cost_row = 'cost_student';
	else $cost_row = 'cost_instructor';

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
	echo '<tr>';
	echo '<th scope="col" width="200"><small>'.$_template['course_title'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['course_description'].'</small></th>';
	echo '<th scope="col" width="100"><small>'.$_template['course_cost'].'</small></th>';
	echo '</tr>';
	$total_cost = 0;
	
	$sql	= "SELECT E.approved, C.*, R.* FROM course_enrollment E, courses C, roi R WHERE R.course_id=C.course_id AND E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();

	

	$num = $count0[0];
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			echo '<tr><td class="row1" width="150" valign="top"><small><b>';
			if (($row['APPROVED'] == 'y') || ($row['ACCESSTYPE'] != 'private')) {
				echo '<a href="bounce.php?course='.$row['COURSE_ID'].'">'.$row['TITLE'].'</a>';
			} else {
				echo $row['TITLE'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</small></b></td><td class="row1" valign="top">';

			echo '<small>';
			echo $row['DESCRIPTION'];
			echo '</small></td>';

			echo '<td class="row1" width="100" valign="top" align="right"><small>'.$row[$COST_ROW];
			$total_cost += $row[$COST_ROW];
			echo '</small></td>';
			
			/*echo '<td class="row1" valign="top">';
			echo '<a href="users/remove_course.php?course='.$row['COURSE_ID'].'">'.$_template['remove'].'</a>';
			echo '</td></tr>';*/
			
			if ($count < $num-1) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {
		echo '<tr><td class="row1" colspan="3"><small><i>'.$_template['no_enrolments'].'</i></small></td></tr>';
	}
	echo '<tr><td class="row1" colspan="3" align="right"><small><b>'.$_template['total_cost'].': '.$total_cost.' EURO</small></b><td></tr>';
	echo '</table><br><br>';
	
	if ($status == 1){
		/* instructor cost - tought coursed*/
		echo '<br><b>'.$_template['taught_courses2'].':</b><br>';
		echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
		echo '<tr>';
		echo '<th scope="col" width="200"><small>'.$_template['course_title'].'</small></th>';
		echo '<th scope="col"><small>'.$_template['course_description'].'</small></th>';
		echo '<th scope="col" width="100"><small>'.$_template['instructor_cost'].'</small></th>';
		echo '</tr>';
		$total_cost = 0;
		
		$sql	= "SELECT C.*, R.* FROM courses C, roi R WHERE member_id=$mid AND C.course_id=R.course_id ORDER BY title";
		$result = $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
	
		$num = $count0[0];
		$count = 1;
		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			do {
				echo '<tr>';
				
				echo '<td class="row1" width="150" valign="top"><a href="bounce.php?course='.$row[COURSE_ID].'"><b>'.$row[TITLE].'</b></a></td>';
				echo '<td class="row1"><small>'.$row['DESCRIPTION'];
	
				echo '<br /><br />&middot; '.$_template['access'].': ';
				$pending = '';
				switch ($row['ACCESSTYPE']){
					case 'public':
						echo $_template['public'];
						break;
					case 'protected':
						echo $_template['protected'];
						break;
					case 'private':
						echo $_template['private'];
						$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID] AND approved='n'";
						$c_result = $db->query($sql);
						$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
						$countsql = "SELECT COUNT(*) FROM (".$sql.")";
						$countres = $db->query($countsql);
						$count = $countres->fetchRow();

						$num_rows_c = $count[0];
						if($c_row[0] > 0){
							$pending  = ', '.$c_row[0].' '.$_template['pending_approval2'].'<a href="users/enroll_admin.php?course='.$row[COURSE_ID].'"> '.$_template['pending_approval3'].'</a>';
						}
						break;
				}
				$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				/* minus 1 because the instructor doesn't count */
				echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]-1).' '.$pending.'<br />';
				echo '&middot; '.$_template['created'].': '.$row[CREATED_DATE].'<br />';
	
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				echo '&middot; '.$_template['logins'];
				if ($row['ACCESSTYPE'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[COURSE_ID].SEP.'a='.$row['ACCESSTYPE'].'">'.$_template['details'].'</a><br />';
	
				echo '</small></td>';
	
				echo '<td class="row1" valign="top"><small>';
				echo $row[$COST_ROW];
				$total_cost += $row[$COST_ROW];
				echo '</small></td>';
				echo '</tr>';
	
				if ($count < $num) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
			} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		} else {
	
			echo '<tr><td class="row1" colspan="3"><i>'.$_template['not_teacher'].'</i></td></tr>';
		}
		echo '<tr><td class="row1" colspan="3" align="right"><small><b>'.$_template['total_cost'].': '.$total_cost.' EURO</small></b><td></tr>';
		echo '</table>';
	}

	/* Show test results for every course enrolled into */
	echo '<b>'.$_template['test_results'].'</b><br>';
	$sql	= "SELECT E.approved, C.*, R.* FROM course_enrollment E, courses C, roi R WHERE R.course_id=C.course_id AND E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result_c = $db->query($sql);

	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count = $countres->fetchRow();

	$num = $count[0];
	if ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			/*echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
			echo '<tr><td class="row1" width="150" valign="top"><b>';
			if (($row_c['APPROVED'] == 'y') || ($row_c['ACCESSTYPE'] != 'private')) {
				echo '<a href="bounce.php?course='.$row_c['COURSE_ID'].'">'.$row_c['TITLE'].'</a>';
			} else {
				echo $row_c['TITLE'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</b></td></tr></table>';*/
			$course_id = $row_c['COURSE_ID'];

			$sql	= "SELECT T.title, T.course_id, R.* FROM tests T, tests_results R WHERE R.member_id=$mid AND R.test_id=T.test_id AND T.course_id=$course_id ORDER BY R.date_taken";
			//, SUM(Q.weight) AS outof ...  GROUP BY R.result_id 
			$result	= $db->query($sql);
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
			$num_results = $count0[0];

			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$this_course_id=0;
				do {
					$sql = "SELECT SUM(weight) AS outof FROM tests_questions WHERE test_id=$row[TEST_ID]";
					$res_sq = $db->query($sql);
					$row_sq = $res_sq->fetchRow(DB_FETCHMODE_ASSOC);
					if ($this_course_id != $row['COURSE_ID']) {
						if ($this_course_id > 0) {
							echo '</table><br />';
						}
						echo '<br><h2>'.$_template['course_title'].': '.$system_courses[$row['COURSE_ID']]['title'].'</h2>';
						echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
						echo '<tr>';
						echo '<th scope="col" width="200"><small>'.$_template['title'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
						//echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
						echo '</tr>';
		
						$this_course_id = $row['COURSE_ID'];
						$count =0;
					}
		
					if ($count > 0){
						echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
					}
		
					$count++;
					echo '<tr>';
					echo '<td class="row1"><small><b>'.$row['TITLE'].'</b></small></td>';
					echo '<td class="row1"><small>'.$row['DATE_TAKEN'].'</small></td>';
					echo '<td class="row1" align="right"><small>';
					if ($row['FINAL_SCORE'] == '') {
						echo '<em>'.$_template['unmarked'].'</em>';
					} else {
						echo '<strong>'.$row['FINAL_SCORE'].'</strong>/'.$row_sq['OUTOF'];
					}
					echo '</small></td>';
		
					/*echo '<td class="row1" align="center"><small>';
		
					if ($row['FINAL_SCORE'] != '') {
						echo '<a href="tools/view_results.php?tid='.$row['TEST_ID'].SEP.'rid='.$row['RESULT_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['view_results'].'</a>';
					} else {
						echo '<em>'.$_template['no_results_yet'].'</em>';
					}
		
					echo '</small></td>';*/
		
					echo '</tr>';
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
				echo '</table>';
			} else {
				// echo '<i>'.$_template['no_results_available'].'</i>';
			}
		} while ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC));
	}
	echo '<br />';
	
	/* Show test results for every completed course */
	echo '<b>'.$_template['test_results_for_completed_courses'].'</b><br>';
	$sql	= "SELECT C.* FROM mcourse_completion E, courses C WHERE E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result_c = $db->query($sql);

	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count = $countres->fetchRow();

	$num = $count[0];
	if ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			/*echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
			echo '<tr><td class="row1" width="150" valign="top"><b>';
			if (($row_c['APPROVED'] == 'y') || ($row_c['ACCESSTYPE'] != 'private')) {
				echo '<a href="bounce.php?course='.$row_c['COURSE_ID'].'">'.$row_c['TITLE'].'</a>';
			} else {
				echo $row_c['TITLE'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</b></td></tr></table>';*/
			$course_id = $row_c['COURSE_ID'];

			$sql	= "SELECT T.title, T.course_id, R.final_score, R.date_taken, R.test_id FROM tests T, tests_results R WHERE R.member_id=$mid AND R.test_id=T.test_id AND T.course_id=$course_id ORDER BY R.date_taken";
			//, SUM(Q.weight) AS outof ...  GROUP BY R.result_id 
			$result	= $db->query($sql);
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
			$num_results = $count0[0];

			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$this_course_id=0;
				do {
					$sql = "SELECT SUM(weight) AS outof FROM tests_questions WHERE test_id=$row[TEST_ID]";
					$res_sq = $db->query($sql);
					$row_sq = $res_sq->fetchRow(DB_FETCHMODE_ASSOC);
					if ($this_course_id != $row['COURSE_ID']) {
						if ($this_course_id > 0) {
							echo '</table><br />';
						}
						echo '<br><h2>'.$_template['course_title'].': '.$system_courses[$row['COURSE_ID']]['title'].'</h2>';
						echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
						echo '<tr>';
						echo '<th scope="col" width="200"><small>'.$_template['title'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
						//echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
						echo '</tr>';
		
						$this_course_id = $row['COURSE_ID'];
						$count =0;
					}
		
					if ($count > 0){
						echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
					}
		
					$count++;
					echo '<tr>';
					echo '<td class="row1"><small><b>'.$row['TITLE'].'</b></small></td>';
					echo '<td class="row1"><small>'.$row['DATE_TAKEN'].'</small></td>';
					echo '<td class="row1" align="right"><small>';
					if ($row['FINAL_SCORE'] == '') {
						echo '<em>'.$_template['unmarked'].'</em>';
					} else {
						echo '<strong>'.$row['FINAL_SCORE'].'</strong>/'.$row_sq['OUTOF'];
					}
					echo '</small></td>';
		
					/*echo '<td class="row1" align="center"><small>';
		
					if ($row['FINAL_SCORE'] != '') {
						echo '<a href="tools/view_results.php?tid='.$row['TEST_ID'].SEP.'rid='.$row['RESULT_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['view_results'].'</a>';
					} else {
						echo '<em>'.$_template['no_results_yet'].'</em>';
					}
		
					echo '</small></td>';*/
		
					echo '</tr>';
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
				echo '</table>';
			} else {
				// echo '<i>'.$_template['no_results_available'].'</i>';
			}
		} while ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC));
	}
	echo '<br />';
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
