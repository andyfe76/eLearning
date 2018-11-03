<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'lib/klore_mail.inc.php');
	$_section[0][0] = $_template['help'];
	$_section[0][1] = 'help/';
	$_section[1][0] = $_template['contact_admin'];

	if ($_POST['cancel']) {
		Header('Location: index.php?cid='.$_POST['pid'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	require ($_include_path.'header.inc.php');

	if (!$_SESSION['valid_user'] || !$_SESSION['is_admin']) {
		$errors[]=AT_ERROR_ACCESS_INSTRUCTOR;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

	$sql	= "SELECT login, email FROM members WHERE member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);
	if ($row = mysql_fetch_array($result)) {
		$student_name = $row['login'];
		//$student_name .= ($row['first_name'] ? ', '.$row['first_name'] : '');

		$student_email = $row['email'];
	} else {
		$errors[]=AT_ERROR_STUD_INFO_NOT_FOUND;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

	if (!defined('ADMIN_EMAIL')) {
		$errors[]=AT_ERROR_ADMIN_INFO_NOT_FOUND;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

?>

<h2><a href="help/?g=11"><?php echo $_template['help']; ?></a></h2>
<?php
	if ($_POST['submit']) {
		$_POST['subject'] = trim($_POST['subject']);
		$_POST['body']	  = trim($_POST['body']);

		if ($_POST['subject'] == '') {
			$errors[] = AT_ERROR_MSG_SUBJECT_EMPTY;
		}
		
		if ($_POST['body'] == '') {
			$errors[] = AT_ERROR_MSG_BODY_EMPTY;
		}
		
		if (!$errors) {

			$message  = $_POST['body']."\n\n";
			$message .= '------------------------'."\n";
			$message .= $_template['from_klore'].' '.$_SESSION['course_title'];

			klore_mail(ADMIN_EMAIL, 
						$_POST['subject'], 
						$message, 
						$_POST['from_email']);

			echo $_template['message_sent'];
			require($_include_path.'footer.inc.php');
			exit;
		}
	}

	print_errors($errors);

?>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="85%" summary="">
<tr>
	<th colspan="2" align="left" class="left"><?php echo $_template['contact_admin_form'] ;?></th>
</tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['to_name']; ?>:</b></td>
	<td class="row1"><?php echo $_template['klore_sys_admin']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['to_email']; ?>:</b></td>
	<td class="row1"><i><?php echo $_template['hidden']; ?></i></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="from"><b><?php echo $_template['from_name']; ?>:</b></label></td>
	<td class="row1"><input type="text" class="formfield" name="from" id="from" size="40" value="<?php echo $student_name;?>"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="from_email"><b><?php echo $_template['from_email']; ?>:</b></label></td>
	<td class="row1"><input type="text" class="formfield" name="from_email" id="from_email" size="40" value="<?php echo $student_email;?>" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="subject"><b><?php echo $_template['subject']; ?>:</b></label></td>
	<td class="row1"><input type="text" class="formfield" name="subject" id="subject" size="40" value="<?php echo $_POST['subject']; ?>" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="body"><b><?php echo $_template['body']; ?>:</b></label></td>
	<td class=row1><textarea class="formfield" cols="55" rows="15" id="body" name="body"><?php echo $_POST['body']; ?></textarea><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class=row1 align="center" colspan="2"><input type="submit" name="submit" class="button" value="<?php echo $_template['send_message']; ?> [Alt-s]" accesskey="s" /> - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel']; ?>" /></td>
</tr>
</table>
</p>
</form>
<br />

<?php
	require($_include_path.'footer.inc.php');
?>