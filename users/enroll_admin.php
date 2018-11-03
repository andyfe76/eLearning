<?php

$section = 'users';
$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');
require ($_include_path.'lib/klore_mail.inc.php');

$course = intval($_GET['course']);

if ($course == 0)
{
	$course = intval($_POST['form_course_id']);
}

if ($_POST['submit'])
{
	$_POST['form_course_id'] = intval($_POST['form_course_id']);

	if (is_array($_POST['id'])) {
		$members = '(member_id='.$_POST['id'][0].')';
		for ($i=1; $i < count($_POST['id']); $i++) {
			$members .= ' OR (member_id='.$_POST['id'][$i].')';
		}
		$sql	= "UPDATE course_enrollment SET approved='y', approvetime=SYSDATE WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = $db->query($sql);

		// notify the users that they have been approved:
		$sql	= "SELECT email, login FROM members WHERE $members";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			/* assumes that there is a first and last name for this user, but not required during registration */
			$to_email = $row['EMAIL'];

			$message  = " ($row[LOGIN]),\n\n";
			$message .= $_template['enrol_message1'].' "'.$system_courses[$_POST['form_course_id']]['title'].'" '.$_template['enrol_message2'].' '.$_base_href.' '.$_template['enrol_message3'];
			if ($to_email != '') {
				klore_mail($to_email, $_template['enrol_message4'], $message, ADMIN_EMAIL);
			}
		}
	}


	if (is_array($_POST['nid'])) {
		$members = '(member_id='.$_POST['nid'][0].')';
		for ($i=1; $i < count($_POST['nid']); $i++)
		{
			$members .= ' OR (member_id='.$_POST['nid'][$i].')';
		}
		$sql	= "UPDATE course_enrollment SET approved='n', approvetime=SYSDATE WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = $db->query($sql);
	}

	if (is_array($_POST['rid'])) {
		$members = '(member_id='.$_POST['rid'][0].')';
		for ($i=1; $i < count($_POST['rid']); $i++)
		{
			$members .= ' OR (member_id='.$_POST['rid'][$i].')';
		}
		$sql	= "DELETE FROM course_enrollment WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = $db->query($sql);
	}

	Header('Location: coursemng.php?f='.urlencode_feedback(AT_FEEDBACK_ENROLMENT_UPDATED));
	exit;
}


require($_include_path.'cc_html/header.inc.php');

/* we own this course! */
$help[]=AT_HELP_ENROLMENT;
$help[]=AT_HELP_ENROLMENT2;
?>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<input type="hidden" name="form_course_id" value="<?php echo $course; ?>" />
<h2><?php echo $_template['course_enrolment'];  ?></h2>
<p><a href="users/course_email.php?course=<?php echo $course; ?>"><?php echo $_template['send_course_email'];  ?></a></p>
<br />

<?php
	// note: doesn't list the owner of the course.
	if ($_SESSION['status']==STATUS_GROUP_MANAGER) {
		$sql	= "SELECT * FROM course_enrollment C INNER JOIN members M ON C.member_id=M.member_id WHERE C.course_id=$course AND M.member_id IN (SELECT G.member_id FROM mrel_groups G INNER JOIN group_mng K ON G.group_id=K.group_id WHERE K.member_id=".$_SESSION['member_id'].") ORDER BY C.approved, M.login";		
	} else if ($_SESSION['status']==STATUS_COORDINATOR) {
		$sql	= "SELECT * FROM course_enrollment C INNER JOIN members M ON C.member_id=M.member_id WHERE C.course_id=$course AND M.member_id IN (SELECT G.member_id FROM mrel_groups G INNER JOIN coord_groups K ON G.group_id=K.group_id WHERE K.member_id=".$_SESSION['member_id'].") ORDER BY C.approved, M.login";		
	} else {
		$sql	= "SELECT * FROM course_enrollment C INNER JOIN members M ON C.member_id=M.member_id WHERE C.course_id=$course AND M.member_id<>$_SESSION[member_id] ORDER BY C.approved, M.login";
	}
		
	$result = $db->query($sql);
	if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$infos[]=AT_INFOS_NO_ENROLLMENTS;
		print_infos($infos);
		//echo 'No users found.';
	} else {
		print_help($help);
		echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="60%" align="center">';
		echo '<tr><th>'.$_template['login_id'].'</th><th>'.$_template['enrolled_date'].'</th><th>'.$_template['remove'].'</th></tr>';

		do {
			echo '<tr><td class="row1"><tt><a href="users/edit.php?show_profile=1&mid='.$row['MEMBER_ID'].SEP.'course='.$_GET['course'].'">'.$row['LOGIN'].'</a></tt></td>';

			//enroll date
			$sql2='SELECT enrolltime FROM course_enrollment WHERE member_id='.$row['MEMBER_ID'];
			$result2 = $db->query($sql2);
			$row2 =$result2->fetchRow(DB_FETCHMODE_ASSOC);
			echo '<td class="row1">'.$row2['ENROLLTIME'].'</td>';

			
			echo '<td class="row1"><input type="checkbox" name="rid[]" value="'.$row['MEMBER_ID'].'" id="r'.$row['MEMBER_ID'].'" /><label for="r'.$row['MEMBER_ID'].'">'.$_template['remove'].'</label></td>';
			
			

			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));

		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
		echo '<tr><td align="center" colspan="5" class="row1"><br />';
		echo '<input type="submit" name="submit" class="button" value="'.$_template['done'].'" />';
		echo '</td></tr>';

		echo '</table>';
	}
?>
	
	
</form>

<?php
require($_include_path.'cc_html/footer.inc.php');
?>
