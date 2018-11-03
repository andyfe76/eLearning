<?php

$_include_path = 'include/';
require ($_include_path.'vitals.inc.php');

$course = intval($_GET['course']);
if ($course == 0) {
	$course = intval($_POST['form_course_id']);
}
if ($course == 0) {
	exit;
}
///
$sql	= "SELECT access, member_id FROM courses WHERE course_id=$course";
$result = mysql_query($sql, $db);
$course_info = mysql_fetch_array($result);

if ($_POST['submit']) {
	$_SESSION['enroll'] = true;
	$_POST['form_course_id'] = intval($_POST['form_course_id']);

	if ($course_info[0] == 'private') {
		$sql	= "INSERT INTO course_enrollment VALUES ($_SESSION[member_id], $_POST[form_course_id], 'n', NOW(), NULL)";
		$result = mysql_query($sql, $db);

		// send the email thing. if needed

		$sql	= "SELECT notify, member_id FROM courses WHERE course_id=$_POST[form_course_id] AND notify=1";
		$result = mysql_query($sql, $db);
		if ($row = mysql_fetch_array($result)) {
			// notify is enabled. get the email
			$sql	= "SELECT email, login FROM members WHERE member_id=$row[member_id]";
			$result = mysql_query($sql, $db);
			$row	= mysql_fetch_array($result);

			$to_email = $row['email'];

			$message  = $row['login'].",\n\n";
			$message .= $_template['enrol_msg'].'"'.$system_courses[$_POST[form_course_id]][title].'".';
			$message .= $_template['enrol_login'];
			if ($to_email != '') {
				mail($to_email, $_template['course_enrolment'], $message, 'From: '.ADMIN_EMAIL."\nReply-To: ".ADMIN_EMAIL."\nX-Mailer: PHP\nErrors-To: ".ADMIN_EMAIL);
			}
		}
	} else {
		// public or protected
		$sql	= "INSERT INTO course_enrollment VALUES ($_SESSION[member_id], $_POST[form_course_id], 'y', NOW(), NOW())";
		$result = mysql_query($sql, $db);
	}
}


require($_include_path.'header.inc.php');
?>
<h2><?php  echo $_template['course_enrolment']; ?></h2>

<?php
if ($_SESSION['valid_user']) {

	$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);

	if (($course_info[0] == 'public') || ($course_info[0] == 'protected')) {
		if ($row != '') {
			$feedback[]=array(AT_FEEDBACK_NOW_ENROLLED, $system_courses[$course][title]);
			print_feedback($feedback);
			//echo 'You are now enrolled in the course. Use your control centre to remove this course.';
		} else if ($course_info[1] != $_SESSION['member_id']) {
?>
			<form method="post" action="<?php echo $PHP_SELF; ?>">
			<input type="hidden" name="form_course_id" value="<?php echo $course; ?>">
			<?php  echo $_template['use_enrol_button']; ?>
			<br />
			<input type="submit" name="submit" class="button" value="<?php  echo $_template['enroll']; ?>">
			</form>
<?php
		} else {
			// we own this course!
			$errors[]=AT_ERROR_ALREADY_OWNED;
			print_errors($errors);
			//echo 'You already own this course!';
		}
	} else { // private
		if ((!$_POST['submit']) && ($row == '')) {
?>
		<form method="post" action="<?php echo $PHP_SELF; ?>">
		<input type="hidden" name="form_course_id" value="<?php echo $course; ?>">
		The course you are trying to access is <b>private</b>. Enrollment into this course require requests that must then be approved by the course instructor.<br />
		<input type="submit" name="submit" class="button" value="Request Enrollment">
		</form>
<?php

		} else if ($_POST['submit']) {
			$feedback[]=AT_FEEDBACK_APPROVAL_PENDING;
			print_feedback($feedback);

?>

<?php
		} else if ($course_info[1] != $_SESSION['member_id'] ){
		 // request has already been made
		 	$errors[]=AT_ERROR_ALREADY_ENROLED;
			 print_errors($errors);
?>
<?php
		} else {
			$errors[]=AT_ERROR_ALREADY_OWNED;
			print_errors($errors);
			//echo 'You already own this course!';
		}
	}

} else {
	$errors[]=AT_ERROR_LOGIN_ENROL;
	print_errors($errors);
	echo '<br /><a href="login.php?course='.$_SESSION[course_id].'">'.$_template['login_into_klore'].'</a><br />
	<a href="registration.php">'.$_template['register_an_account'].'</a><br />';
}


	require($_include_path.'footer.inc.php');
?> 
