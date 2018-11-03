<?php

$_include_path = '../include/';
$_editor_path = '../editor/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');

$fid = intval($_GET['fid']);

if ($fid == 0) {
	$fid = intval($_POST['fid']);
}

$_section[0][0] = $_template['discussions'];
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($fid);
$_section[1][1] = 'forum/?fid='.$fid;
$_section[2][0] = $_template['new_thread'];;

if ($_POST['submit']) {
	$_POST['subject']	= str_replace('<','&lt;', trim($_POST['subject']));
	// $_POST['body']		= str_replace('<','&lt;', trim($_POST['body']));
	$_POST['parent_id'] = intval($_POST['parent_id']);
	$_POST['fid']		= intval($_POST['fid']);
	$_POST['page']		= intval($_POST['page']);
	$_POST['reply']		= intval($_POST['reply']);
	$_POST['parent_name']	= trim($_POST['parent_name']);
	$_POST['replytext'] = trim($_POST['replytext']);

	if ($_POST['subject'] == '') {
		$errors[] = AT_ERROR_MSG_SUBJECT_EMPTY;
	}

	if ($_POST['body'] == '') {
		$errors[] = AT_ERROR_MSG_BODY_EMPTY;
	}

	if (!$errors) {
		if ($_POST['replytext'] != '') {
			$_POST['body'] .= "\n\n".'[reply][b]'.$_template['in_reply_to'].': [/b]'."\n";
			if (strlen($_POST['replytext']) > 200) {
				$_POST['body'] .= substr($_POST['replytext'], 0, 200).'...';
			} else {
				$_POST['body'] .= $_POST['replytext'];
			}
			$num_open_replies = substr_count($_POST['body'], '[reply]');
			$num_close_replies = substr_count($_POST['body'], '[/reply]');
			$num_replies_add = $num_open_replies - $num_close_replies - 1;
			for ($i=0; $i < $num_replies_add; $i++) {
				$_POST['body'] .= '[/reply]';
			}

			$_POST['body'] .= "\n".'[op]forum/view.php?fid='.$_POST['fid'].SEP.'pid='.$_POST['parent_id'].SEP.'page='.$_POST['page'].'#'.$_POST['reply'];
			$_POST['body'] .= '[/op][/reply]';

		}

		/* use this value instead of NOW(), because we want the parent post to have the exact */
		/* same date. and not a second off if that may happen */
		$now = date('Y-m-d H:i:s');

		$sql = "INSERT INTO forums_threads VALUES(0, $_POST[parent_id], $_SESSION[course_id], $_SESSION[member_id], $_POST[fid], '$_SESSION[login]', '$now', 0, '$_POST[subject]', '$_POST[body]', '$now', 0, 0)";

		$result	 = mysql_query($sql, $db);
		$this_id = mysql_insert_id();

		if ($_POST['parent_id'] != 0) {
			$sql = "UPDATE forums_threads SET num_comments=num_comments+1, last_comment='$now' WHERE post_id=$_POST[parent_id]";
			$result = mysql_query($sql, $db);

			/* WARNING!!!!											*/
			/* this joing will be VERY costly when usage increases! */
			$sql	= "SELECT M.email, M.login FROM members M, forums_subscriptions S WHERE S.post_id=$_POST[parent_id] AND S.member_id=M.member_id AND M.email <>'' AND S.member_id<>$_SESSION[member_id]";

			$result = mysql_query($sql, $db);

			while ($row = mysql_fetch_array($result)) {
				if ($bcc != '') {
					$bcc .= ', ';
				}
				$bcc .= $row['email'];
			}
			//$body = $_template['thread_notify'];
			//$body = $_template['thread_notify2'].' '.$_SESSION[course_title].' '.$_template['thread_notify3'].' '.get_forum($_POST['fid']).' '.$_template['thread_notify4'].' "'.$_POST['parent_name'].'" '.$_template['thread_notify4'].':'.$_base_href;

			$body = $_template['thread_notice1'].' '. $_SESSION['course_title'].' '.$_template['thread_notice2'].' "'.get_forum($_POST['fid']).'" '.$_template['thread_notice3'].' "'.$_POST['parent_name'].'" '.$_template['thread_notice4']."\n\nklore: $_base_href";
			if ($bcc != '') {
				klore_mail('', $_template['thread_notify1'], $body, 'noreply@noserver.com',$bcc);
			}
			$this_id = $_POST['parent_id'];
		} 

		if ($_POST['subscribe']) {
			$sql	= "INSERT INTO forums_subscriptions VALUES ($this_id, $_SESSION[member_id])";
			$result = mysql_query($sql, $db);
		}

		if ($_POST['parent_id'] == 0) {
			Header('Location: ./?fid='.$fid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_THREAD_STARTED));
			exit;
		}
		
		Header('Location: view.php?fid='.$fid.SEP.'pid='.$_POST['parent_id'].SEP.'f='.urlencode_feedback(AT_FEEDBACK_THREAD_REPLY));
		exit;
		
	}
}

$onload = 'onLoad="document.form.subject.focus()"';

require($_include_path.'header.inc.php');
require($_editor_path.'spaw_control.class.php');
echo '<a href="discussions/?g=11"><h2>'.$_template['discussions'].'</h2></a>';
echo '<h3><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h3>';

$parent_id = 0;

require($_include_path.'lib/new_thread.inc.php');

require($_include_path.'footer.inc.php');

?>
