<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$section = 'users';
$_include_path = '../../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');

if (!$_SESSION['s_is_super_admin']) {
	Header('Location: index.php');
	exit;
}

if ($_POST['submit']) {
	$_POST['form_status']	= intval($_POST['form_status']);
	$_POST['form_id']		= intval($_POST['form_id']);
	$_POST['old_status']	= intval($_POST['old_status']);

	$sql = "UPDATE members SET status=$_POST[form_status] WHERE member_id=$_POST[form_id]";
	$result = $db->query($sql);

	if (!$result) {
		echo 'DB Error';
		exit;
	}

	if ($_POST['form_status'] > $_POST['old_status']) {
		/* delete the request: */
		$sql = "DELETE FROM instructor_approvals WHERE member_id=$_POST[form_id]";
		$result = $db->query($sql);

		/* notify the users that they have been approved: */
		$sql   = "SELECT email FROM members WHERE member_id=$_POST[form_id]";
		$result = $db->query($sql);
		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			/* assumes that there is a first and last name for this user, but not required during registration */
			$to_email = $row['EMAIL'];

			$message  = $row['LOGIN'].",\n\n";
			//$message .= 'Your instructor account request for the klore system has been approved. Go to '.$_base_href.' to login to your control centre and start creating your courses. ';
			$message .= $_template['instructor_request_msg1'].' '.$_base_href.' '.$_template['instructor_request_msg2'];

			if ($to_email != '') {
				klore_mail($to_email, 'klore Instructor Request', $message, ADMIN_EMAIL);
			}
		}
	}
	Header ('Location: ./users.php');
	exit;
}

require($_include_path.'admin_html/header.inc.php'); 
?>
<h2><?php echo $_template['klore_administration']; ?></h2>
<h3><?php echo $_template['edit_user']; ?></h3>

<?php
		$id		= intval($_GET[id]);
		$sql	= "SELECT * FROM members WHERE member_id=$id";
		$result = $db->query($sql);
		if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC)))
		{
			echo $_template['no_user_found'];
		} else {
			echo $_template['login'].": <b>$row[LOGIN]</b>";
			echo '<br />';
			echo '<form method="post" action="'.$PHP_SELF.'">';
			echo '<input type="hidden" name="form_id" value="'.$id.'">';
			if ($row['STATUS'])
			{
				$inst = ' checked="checked"';
			} else {
				$stnd = ' checked="checked"';
			}
			echo $_template['role'].': <input type="radio" name="form_status" value="1" id="inst"'.$inst.' /><label for="inst">'.$_template['instructor'].'</label>, <input type="radio" name="form_status" value="0" id="stnd"'.$stnd.' /><label for="stnd">'.$_template['student1'].'</label>';
			echo '<br />';
			echo '<br />';
			echo '<input type="submit" name="submit" value="'.$_template['update_status'].'" class="button" />';
			echo '<input type="hidden" name="old_status" value="'.$row['STATUS'].'" />';
			echo '</form>';
		}
?>
 
<?php
	require($_include_path.'cc_html/footer.inc.php'); 
?>
