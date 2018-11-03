<?php

$_include_path = '../include/';
$_editor_path = '../editor/';
require ($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

if ($_POST['edit_news'] && $_SESSION['is_admin']) {
	$_POST['title'] = trim($_POST['title']);
	$_POST['body']  = trim($_POST['body']);
	$_POST['aid']	= intval($_POST['aid']);
	$_POST['formatting']	= 1;

	if (($_POST['title'] == '') && ($_POST['body'] == '')) {
		$errors[] = AT_ERROR_ANN_BOTH_EMPTY;
	}

	if (!$errors) {
		$sql = "UPDATE news SET title='$_POST[title]', body='$_POST[body]', formatting=1 WHERE news_id=$_POST[aid] AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql,$db);

		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_NEWS_UPDATED));
		exit;
	}
}

$_section[0][0] = $_template['edit_announcement'];

$onload = 'onLoad="document.form.title.focus()"';

require($_include_path.'header.inc.php');
require($_editor_path.'spaw_control.class.php');

		print_errors($errors);

?>
<h2><?php echo $_template['edit_announcement']; ?></h2>
<?php
	
	if (isset($_GET['aid'])) {
		$aid = intval($_GET['aid']);
	} else {
		$aid = intval($_POST['aid']);
	}

	if ($aid == 0) {
		$errors[]=AT_ERROR_ANN_ID_ZERO;
		print_errors($errors);
		require ($_include_path.'footer.inc.php');
		exit;
	}
	
	$sql = "SELECT * FROM news WHERE news_id=$aid AND member_id=$_SESSION[member_id] AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql,$db);
	if (!($row = mysql_fetch_array($result))) {
		$errors[]=AT_ERROR_ANN_NOT_FOUND;
		print_errors($errors);
		require ($_include_path.'footer.inc.php');
		exit;
	}
	$_POST['formatting'] = 1;

?>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
<input type="hidden" name="edit_news" value="true">
<input type="hidden" name="aid" value="<?php echo $row['news_id']; ?>">
<p>
<table cellspacing="1" width="98%" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ANNOUNCEMENT); ?>
<?php echo $_template['edit_announcement']; ?></th>
</tr>
<tr>
	<td align="right" class="row1"><b><?php echo $_template['title']; ?>:</b></td>
	<td class="row1"><input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" class="formfield" size="40"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><?php echo $_template['body']; ?>:</b></td>
	<td class="row1">
		<!-- <textarea name="body" cols="55" rows="15" id="body" class="formfield" wrap="wrap"><?php // echo $row['body']; ?></textarea> -->
		<?php $sw = new SPAW_Wysiwyg('body',stripslashes($row['body']));
		$sw->show(); ?>
		</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<!-- <tr>
	<td align="right" class="row1">	
	<?php // print_popup_help(AT_HELP_FORMATTING); ?>
	<b><?php echo $_template['formatting']; ?>:</b></td>
	<td class="row1"><input type="radio" name="formatting" value="0" id="text" <?php //if ($_POST['formatting'] === 0) { echo 'checked="checked"'; } ?> /><label for="text"><?php // echo $_template['plain_text']; ?></label>, <input type="radio" name="formatting" value="1" id="html" <?php // if ($_POST['formatting'] !== 0) { echo 'checked="checked"'; } ?> /><label for="html"><?php // echo $_template['html']; ?></label> <?php

	?></td>
</tr> 
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><a href="<?php //echo substr($_my_uri, 0, strlen($_my_uri)-1); ?>#jumpcodes" title="<?php //echo $_template['jump_codes']; ?>"><img src="images/clr.gif" height="1" width="1" alt="<?php //echo $_template['jump_codes']; ?>" border="0" /></a><?php //require($_include_path.'html/code_picker.inc.php'); ?><br /></td>
</tr> -->
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><br /><a name="jumpcodes"></a><input type="submit" name="submit" value="<?php echo $_template['edit_announcement']; ?>[Alt-s]" accesskey="s" class="button"> - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</p>
</form>
<?php
	require ($_include_path.'footer.inc.php');
?>