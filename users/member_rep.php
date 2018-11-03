<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

	if ($_POST['submit']) {
		$member = $_POST['member_id'];
	}

require($_include_path.'cc_html/header.inc.php');

	echo '<h1 class="center">'.$_template['member_reports'].' - '.$member.'</h1>';
	echo '<br><h2 class="center">'.$_template['member_login_name'].':</h2>'; 
	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	$status = $row['status'];

	$sql	= 'SELECT * FROM members';
	$result = mysql_query($sql,$db);
	
	echo '<form id="report" method="post" action="'.$PHP_SELF.'" name="form_report">';

	echo "\n".'&nbsp;<label for="mid"></label><span style="white-space: nowrap;"><select name="member_id" class="dropdown" id="mid" title="Report: ">'."\n";
	echo '<option value=""';
	if (!$member) echo ' selected="'.$selected.'"';
	echo '>-- '.$_template['please_select_member'].' --</option>'."\n";
	while ($row = mysql_fetch_array($result)) {
		if ( (($row['status'] ==1) && ($status>0)) || ($row['status'] ==0) ) {
			echo '<option name="'.$row['login'].'"value="'.$row['login'].'" ';
			if ($member == $row['login']) echo 'selected="selected"';
			echo '>'.$row['login'];
			echo '</option>'."\n";
		}
	}
	echo '</select>&nbsp;'."\n";
	echo '<input type="submit" name="submit" accesskey="s" value="'.$_template['show'].'" class="button2" /></span>&nbsp;';
	echo '<br>';

	echo '</form>';
	
	if (!$member) {
		require ($_include_path.'cc_html/footer.inc.php');
		exit;
	}
	// echo '<br><h2>'.$_template['report_for'].': '.$member.'<h2><br>';

echo '<br>';

	$sql	= "SELECT * FROM members WHERE login='$member'";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	
	
if (!$_GET['show_profile']) {
	echo '<h2><a href="'.$current_url.'?show_profile=1&member='.$member.'">'.$_template['profile'].'</a> - (';
	if ($row['status'] == 0) echo $_template['student'];
	else echo $_template['instructor'];
	echo ')</h2>';
} else {
	echo '<h2><a href="'.$current_url.'?show_profile=0&member='.$member.'">'.$_template['profile'].'</a> - (';
	if ($row['status'] == 0) echo $_template['student'];
	else echo $_template['instructor'];
	echo ')</h2>';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
	echo '<tr>';
	echo '<th colspan="2" align="left" class="left">';
 	echo $_template['account_information'].'</th>';
	echo '</tr>';

	echo '<tr><td width="30%" class="row1" align="right"><b>'.$_template['login_name'].':</b></td><td class="row1">'.$row['login'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class="row1" align="right"><b>'.$_template['email_address'].':</b></td><td class="row1"><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class="row1" align="right"><b>'.$_template['status'].':</td><td class="row1">';
	if ($status == 0) {
		echo $_template['student'];
	} else {
		echo $_template['instructor'];
	}
	echo '</td><tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	$sql = "SELECT * FROM user_custom_fields";
	$res = mysql_query($sql, $db);
	$i = 1;
	$mand = 0;
	$opt = 0;
	//$custom_mandatory = new array;
	//$custom_optional = new array();
	//$custom = new array();
	while ($row = mysql_fetch_array($res)) {
		$custom[$i] = $row['name'];
		if ($row['mandatory'] >0) {
			$custom_mandatory[$mand] = $i;
			$mand++;
		} else if($row['name'] <> '') {
			$custom_optional[$opt] = $i;
			$opt++;
		}
		$i++;
	}
	
	$sql = "SELECT * FROM members WHERE login='$member'";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
	for( $i=1; $i <=10; $i++ ) {
		if( $custom_mandatory[$i -1] >0 ){
			$field_name = $custom[ $custom_mandatory[$i -1] ];
			$field_value = $row[ 'custom'.$custom_mandatory[$i -1] ];
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
			$field_value = $row['custom'.$custom_optional[$i -1] ];
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
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	$status	= $row['status'];
	$email  = $row['email'];
	$mid	= $row['member_id'];
	
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
	$result = mysql_query($sql,$db);

	$num = mysql_num_rows($result);
	if ($row = mysql_fetch_array($result)) {
		do {
			echo '<tr><td class="row1" width="150" valign="top"><small><b>';
			if (($row['approved'] == 'y') || ($row['access'] != 'private')) {
				echo '<a href="bounce.php?course='.$row['course_id'].'">'.$row['title'].'</a>';
			} else {
				echo $row['title'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</small></b></td><td class="row1" valign="top">';

			echo '<small>';
			echo $row['description'];
			echo '</small></td>';

			echo '<td class="row1" width="100" valign="top" align="right"><small>'.$row[$cost_row];
			$total_cost += $row[$cost_row];
			echo '</small></td>';
			
			/*echo '<td class="row1" valign="top">';
			echo '<a href="users/remove_course.php?course='.$row['course_id'].'">'.$_template['remove'].'</a>';
			echo '</td></tr>';*/
			
			if ($count < $num-1) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row = mysql_fetch_array($result));
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
		$result = mysql_query($sql,$db);
	
		$num = mysql_num_rows($result);
		$count = 1;
		if ($row = mysql_fetch_array($result)) {
			do {
				echo '<tr>';
				
				echo '<td class="row1" width="150" valign="top"><a href="bounce.php?course='.$row[course_id].'"><b>'.$row[title].'</b></a></td>';
				echo '<td class="row1"><small>'.$row['description'];
	
				echo '<br /><br />&middot; '.$_template['access'].': ';
				$pending = '';
				switch ($row['access']){
					case 'public':
						echo $_template['public'];
						break;
					case 'protected':
						echo $_template['protected'];
						break;
					case 'private':
						echo $_template['private'];
						$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='n'";
						$c_result = mysql_query($sql, $db);
						$c_row	  = mysql_fetch_array($c_result);
						$num_rows_c = mysql_num_rows($c_result);
						if($c_row[0] > 0){
							$pending  = ', '.$c_row[0].' '.$_template['pending_approval2'].'<a href="users/enroll_admin.php?course='.$row[course_id].'"> '.$_template['pending_approval3'].'</a>';
						}
						break;
				}
				$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id]";
				$c_result = mysql_query($sql, $db);
				$c_row	  = mysql_fetch_array($c_result);
	
				/* minus 1 because the instructor doesn't count */
				echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]-1).' '.$pending.'<br />';
				echo '&middot; '.$_template['created'].': '.$row[created_date].'<br />';
	
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[course_id]";
				$c_result = mysql_query($sql, $db);
				$c_row	  = mysql_fetch_array($c_result);
	
				echo '&middot; '.$_template['logins'];
				if ($row['access'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[course_id].SEP.'a='.$row['access'].'">'.$_template['details'].'</a><br />';
	
				echo '</small></td>';
	
				echo '<td class="row1" valign="top"><small>';
				echo $row[$cost_row];
				$total_cost += $row[$cost_row];
				echo '</small></td>';
				echo '</tr>';
	
				if ($count < $num) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
			} while ($row = mysql_fetch_array($result));
		} else {
	
			echo '<tr><td class="row1" colspan="3"><i>'.$_template['not_teacher'].'</i></td></tr>';
		}
		echo '<tr><td class="row1" colspan="3" align="right"><small><b>'.$_template['total_cost'].': '.$total_cost.' EURO</small></b><td></tr>';
		echo '</table>';
	}

	/* Show test results for every course enrolled into */
	$sql	= "SELECT E.approved, C.*, R.* FROM course_enrollment E, courses C, roi R WHERE R.course_id=C.course_id AND E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result_c = mysql_query($sql,$db);

	$num = mysql_num_rows($result_c);
	if ($row_c = mysql_fetch_array($result_c)) {
		do {
			/*echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
			echo '<tr><td class="row1" width="150" valign="top"><b>';
			if (($row_c['approved'] == 'y') || ($row_c['access'] != 'private')) {
				echo '<a href="bounce.php?course='.$row_c['course_id'].'">'.$row_c['title'].'</a>';
			} else {
				echo $row_c['title'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</b></td></tr></table>';*/
			$course_id = $row_c['course_id'];

			$sql	= "SELECT T.title, T.course_id, R.*, SUM(Q.weight) AS outof FROM tests T, tests_results R, tests_questions Q WHERE Q.test_id=T.test_id AND R.member_id=$mid AND R.test_id=T.test_id AND T.course_id=$course_id GROUP BY R.result_id ORDER BY R.date_taken";
			$result	= mysql_query($sql, $db);
			$num_results = mysql_num_rows($result);

			if ($row = mysql_fetch_array($result)) {
				$this_course_id=0;
				do {
					if ($this_course_id != $row['course_id']) {
						if ($this_course_id > 0) {
							echo '</table><br />';
						}
						echo '<br><h2>'.$system_courses[$row['course_id']]['title'].'</h2>';
						echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
						echo '<tr>';
						echo '<th scope="col" width="200"><small>'.$_template['title'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
						//echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
						echo '</tr>';
		
						$this_course_id = $row['course_id'];
						$count =0;
					}
		
					if ($count > 0){
						echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
					}
		
					$count++;
					echo '<tr>';
					echo '<td class="row1"><small><b>'.$row['title'].'</b></small></td>';
					echo '<td class="row1"><small>'.$row['date_taken'].'</small></td>';
					echo '<td class="row1" align="right"><small>';
					if ($row['final_score'] == '') {
						echo '<em>'.$_template['unmarked'].'</em>';
					} else {
						echo '<strong>'.$row['final_score'].'</strong>/'.$row['outof'];
					}
					echo '</small></td>';
		
					/*echo '<td class="row1" align="center"><small>';
		
					if ($row['final_score'] != '') {
						echo '<a href="tools/view_results.php?tid='.$row['test_id'].SEP.'rid='.$row['result_id'].SEP.'tt='.$row['title'].'">'.$_template['view_results'].'</a>';
					} else {
						echo '<em>'.$_template['no_results_yet'].'</em>';
					}
		
					echo '</small></td>';*/
		
					echo '</tr>';
				} while ($row = mysql_fetch_array($result));
				echo '</table>';
			} else {
				echo '<i>'.$_template['no_results_available'].'</i>';
			}
		} while ($row_c = mysql_fetch_array($result_c));
	}
	echo '<br />';
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
