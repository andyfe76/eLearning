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

/* make sure we own this course that we're approving for! */
$sql	= "SELECT * FROM courses WHERE course_id=$course AND member_id=$_SESSION[member_id]";
$result	= mysql_query($sql, $db);
if (mysql_num_rows($result) != 1) {
	echo $_template['not_your_course'];
	exit;
}

if ($_POST['submit'])
{
	$_POST['form_course_id'] = intval($_POST['form_course_id']);

	if (is_array($_POST['id'])) {
		$members = '(member_id='.$_POST['id'][0].')';
		for ($i=1; $i < count($_POST['id']); $i++) {
			$members .= ' OR (member_id='.$_POST['id'][$i].')';
		}
		$sql	= "UPDATE course_enrollment SET approved='y', approvetime=NOW() WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = mysql_query($sql, $db);

		// notify the users that they have been approved:
		$sql	= "SELECT email, login FROM members WHERE $members";
		$result = mysql_query($sql, $db);
		while ($row = mysql_fetch_array($result)) {
			/* assumes that there is a first and last name for this user, but not required during registration */
			$to_email = $row['email'];

			$message  = " ($row[login]),\n\n";
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
		$sql	= "UPDATE course_enrollment SET approved='n', approvetime=NOW() WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = mysql_query($sql, $db);
	}

	if (is_array($_POST['rid'])) {
		$members = '(member_id='.$_POST['rid'][0].')';
		for ($i=1; $i < count($_POST['rid']); $i++)
		{
			$members .= ' OR (member_id='.$_POST['rid'][$i].')';
		}
		$sql	= "DELETE FROM course_enrollment WHERE course_id=$_POST[form_course_id] AND ($members)";
		$result = mysql_query($sql, $db);
	}

	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_ENROLMENT_UPDATED));
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
	$sql	= "SELECT * FROM course_enrollment C, members M WHERE C.course_id=$course AND C.member_id=M.member_id AND M.member_id<>$_SESSION[member_id] ORDER BY C.approved, M.login";
	$result = mysql_query($sql);
	if (!($row = mysql_fetch_array($result))) {
		$infos[]=AT_INFOS_NO_ENROLLMENTS;
		print_infos($infos);
		//echo 'No users found.';
	} else {
		print_help($help);
		echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
		echo '<tr><th>'.$_template['login_id'].'</th><th>'.$_template['enrolment'].'</th><th>'.$_template['approve'].'</th><th>'.$_template['disapprove'].'</th><th>'.$_template['remove'].'</th></tr>';

		do {
			echo '<tr><td class="row1"><tt><a href="users/view_profile.php?mid='.$row['member_id'].SEP.'course='.$_GET['course'].'">'.$row['login'].' ('.$row['member_id'].')</a></tt></td><td class="row1"><tt>';
			echo $row['approved'];
			echo '</tt></td><td class="row1">';

			if ($row['approved'] == 'n') {
				echo ' <input type="checkbox" name="id[]" value="'.$row[member_id].'" id="y'.$row[member_id].'" />';
				echo '<label for="y'.$row[member_id].'">'.$_template['approve'].'</label>';
			}

			echo '&nbsp;</td><td class="row1">';

			if ($row['approved'] == 'y') {
				echo ' <input type="checkbox" name="nid[]" value="'.$row[member_id].'" id="n'.$row[member_id].'" />';
				echo '<label for="n'.$row[member_id].'">'.$_template['disapprove'].'</label>';
			}
			echo '&nbsp;</td>';

			echo '<td class="row1"><input type="checkbox" name="rid[]" value="'.$row[member_id].'" id="r'.$row[member_id].'" /><label for="r'.$row[member_id].'">'.$_template['remove'].'</label></td>';

			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

		} while ($row = mysql_fetch_array($result));

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
