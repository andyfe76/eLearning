<?php

$section = 'users';
$_include_path = '../../include/';
require($_include_path.'vitals.inc.php');

if (!$_SESSION['s_is_super_admin']) {
	exit;
}
$L=$_GET['L'];
if ($_GET['delete']) {
	$sql	= "DELETE FROM course_enrollment WHERE member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM forums_accessed WHERE member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM forums_subscriptions WHERE member_id=$id";
	$result = mysql_query($sql);

	/* can't delete the posts b/c it'll affect the page count and the reply count */
	$sql	= "UPDATE forums_threads SET body='[i]This post was deleted along with its owner.[/i]', subject='Deleted', member_id=0, login='Deleted' WHERE member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM instructor_approvals WHERE member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM messages WHERE from_member_id=$id OR to_member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM users_online WHERE member_id=$id";
	$result = mysql_query($sql);

	$sql	= "DELETE FROM members WHERE member_id=$id";
	$result = mysql_query($sql);

	//$feedback[]=AT_FEEDBACK_USER_DELETED;
	//print_feedback($feedback);
	Header('Location: users.php?f='.urlencode_feedback(AT_FEEDBACK_USER_DELETED).SEP.'L='.$L);
	exit;
}
if ($_GET['cancel'] == 1) {
	Header('Location: users.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'L='.$L);
	exit;
}
require($_include_path.'admin_html/header.inc.php');
?>
<h2><?php echo $_template['klore_administration'] ?></h2>
<h3><?php echo $_template['delete_user'] ?></h3>

<?php
	$id		= intval($_GET['id']);
	$sql	= "SELECT * FROM members WHERE member_id=$id";
	$result = mysql_query($sql);
	if (!($row = mysql_fetch_array($result))) {

		echo $_template['no_user_found'];
	} else {

		$sql	= "SELECT * FROM courses WHERE member_id=$id";
		$result = mysql_query($sql);
		if (($row2 = mysql_fetch_array($result))) {
			$errors[]=AT_ERROR_NODELETE_USER;
			print_errors($errors);
		} else {
			if ($_GET['delete']) {
				/*$sql	= "DELETE FROM course_enrollment WHERE member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM forums_accessed WHERE member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM forums_subscriptions WHERE member_id=$id";
				$result = mysql_query($sql);
				*/
				/* can't delete the posts b/c it'll affect the page count and the reply count */
				/*
				$sql	= "UPDATE forums_threads SET body='[i]This post was deleted along with its owner.[/i]', subject='Deleted', member_id=0, login='Deleted' WHERE member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM instructor_approvals WHERE member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM messages WHERE from_member_id=$id OR to_member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM users_online WHERE member_id=$id";
				$result = mysql_query($sql);

				$sql	= "DELETE FROM members WHERE member_id=$id";
				$result = mysql_query($sql);

				//$feedback[]=AT_FEEDBACK_USER_DELETED;
				//print_feedback($feedback);
				Header('Location: users.php?f='.urlencode_feedback(AT_FEEDBACK_USER_DELETED));
				exit;*/
			} else {
				$warnings[]=array(AT_WARNING_DELETE_USER, $row[login]);
				print_warnings($warnings);
				echo '<a href="'.$PHP_SELF.'?L='.$L.SEP.'id='.$id.SEP.'delete=1">'.$_template['yes_delete'].'</a>';
				echo ' <span class="bigspacer">|</span> ';
				echo '<a href="'.$PHP_SELF.'?L='.$L.SEP.'cancel=1">'.$_template['no_cancel'].'</a>.';
			}
		}
	}

	require($_include_path.'cc_html/footer.inc.php');
?>
