<?php

$_include_path = '../include/';
$_editor_path = '../editor/';
require ($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: discussions/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

if ($_POST['edit_post'] && $_SESSION['is_admin']) {
	$_POST['subject']	= str_replace('<', '&lt;', trim($_POST['subject']));
	// $_POST['body']		= str_replace('<', '&lt;', trim($_POST['body']));
	$_POST['pid']		= intval($_POST['pid']);

	$sql = "UPDATE forums_threads SET subject='$_POST[subject]', body='$_POST[body]' WHERE post_id=$_POST[pid] AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql,$db);

	Header('Location: ../forum/view.php?fid='.$_POST['fid'].SEP.'pid='.$pid.SEP.'f='.urlencode_feedback(AT_FEEDBACK_POST_EDITED));
	exit;
}

$_include_path = '../include/';
$_section[0][0] = 'Discussions';
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($_GET['fid']).' Forum';
$_section[1][1] = 'forum/?fid='.$_GET['fid'];
$_section[2][0] = 'Edit Post';

$onload = 'onLoad="document.form.subject.focus()"';

require($_include_path.'header.inc.php');
require($_editor_path.'spaw_control.class.php');
?>
<h2>Edit Post</h2>
<?php
	
	if (isset($_GET['pid'])) {
		$pid = intval($_GET['pid']);
	} else {
		$pid = intval($_POST['pid']);
	}

	if ($pid == 0) {
		$errors[]=AT_ERROR_POST_ID_ZERO;
		require ($_include_path.'footer.inc.php');
		exit;
	}
	
	$sql = "SELECT * FROM forums_threads WHERE post_id=$pid AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql,$db);
	if (!($row = mysql_fetch_array($result))) {
		$errors[]=AT_ERROR_POST_NOT_FOUND;
		require ($_include_path.'footer.inc.php');
		exit;
	}

?>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
<input type="hidden" name="edit_post" value="true">
<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<input type="hidden" name="fid" value="<?php echo $row['forum_id']; ?>">
<br />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
<tr>
	<th colspan="2" class="left">Edit Post</th>
</tr>
<tr>
	<td class="row1" align="right"><label for="subject"><b>Subject:</b></label></td>
	<td class="row1"><input class="formfield" maxlength="45" name="subject" size="36" value="<?php echo $row['subject']; ?>" id="subject" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="body"><b>Body:</b></label></td>
	<td class="row1">
	<!-- <textarea class="formfield" cols="65" name="body" rows="10" wrap="virtual" id="body" /><?php //echo $row['body']; ?></textarea><br /><small class="spacer">* All words starting with http:// are made into link<br />* All email addresses are made into links</small><br /><br /> -->
	<?php $sw = new SPAW_Wysiwyg('body',stripslashes($row['body']));
	$sw->show(); ?>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><input name=submit class="button" type=submit value="  Submit  [Alt-s]" accesskey="s" /> - <input type="submit" name="cancel" class="button" value=" Cancel " /></td>
</tr>
</table>
</form>
<?php
	require ($_include_path.'footer.inc.php');
?>
