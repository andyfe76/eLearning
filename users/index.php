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
		$result = $db->query($sql);
	} else {
		$sql	= "INSERT INTO instructor_approvals VALUES ($_SESSION[member_id], SYSDATE, '$_POST[description]')";
		$result = $db->query($sql);
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
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

	setcookie('ATLogin', $_SESSION['login'], time()+172800, $parts['path'], $parts['host'], 0);
	setcookie('ATPass',  $row['PASS'], time()+172800, $parts['path'], $parts['host'], 0);

	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_AUTO_ENABLED));
	exit;
}

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	$login  = $row['LOGIN'];

	require($_include_path.'cc_html/header.inc.php');

if ($_GET['f'] == AT_FEEDBACK_AUTO_ENABLED) {
	$warnings[] = AT_WARNING_AUTO_LOGIN;
	print_warnings($warnings);
}
print_errors($errors);
echo $auto;
?>
<?php echo $_template['control_centre'];  ?>
<?php

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	$login  = $row['LOGIN'];

	$help[] = AT_HELP_CONTROL_CENTER1;
	if ($status == 1) {
		$_SESSION['c_instructor'] = true;
		$help[] = AT_HELP_CONTROL_CENTER2;
	} else if ($status == 2) {	
		$_SESSION['is_admin'] = true;
		$help[] = AT_HELP_CONTROL_CENTER3;
	}
	if (
			(!$_SESSION['c_instructor'])
			&&(!$_SESSION['is_admin'])
			&&(!$_SESSION['is_super_admin'])
			&&(!$_SESSION['coordinator'])
			&&(!$_SESSION['group_mng'])
		){
	require($_include_path.'html/intro_stud.inc.php');
	}else {
	//echo '<div align=right><a href="../editor/edit_intro.php"><img src="../images/kedit.jpg"></a></div>';
	require($_include_path.'html/intro_stud.inc.php');	
	}
 ?>

<br />
<?php
	if ($status == 2) {
	/* admin mode */
	
	}
?>
<BR />
<?php 
	if ($status <> 2) {
?>
<div align="left">
<h2><?php echo "<font color=#0000d7 size=3><b>".$_template['enrolled_courses']."</b></font>"; ?></h2><br></div>
	

	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr><td height="1" class="row2" colspan="3"></td></tr>
	<!--tr>
		<th scope="col" width="150"><?php  //echo $_template['course_name'];  ?></th>
		<th scope="col"><?php // echo $_template['description'];  ?></th>
		<!-- <th scope="col"><?php  //echo $_template['remove'];  ?></th>
	</tr -->
<?php
	$sql	= "SELECT * FROM course_groups";
	$res_id	= $db->query($sql);
	$course_count = 0;
	if ($row_id =$res_id->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
		$group_id = $row_id['GROUP_ID'];
		
		if ($group_id >0) {
	
			$sql	= "SELECT C.*, R.* FROM course_groups C, crel_groups R WHERE C.group_id=$group_id AND R.group_id=$group_id ORDER BY C.name";
			$res	= $db->query($sql);
			$group_count = 0;
					
			if ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
				do {
				$course_id = $rowg['COURSE_ID'];
				
				$sql	= "SELECT course_id, TO_CHAR(start_date, 'DD/MM/YYYY HH24:MI:SS') AS start_date, TO_CHAR(end_date, 'DD/MM/YYYY HH24:MI:SS') AS end_date, period FROM course_availability WHERE course_id=$course_id";
				$res_1	= $db->query($sql);
				$row_av	= $res_1->fetchRow(DB_FETCHMODE_ASSOC);
			
				$sql = "SELECT * FROM mrel_courses WHERE member_id=$_SESSION[member_id] AND course_id=$course_id";
				$res_mrel = $db->query($sql);
				if (!$res_mrel) {
					$start = 0;
				} else {
					$row_mrel =$res_mrel->fetchRow(DB_FETCHMODE_ASSOC);
					$start = $row_mrel['START'];	
				}
				
				//$sql	= "SELECT E.approved, C.* FROM course_enrollment E, courses C WHERE E.member_id=$_SESSION[member_id] AND E.member_id<>C.member_id AND E.course_id=$course_id AND C.course_id=$course_id ORDER BY C.title";
				$sql	= "SELECT E.approved, C.* FROM course_enrollment E, courses C WHERE E.member_id=$_SESSION[member_id] AND E.course_id=$course_id AND C.course_id=$course_id ORDER BY C.title";
				$result = $db->query($sql);
				$countsql = "SELECT COUNT(*) FROM (".$sql.")";
				$countres = $db->query($countsql);
				$count0 = $countres->fetchRow();
				$num = $count0[0];
				$count = 1;
				if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
					do {
						if ($group_count == 0) { ?>
						</table>
						<br>
						<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
						<tr>
							<th align="left" scope="col"><font color="Blue"><?php  echo $_template['module'].': '.$row_id['NAME'];  ?></FONT></th>
							<th scope="col"><?php  echo $row_id['COMMENTS'];  ?></th>
						</tr>
						<?php 
						}
						echo '<tr><td class="row1" width="250" valign="top"><b>';
						$av = check_availability(&$row_av, $start);
						if ($av <0) {
							echo $row['TITLE'].'<br>'.'<span class="small_green">'.$_template['available_from'].': '.$row_av['START_DATE'].'</span>';
						} else if ($av == 0) {
							echo '<a href="bounce.php?course='.$row['COURSE_ID'].'">'.$row['TITLE'].'</a>';
						} else {
							echo $row['TITLE'].'<br>'.'<span class="small_red">'.$_template['course_expired'].': '.$row_av['END_DATE'].'</span>';
						}
						echo '</b></td><td class="row1" valign="top">';
						echo '<small>';
						echo $row['DESCRIPTION'];
			
						echo '</small></td>';
						// echo '<td class="row1" valign="top">';
						// echo '<a href="users/remove_course.php?course='.$row['COURSE_ID'].'">'.$_template['remove'].'</a>';
						// echo '</td>';
						echo '</tr>';
						if ($count < $num-1) {
							echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
						}
						$count++;
						$group_count++;
						$course_count++;
					} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
				}
			
				} while ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC));
			}
		}
		} while ($row_id =$res_id->fetchRow(DB_FETCHMODE_ASSOC));
	}
	if ($course_count == 0) {
		echo '<tr><td class="row1" colspan="3"><i>'.$_template['no_enrolments'].'</i></td></tr>';
	}
	
	echo '</table>';

	echo '<br />';
}

if ($_SESSION['c_instructor']){
	// this user is a teacher
	echo '<br><br>';
	// echo '<div align="left">';
	echo '<table cellspacing="0" cellpadding="0" class="bodyline" width="95%">';
	echo '<tr>';
	echo '<td width="150"><h2>'.$_template['taught_course'].'&nbsp;&nbsp;&nbsp;</td>';
	echo '<td>';
	
	//echo '<table cellspacing="0" cellpadding="0" class="framework" width="300">';
	//echo '<tr>';
	echo '<td align="right"><a href="users/cgroup.php"><img src="images/menu/new_module.gif" border="0" alt="'.$_template['new_module'].'"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="users/create_course.php"><img border="0" src="images/menu/new_course.gif" alt="'.$_template['new_course'].'"></a></h2><br>';
	//echo '</td></tr></table>';
	
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
	$result = $db->query($sql);

	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	$num = $count0[0];
	$count = 1;
	$alternate = 1;
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			echo '<tr>';
			
			echo '<td class="rowa'.$alternate.'" width="150" valign="top"><a href="bounce.php?course='.$row[COURSE_ID].'"><b>'.$row[TITLE].'</b></a></td>';
			echo '<td width="50%" class="rowa'.$alternate.'"><small>'.$row['DESCRIPTION'];

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

			echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]).' '.$pending.'<br />';
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

			echo '<td class="rowa'.$alternate.'" valign="top">';
				
				echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
				echo '<td class="row1" align="center"><small><a href="users/course_properties.php?course='.$row[COURSE_ID].'"><img src="images/menu/properties.gif" border="0" alt="'.$_template['properties'].'"></a></td>';
				echo '<td class="row1" align="center"><a href="users/enroll_admin.php?course='.$row[COURSE_ID].'"><img src="images/menu/enrollment.gif" border="0" alt="'.$_template['enrolments'].'"></a></td>';
				echo '<td class="row1" align="center"><a href="users/export.php?course='.$row[COURSE_ID].'"><img src="images/export.gif" border="0" alt="'.$_template['import_export'].'"></a></td>';
				echo '<td class="row1" align="center"><a href="users/course_email.php?course='.$row[COURSE_ID].'"><img src="images/menu/email.gif" border="0" alt="'.$_template['course_email'].'"></a></td>';
				//echo '<td class="row1" align="center"><a href="users/export_pdf.php?course='.$row[COURSE_ID].'"><img src="images/menu/ad-pdf.gif" border="0" alt="'.$_template['pdf_export'].'"></a></td>';					
				if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
					echo '<td class="row1" align="center"><a href="users/delete_course.php?course='.$row[COURSE_ID].'"><img src="images/menu/delete.gif" border="0" alt="'.$_template['delete'].'"></a></td>';
				}
				echo '</tr></table>';
			
			echo '</td></tr>';
			$alternate++;
			if ($alternate>2) $alternate = 1;

			if ($count < $num) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {

		echo '<tr><td class="row1" colspan="3"><i>'.$_template['not_teacher'].'</i></td></tr>';
	}
	echo '</table>';
?>
<?php

} else if (ALLOW_INSTRUCTOR_REQUESTS) {

	echo '<h2>'.$_template['taught_courses2'].'</h2>';

	$sql	= "SELECT * FROM instructor_approvals WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))) {
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
