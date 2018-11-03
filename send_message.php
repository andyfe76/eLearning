<?php

$_include_path = 'include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = $_template['inbox'];
$_section[0][1] = 'inbox.php';
$_section[1][0] = $_template['send_message'];
$_section[1][1] = 'send_message.php';



if (!$_SESSION['valid_user']) {
	require($_include_path.'header.inc.php');
	$errors[]=AT_ERROR_MSG_SEND_LOGIN;
	print_errors($errors);
	require($_include_path.'footer.inc.php');
	exit;
}

if (($_POST['submit']) || ($_POST['submit_delete'])) {
	$_POST['subject'] = str_replace('<', '&lt;', $_POST['subject']);
	$_POST['message'] = str_replace('<', '&lt;', $_POST['message']);

	if ($_POST['subject'] == '') {

		$errors[]=AT_ERROR_MSG_SUBJECT_EMPTY;
	}
	if ($_POST['message'] == '') {

		$errors[]=AT_ERROR_MSG_BODY_EMPTY;
	}

	if (($_POST['to'] == '') || ($_POST['to'] == 0)) {
		 $errors[] = AT_ERROR_NO_RECIPIENT;

	}

	if (!$errors) {
		$msid = $db->nextId("AUTO_MESSAGES_MSID_SEQ");
		$sql = "INSERT INTO messages VALUES ($msid, $_SESSION[member_id], $_POST[to], SYSDATE, 1, 0, '$_POST[subject]', '$_POST[message]')";

		$result = $db->query($sql);

		if ($_POST['replied'] != '') {
			$result = $db->query("UPDATE messages SET replied=1 WHERE message_id=$_POST[replied]",$db);
		}

		if ($_POST['submit_delete']) {
			$result = $db->query("DELETE FROM messages WHERE message_id=$_POST[replied] AND to_member_id=$_SESSION[member_id]",$db);
		}

		Header ('Location: ./inbox.php?s=1');
		exit;
	}
}




$sql	= "SELECT COUNT(*) AS cnt FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND approved='y'";
$result = $db->query($sql);
$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

if ($row['CNT'] == 0) {
	require($_include_path.'header.inc.php');

	$errors[]=AT_ERROR_SEND_ENROL;
	print_errors($errors);
	require($_include_path.'footer.inc.php');
	exit;
}


if ($_GET['reply'] == '') {
	$onload = 'onload="document.form.subject.focus()"';
} else {
	$onload = 'onload="document.form.body.focus()"';
}

require($_include_path.'header.inc.php');

?>
<h2><a href="inbox.php"><?php echo $_template['inbox']; ?></a></h2>
<p><?php echo $_template['inbox_about']; ?></p>
<?php

print_errors($errors);

if ($_GET['reply'] != '') {

	$_GET['reply'] = intval($_GET['reply']);

	// get the member_id of the sender
	$result = $db->query("SELECT from_member_id,subject,body FROM messages WHERE message_id=$_GET[reply] AND to_member_id=$_SESSION[member_id]",$db);
	if ($myinfo =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$reply_to	= $myinfo['FROM_MEMBER_ID'];
		$subject	= $myinfo['SUBJECT'];
		$body		= $myinfo['BODY'];
	}
}
if ($_GET['l'] != '') {
	$reply_to = intval($_GET['l']);
}

/* check to make sure we're enrolled in atleast one course */
$sql	= "SELECT COUNT(*) AS cnt FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND approved='y'";
$result = $db->query($sql);
$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);

if ($row['CNT'] == 0) {
	$errors[]=AT_ERROR_SEND_ENROL;
	print_errors($errors);
	require($_include_path.'footer.inc.php');
	exit;
}

/* check to make sure we're in the same course */
if ($reply_to) {
	$sql	= "SELECT COUNT(*) AS cnt FROM course_enrollment E1, course_enrollment E2 WHERE E1.member_id=$_SESSION[member_id] AND E2.member_id=$reply_to AND E1.course_id=E2.course_id AND E1.approved='y' AND E2.approved='y'";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

	if ($row['CNT'] == 0) {
		$errors[]=AT_ERROR_SEND_MEMBERS;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

}

?>

<form method="post" action="<?php echo $PHP_SELF; ?>" name="form">
<input type="hidden" name="replied" value="<?php echo $_GET['reply']; ?>" />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="85%" summary="">
<tr>
	<th colspan="2" align="left" class="left"><?php echo  $_template['send_message']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><b><label for="to"><?php echo  $_template['to']; ?>:</label></b></td>
	<td class="row1"><?php

		if ($_GET['reply'] == '') {
			$statuslist = STATUS_ADMINISTRATOR.','.STATUS_TRAINER.','.STATUS_TRAINING_MANAGER;
			/*if (($_SESSION['status']==STATUS_ADMINISTRATOR) || ($_SESSION['status']==STATUS_TRAINER) || ($_SESSION['status']==STATUS_TRAINING_MANAGER)) {
				$sql	= "SELECT * FROM members WHERE login IN (SELECT DISTINCT M.login FROM members M INNER JOIN course_enrollment E ON M.member_id=E.member_id WHERE E.course_id IN (SELECT DISTINCT course_id FROM course_enrollment WHERE member_id=".$_SESSION['member_id'].") AND E.approved='y') ORDER BY login";
			} else {
				$sql	= "SELECT * FROM members WHERE login IN (SELECT DISTINCT M.login FROM members M INNER JOIN course_enrollment E ON M.member_id=E.member_id WHERE E.course_id IN (SELECT DISTINCT course_id FROM course_enrollment WHERE member_id=".$_SESSION['member_id'].") AND E.approved='y') AND status IN (".$statuslist.") ORDER BY login";
			}*/
			$sql = "SELECT * FROM members WHERE status IN ($statuslist)";
			$result = $db->query($sql);
			//print_r($result);
			$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);
			echo '<select class="formfield" name="to" size="1" id="to">';
			echo '<option value="0"></option>';
			do {
				
				$name = str_replace('<','&lt;',$row['LOGIN']);
				echo '<option value="'.$row['MEMBER_ID'].'"';
				if ($reply_to == $row['MEMBER_ID']){
					echo ' selected="selected"';
				}
				if ($log == $name){
					echo ' selected="selected"';
				}
				echo '>'.$name.'</option>';
			} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
			echo '</select> <small class="spacer">'.$_template['same_course_users'].'</small>';
		} else {
			echo get_login($reply_to);
			echo '<input type="hidden" name="to" value="'.$reply_to.'" />';
		}
	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><label for="subject"><?php echo  $_template['subject']; ?>:</label></b></td>
	<td class="row1"><input class="formfield" style="font-size: 8pt" type="text" name="subject" id="subject" value="<?php
		if (($subject != '') && ($_POST['subject'] == '')) {
			if (!(substr($subject, 0, 2) == 'Re')) {
				$subject = "Re: $subject";
			}
			echo ContentManager::cleanOutput($subject);
		} else {
			echo ContentManager::cleanOutput($_POST['subject']);
		}
		?>" size="40" maxlength="100" /></td>	
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><b><label for="body"><?php echo $_template['message']; ?>:</label></b></td>
	<td class="row1"><textarea class="formfield" style="font-size: 8pt" name="message" id="body" rows="15" cols="55"><?php
	if ($body != '') {
		if (strlen($body) > 400){
			$body = substr($body,0,400);
			$pos = strrpos($body,' ');
			$body = substr($body,0,$pos);
			$body .= ' ...';
		}
		$body  = "\n\n\n".$_template['in_reply_to'].":\n".$body;
		echo $body;
	} else {
		echo $_POST['message'];
	}
	?></textarea><small class="bigspacer"><br />&middot; <?php echo  $_template['html_disabled']; ?>.</small><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><a href="<?php echo substr($_my_uri, 0, strlen($_my_uri)-1); ?>#jumpcodes" title="<?php echo $_template['jump_code']; ?>"><img src="images/clr.gif" height="1" width="1" alt="<?php echo $_template['jump_code']; ?>" border="0" /></a>
	<?php //require($_include_path.'html/code_picker.inc.php'); ?><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><a name="jumpcodes"></a><input type="submit" name="submit" value="  <?php  echo $_template['send_message'] ?> [Alt-s]  " class="button" accesskey="s" />&nbsp;&nbsp;<?php
	if ($reply != '') {
		echo '<input type="submit" name="submit_delete" value="'.$_template['send_delete'].' [Alt-n]" accesskey="n" class="button" />&nbsp;';
	}
	?>&nbsp;<input type="reset" value="<?php echo $_template['start_over']; ?>" class="button" /></td>
</tr>
</table>
</form> 

<?php
	require ($_include_path.'footer.inc.php');
?>

