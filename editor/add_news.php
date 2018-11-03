<?php

	$_include_path = '../include/';
	$_editor_path = '../editor/';
	require ($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if ($_POST['add_news'] && $_SESSION['is_admin']) {
		$_POST['title'] = trim($_POST['title']);
		$_POST['body']  = trim($_POST['body']);
		$_POST['formatting']	= 1;

		if (($_POST['title'] == '') && ($_POST['body'] == '')) {
			$errors[]=AT_ERROR_ANN_BOTH_EMPTY;
		}

		if (!$errors) {
			$sql	= "INSERT INTO news VALUES (0, $_SESSION[course_id], $_SESSION[member_id], NOW(), $_POST[formatting], '$_POST[title]', '$_POST[body]')";
			$result = mysql_query($sql,$db);

			Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_NEWS_ADDED));
			exit;
		}
	}

	$_section[0][0] = $_template['add_announcement'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');
	require($_editor_path.'spaw_control.class.php');
	
	print_errors($errors);

?>
<h2><?php echo $_template['add_announcement']; ?></h2>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
<input type="hidden" name="add_news" value="true">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2"><?php print_popup_help(AT_HELP_ANNOUNCEMENT); ?>
<?php echo $_template['add_announcement']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><b><label for="title"><?php echo $_template['title']; ?>:</label></b></td>
	<td class="row1"><input type="text" name="title" class="formfield" size="40" id="title"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><label for="body"><?php echo $_template['body']; ?>:</label></b></td>
	<td class="row1">
	<!-- <textarea name="body" cols="55" rows="15" class="formfield" id="body" wrap="wrap"></textarea> --> 
	<?php $sw = new SPAW_Wysiwyg('body',stripslashes($HTTP_POST_VARS['body']));
	$sw->show(); ?>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<!-- <tr>
	<td align="right" class="row1">	
	<?php // print_popup_help(AT_HELP_FORMATTING); ?>
	<b><?php // echo $_template['formatting']; ?>:</b></td>
	<td class="row1"><input type="radio" name="formatting" value="0" id="text" <?php //if ($_POST['formatting'] === 0) { echo 'checked="checked"'; } ?> /><label for="text"><?php // echo $_template['plain_text']; ?></label>, <input type="radio" name="formatting" value="1" id="html" <?php // if ($_POST['formatting'] !== 0) { echo 'checked="checked"'; } ?> /><label for="html"><?php // echo $_template['html']; ?></label> <?php

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><a href="<?php echo substr($_my_uri, 0, strlen($_my_uri)-1); ?>#jumpcodes" title="<?php echo $_template['jump_codes']; ?>"><img src="images/clr.gif" height="1" width="1" alt="<?php echo $_template['jump_codes']; ?>" border="0" /></a><?php require($_include_path.'html/code_picker.inc.php'); ?><br /></td>
</tr> -->
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><br /><a name="jumpcodes"></a><input type="submit" name="submit" value="<?php echo $_template['add_announcement']; ?> Alt-s" class="button" accesskey="s"> - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</p>
</form>

<?php
	require($_include_path.'footer.inc.php');
?>
