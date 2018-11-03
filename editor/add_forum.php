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
	require ($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: '.$_base_href.'discussions/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if ($_POST['add_forum'] && $_SESSION['is_admin']) {
		$_POST['title'] = str_replace('<', '&lt;', trim($_POST['title']));
		$_POST['body']  = str_replace('<', '&lt;', trim($_POST['body']));

		if ($_POST['title'] == '') {
			$errors[] = AT_ERROR_FORUM_TITLE_EMPTY;

		}

		if (!$errors) {
			$sql	= "INSERT INTO forums VALUES (0, $_SESSION[course_id], '$_POST[title]', '$_POST[body]')";
			$result = mysql_query($sql,$db);

			//$f = array(AT_FEEDBACK_FORUM_ADDED, AT_FEEDBACK_FORUM_ADDED);
			$f = AT_FEEDBACK_FORUM_ADDED;
			Header('Location: '.$_base_href.'discussions/?f='.urlencode_feedback(AT_FEEDBACK_FORUM_ADDED));
			exit;
		}
	}

	$_section[0][0] = $_template['add_forum'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');

	print_errors($errors);

?>
<a href="discussions/?g=11"><h2><?php  echo $_template['discussions']; ?></h2></a>
<h3><?php  echo $_template['add_forum']; ?></h3>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
<input type="hidden" name="add_forum" value="true">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php print_popup_help(AT_HELP_ADD_FORUM_MINI); ?><?php  echo $_template['add_forum']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><b><label for="title"><?php  echo $_template['forum_title']; ?>:</label></b></td>
	<td class="row1"><input type="text" name="title" class="formfield" size="40" id="title"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><label for="body"><?php echo $_template['forum_description']; ?>:</label></b></td>
	<td class="row1"><textarea name="body" cols="45" rows="10" class="formfield" id="body" wrap="wrap"></textarea><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><br /><input type="submit" name="submit" value="<?php  echo $_template['add_forum']; ?> [Alt-s]" class="button" accesskey="s"> - <input type="submit" name="cancel" value="<?php  echo $_template['cancel']; ?>" class="button"></td>
</tr>
</table>
</p>
</form>

<?php
	require($_include_path.'footer.inc.php');
?>
