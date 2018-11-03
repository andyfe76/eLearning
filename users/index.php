<?php
$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
$_SESSION['s_is_super_admin'] = false;

if($_POST['description']=='' && $_POST['form_request_instructor']){
	$errors[]=AT_ERROR_DESC_REQUIRED;
}else if ($_POST['form_request_instructor']) {
	 if (AUTO_APPROVE_INSTRUCTORS == true) {
		$sql	= "UPDATE members SET status=1 WHERE member_id=$_SESSION[member_id]";
		$result = mysql_query($sql, $db);
	} else {
		$sql	= "INSERT INTO instructor_approvals VALUES ($_SESSION[member_id], NOW(), '$_POST[description]')";
		$result = mysql_query($sql, $db);
		//email notification send to admin upon instructor request
		if (EMAIL_NOTIFY && (ADMIN_EMAIL != '')) {
			$message  = $_template['req_message1'].",\n\n";
			$message .= $_template['req_message2'].":\n".$_POST[form_from_login]."\n".$_template['req_message3'].".\n\n";
			$message .= $_template['req_message4'].": \n".$_POST[description].".\n\n";
			$message .= $_template['req_message5'].' '.$_base_href.' '.$_template['req_message6'].' '.$_base_href.' '.$_template['req_message7']."\n";
			$message .= $_template['req_message8']."\n";

			klore_mail(ADMIN_EMAIL, $_template['req_message9'], $message, $_POST['form_from_email']);
		}
	}

	Header('Location: index.php');
	exit;
}

if ($_GET['auto'] == 'disable') {

	$parts = parse_url($_base_href);

	setcookie('ATLogin', '', time()-172800, $parts['path'], $parts['host'], 0);
	setcookie('ATPass',  '', time()-172800, $parts['path'], $parts['host'], 0);
	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_AUTO_DISABLED));
	exit;
} else if ($_GET['auto'] == 'enable') {
	$parts = parse_url($_base_href);

	$sql	= "SELECT PASSWORD(password) AS pass FROM members WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);

	setcookie('ATLogin', $_SESSION['login'], time()+172800, $parts['path'], $parts['host'], 0);
	setcookie('ATPass',  $row['pass'], time()+172800, $parts['path'], $parts['host'], 0);

	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_AUTO_ENABLED));
	exit;
}

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	$status	= $row['status'];
	$email  = $row['email'];
	$login  = $row['login'];

	require($_include_path.'cc_html/header.inc.php');

if ($_GET['f'] == AT_FEEDBACK_AUTO_ENABLED) {
	$warnings[] = AT_WARNING_AUTO_LOGIN;
	print_warnings($warnings);
}
print_errors($errors);
echo $auto;
?>
<h1 class="center"><?php echo $_template['control_centre'];  ?></h1>
<?php

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	$status	= $row['status'];
	$email  = $row['email'];
	$login  = $row['login'];

	$help[] = AT_HELP_CONTROL_CENTER1;
	if ($status == 1) {
		$_SESSION['c_instructor'] = true;
		$help[] = AT_HELP_CONTROL_CENTER2;
	} else if ($status == 2) {	
		$_SESSION['is_admin'] = true;
		$help[] = AT_HELP_CONTROL_CENTER3;
	}
	print_help($help);
 ?>
<h2><?php //echo $_template['profile']; ?></h2>

	<!-- <table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr>
		<th colspan="2" align="left" class="left"><?php //print_popup_help(AT_HELP_CONTROL_PROFILE); ?>
<?php //echo $_template['account_information']; ?></th>
	</tr> -->
<?php
	/*echo '<br>';
	echo '<h2>'.$_template['auto_login1'].': ';
	if ( ($_COOKIE['ATLogin'] != '') && ($_COOKIE['ATPass'] != '') ) {
		echo $_template['auto_enable'];
	} else {
		echo $_template['auto_disable'];
	}
	echo '</h2><br>';*/
	?>
	<!-- </table> -->

<br />
<?php
	if ($status == 2) {
	/* admin mode */
	
	}
?>
<BR />
<?php 
	if ($status < 2) {
?>
<div align="left">
<h2><?php echo $_template['enrolled_courses']; ?></h2><br></div>
	

	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr><td height="1" class="row2" colspan="3"></td></tr>
	<!--tr>
		<th scope="col" width="150"><?php  //echo $_template['course_name'];  ?></th>
		<th scope="col"><?php // echo $_template['description'];  ?></th>
		<!-- <th scope="col"><?php  //echo $_template['remove'];  ?></th> 
	</tr -->
<?php
	$sql	= "SELECT * FROM course_groups";
	$res_id	= mysql_query($sql, $db);
	$course_count = 0;
	if ($row_id = mysql_fetch_array($res_id)) {
		do {
		$group_id = $row_id['group_id'];
		
		if ($group_id >0) {
	
			$sql	= "SELECT C.*, R.* FROM course_groups C, crel_groups R WHERE C.group_id=$group_id AND R.group_id=$group_id ORDER BY C.name";
			$res	= mysql_query($sql, $db);
			//$numg	= mysql_num_rows($res);
			$group_count = 0;
					
			if ($rowg = mysql_fetch_array($res)) {
				do {
				$course_id = $rowg['course_id'];
				
				$sql	= "SELECT * FROM course_availability WHERE course_id=$course_id";
				$res_1	= mysql_query($sql, $db);
				$row_av	= mysql_fetch_array($res_1);
			
				$sql = "SELECT * FROM mrel_courses WHERE member_id=$_SESSION[member_id] AND course_id=$course_id";
				$res_mrel = mysql_query($sql, $db);
				if (!$res_mrel) {
					$start = 0;
				} else {
					$row_mrel = mysql_fetch_array($res_mrel);
					$start = $row_mrel['start'];	
				}
				
				$sql	= "SELECT E.approved, C.* FROM course_enrollment E, courses C WHERE E.member_id=$_SESSION[member_id] AND E.member_id<>C.member_id AND E.course_id=$course_id AND C.course_id=$course_id ORDER BY C.title";
				$result = mysql_query($sql,$db);
				
				$num = mysql_num_rows($result);
				$count = 1;
				if ($row = mysql_fetch_array($result)) {
					do {
						if ($group_count == 0) { ?>
						</table>
						<br>
						<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
						<tr>
							<th align="left" scope="col"><font color="Blue"><?php  echo $_template['module'].': '.$row_id['name'];  ?></FONT></th>
							<th scope="col"><?php  echo $row_id['comments'];  ?></th>
						</tr>
						<?php 
						}
						echo '<tr><td class="row1" width="250" valign="top"><b>';
						$av = check_availability(&$row_av, $start);
						if ($av <0) {
							echo $row['title'].'<br>'.'<span class="small_green">'.$_template['available_from'].': '.$row_av['start_date'].'</span>';
						} else if ($av == 0) {
							echo '<a href="bounce.php?course='.$row['course_id'].'">'.$row['title'].'</a>';
						} else {
							echo $row['title'].'<br>'.'<span class="small_red">'.$_template['course_expired'].': '.$row_av['start_date'].'</span>';
						}
						echo '</b></td><td class="row1" valign="top">';
						echo '<small>';
						echo $row['description'];
			
						echo '</small></td>';
						// echo '<td class="row1" valign="top">';
						// echo '<a href="users/remove_course.php?course='.$row['course_id'].'">'.$_template['remove'].'</a>';
						// echo '</td>';
						echo '</tr>';
						if ($count < $num-1) {
							echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
						}
						$count++;
						$group_count++;
						$course_count++;
					} while ($row = mysql_fetch_array($result));
				}
			
				} while ($rowg = mysql_fetch_array($res));
			}
		}
		} while ($row_id = mysql_fetch_array($res_id));
	}
	if ($course_count == 0) {
		echo '<tr><td class="row1" colspan="3"><i>'.$_template['no_enrolments'].'</i></td></tr>';
	}
	
	echo '</table>';

	echo '<br />';
}

if ($status == 1){
	// this user is a teacher
	echo '<br><br>';
	// echo '<div align="left">';
	echo '<table cellspacing="0" cellpadding="0" class="bodyline" width="95%">';
	echo '<tr>';
	echo '<td width="150"><h2>'.$_template['taught_course'].'&nbsp;&nbsp;&nbsp;</td>';
	echo '<td>';
	
	echo '<table cellspacing="0" cellpadding="0" class="framework" width="300">';
	echo '<tr>';
	echo '<td align="center">&middot; <a href="users/cgroup.php">'.$_template['new_module'].'</a>&nbsp;&middot; <a href="users/create_course.php">'.$_template['new_course'].'</a></h2><br>';
	echo '</td></tr></table>';
	
	//echo '</div>';
	echo '</td></tr>';
	echo '</table><br>';
?>
	<table cellspacing="0" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<!-- tr>
		<th scope="col"><?php  echo $_template['course_name'];  ?></th>
		<th scope="col"><?php  echo $_template['description'];  ?></th>
		<th scope="col"><?php  echo $_template['properties'];  ?></th>
	</tr -->
<?php
	echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
	$sql	= "SELECT * FROM courses WHERE member_id=$_SESSION[member_id] ORDER BY title";
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

			echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]).' '.$pending.'<br />';
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

			echo '<td class="row1" valign="top"><small>&middot; <a href="users/course_properties.php?course='.$row[course_id].'">'.$_template['properties'].'</a><br />';

			echo '&middot; <a href="users/enroll_admin.php?course='.$row[course_id].'">'.$_template['enrolments'].'</a><br />';
			echo '&middot; <a href="users/course_email.php?course='.$row[course_id].'">'.$_template['course_email'].'</a><br />';
			echo '&middot; <a href="users/export.php?course='.$row[course_id].'">'.$_template['import_export'].'</a><br />';
			echo '<br />&middot; <a href="users/delete_course.php?course='.$row[course_id].'">'.$_template['delete'].'</a></small></td>';
			echo '</tr>';

			if ($count < $num) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row = mysql_fetch_array($result));
	} else {

		echo '<tr><td class="row1" colspan="3"><i>'.$_template['not_teacher'].'</i></td></tr>';
	}
	echo '</table>';
?>
<?php

} else if (ALLOW_INSTRUCTOR_REQUESTS) {

	echo '<h2>'.$_template['taught_courses2'].'</h2>';

	$sql	= "SELECT * FROM instructor_approvals WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	if (!($row = mysql_fetch_array($result))) {
		$infos[]=AT_INFOS_REQUEST_ACCOUNT;
		print_infos($infos);
?>


		<form action="<?php echo $PHP_SELF; ?>" method="post">
			<input type="hidden" name="form_request_instructor" value="true" />
			<input type="hidden" name="form_from_email" value="<?php echo $email; ?>" />
			<input type="hidden" name="form_from_login" value="<?php echo $login; ?>" />
			<label for="desc"><?php echo $_template['give_description']  ?></label><br />
			<textarea cols="40" rows="3" class="formfield" id="desc" name="description"></textarea><br />
			<input type="submit" name="submit" value="<?php echo $_template['request_instructor_account']; ?>" class="button" />
		</form>
<?php
	}else {
		/* already waiting for approval */
		$infos[]=AT_INFOS_ACCOUNT_PENDING;
		print_infos($infos);
	}
}

	require ($_include_path.'cc_html/footer.inc.php');
?>