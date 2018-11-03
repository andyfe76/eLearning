<?php

$section = 'users';
$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');
require ($_include_path.'lib/klore_mail.inc.php');

$course = intval($_GET['course']);

if ($course == 0) {
	$course = intval($_POST['course']);
}

/* make sure we own this course that we're approving for! */
$sql	= "SELECT * FROM courses WHERE course_id=$course AND member_id=$_SESSION[member_id]";
$result	= mysql_query($sql, $db);
if (!$row2 = mysql_fetch_array($result)) {
	$errors[]=AT_ERROR_PREFS_NO_ACCESS;
	print_errors($errors);
	//print_errors('This is not your course!');
	exit;
}

if ($_POST['cancel']) {
	Header('Location: index.php');
	exit;
}

require($_include_path.'cc_html/header.inc.php');


if ($_POST['submit']) {
	$_POST['subject'] = trim($_POST['subject']);
	$_POST['body'] = trim($_POST['body']);

	if ($_POST['subject'] == '') {
		$errors[]=AT_ERROR_MSG_SUBJECT_EMPTY;
	}

	if ($_POST['body'] == '') {
		$errors[]=AT_ERROR_MSG_BODY_EMPTY;
	}


	if (!$errors) {
		// note: doesn't list the owner of the course.
		$sql	= "SELECT * FROM course_enrollment C, members M WHERE C.course_id=$course AND C.member_id=M.member_id AND M.member_id<>$_SESSION[member_id] ORDER BY C.approved, M.login";

		$result = mysql_query($sql);

		while ($row = mysql_fetch_array($result)) {
			if ($bcc != '') {
				$bcc .= ', ';
			}
			$bcc .= $row['email'];
		}

		$result = mysql_query("SELECT email FROM members WHERE member_id=$_SESSION[member_id]", $db);
		$row	= mysql_fetch_array($result);


		klore_mail($row['email'], $_POST['subject'], $_POST['body'], $row['email'], $bcc);
		$feedback[]=AT_FEEDBACK_MSG_SENT;
		print_feedback($feedback);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
}

/* we own this course! */

?>

<h2><?php echo $_template['course_email']; ?></h2>
<?php
print_errors($errors);


	$sql	= "SELECT COUNT(*) AS cnt FROM course_enrollment C, members M WHERE C.course_id=$course AND C.member_id=M.member_id AND M.member_id<>$_SESSION[member_id] ORDER BY C.approved, M.login";
	$result = mysql_query($sql);
	$row	= mysql_fetch_array($result);
	if ($row['cnt'] == 0) {
		$errors[]=AT_ERROR_NO_STUDENTS;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}

?>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<input type="hidden" name="course" value="<?php echo $course; ?>">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<th colspan=2 align=left class=left><?php  print_popup_help(AT_HELP_COURSE_EMAIL); ?><?php echo $_template['send_to']; ?> <i><?php echo $row2['title']; ?></i> <?php echo $_template['students']; ?></th>
</tr>
<tr>
	<td width=100 class=row1 align=right><b><label for="subject"><?php echo $_template['subject']; ?>:</label></b></td>
	<td class=row1><input type="text" name="subject" class="formfield" size="40" id="subject" value="<?php echo $_POST['subject']; ?>"></td>
</tr>
<tr>
	<td height="1" class="row2" colspan="2"></td>
</tr>
<tr>
	<td width=100 class=row1 align=right valign="top"><b><label for="body"><?php echo $_template['body']; ?>:</label></b></td>
	<td class=row1><textarea cols="55" rows="18" name="body" id="body" class="formfield" wrap="wrap"><?php echo $_POST['body']; ?></textarea><br /><br /></td>
</tr>
<tr>
	<td height="1" class="row2" colspan="2"></td>
</tr>
<tr>
	<td height="1" class="row2" colspan="2"></td>
</tr>
<tr>
	<td colspan="2" class="row1" align="center"><input type="submit" name="submit" value="<?php echo $_template['send_message']; ?>" class="button"> - <input type="submit" name="cancel" value="<?php echo $_template['cancel']; ?>" class="button"></td>
</tr>
</table>
</p>
</form>

<?php
	require($_include_path.'cc_html/footer.inc.php');
?>
