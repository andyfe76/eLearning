<?php

	$_include_path = '../include/';
	require ($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: '.$_base_href.'discussions/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if ($_POST['edit_forum'] && $_SESSION['is_admin']) {
		$_POST['title'] = str_replace('<', '&lt;', trim($_POST['title']));
		$_POST['body']  = str_replace('<', '&lt;', trim($_POST['body']));
		$_POST['fid']	= intval($_POST['fid']);

		if ($_POST['title'] == '') {
			$errors[]=AT_ERROR_FORUM_TITLE_EMPTY;
		}

		if (!$errors) {
			$sql	= "UPDATE forums SET title='$_POST[title]', description='$_POST[body]' WHERE forum_id=$_POST[fid] AND course_id=$_SESSION[course_id]";
			$result = mysql_query($sql,$db);

			Header('Location: ../discussions/?f='.urlencode_feedback(AT_FEEDBACK_FORUM_UPDATED));
			exit;
		}
	}

	$_section[0][0] = $_template['edit_forum'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');

	$fid = intval($_GET['fid']);

	$sql = "SELECT * FROM forums WHERE forum_id=$fid AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql,$db);
	if (!$errors) {
		if (!($row = mysql_fetch_array($result))) {
			$errors[]=AT_ERROR_FORUM_NOT_FOUND;
			//require ($_include_path.'footer.inc.php');
			//exit;
		}
	}


	print_errors($errors);
?>
<h2><?php  echo $_template['edit_forum']; 
	require($_editor_path.'spaw_control.class.php');
?></h2>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
<input type="hidden" name="edit_forum" value="true">
<input type="hidden" name="fid" value="<?php echo $fid; ?>">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php  echo $_template['edit_forum']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><b><label for="title"><?php  echo $_template['forum_title']; ?>:</label></b></td>
	<td class="row1"><input type="text" name="title" class="formfield" size="50" id="title" value="<?php echo $row['title']; ?>"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><label for="body"><?php  echo $_template['forum_description']; ?>:</label></b></td>
	<td class="row1">
	<!-- <textarea name="body" cols="45" rows="10" class="formfield" id="body" wrap="wrap"><?php echo $row['description']; ?></textarea> -->
	<?php $sw = new SPAW_Wysiwyg('body',stripslashes($row['description']);
	$sw->show(); ?>
	<br /><br />
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><br /><input type="submit" name="submit" value="<?php  echo $_template['edit_forum']; ?> [Alt-s]" accesskey="s" class="button"> - <input type="submit" name="cancel" class="button" value="<?php  echo $_template['cancel']; ?>" /></td>
</tr>
</table>
</p>
</form>

<?php
	require($_include_path.'footer.inc.php');
?>
