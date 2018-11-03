<?php

if (!$_SESSION['valid_user']) {
	$errors[]=AT_ERROR_LOGIN_TO_POST;
	print_errors($errors);
	return;
}

print_errors($errors);


if ($_POST['submit']) {
	$subject	= $_POST['subject'];
	$body		= $_POST['body'];
	$parent_id	= $_POST['parent_id'];
	$parent_name	= $_POST['parent_name'];
} else if ($_GET['reply'] != '') {
	/*
	$body = "\n\n\n\n".'[reply][b]In reply to: '.$saved_post['login'].'[/b]'."\n";
	if (strlen($saved_post['body']) > 200) {
		$body .= substr($saved_post['body'], 0, 200).'...';
	} else {
		$body .= $saved_post['body'];
	}
	$body .= "\n".'[op]forum/view.php?fid='.$fid.SEP.'pid='.$parent_id.SEP.'page='.$page.'#'.$saved_post['post_id'];
	$body .= '[/op][/reply]';
	*/
	$subject = $saved_post['subject'];

	if (substr($subject, 0, 3) != 'Re:') {
		$subject = 'Re: '.$subject;
	}
}

?>
<form action="forum/new_thread.php" method="post" name="form">
<input name="parent_id" type="hidden" value="<?php echo $parent_id; ?>" />
<input name="fid" type="hidden" value="<?php echo $fid; ?>" />
<input name="reply" type="hidden" value="<?php echo $_GET['reply']; ?>" />
<input name="page" type="hidden" value="<?php echo $_GET['page']; ?>" />
<input name="parent_name" type="hidden" value="<?php echo $parent_name; ?>" />
<br />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="450">
<tr>
	<th colspan="2" class="left"><?php echo $_template['add_post']; ?></th>
</tr>
<tr>
	<td class="row1" align="right"><a name="post"></a><label for="subject"><b><?php echo $_template['subject']; ?>:</b></label></td>
	<td class="row1"><input class="formfield" style="font-size: 8pt" maxlength="80" name="subject" size="36" value="<?php echo $subject; ?>" id="subject" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="body"><b><?php echo $_template['body']; ?>:</b></label></td>
	<td class="row1">
	<!-- <textarea class="formfield" style="font-size: 8pt" cols="45" name="body" rows="10" id="body"><?php // echo $body; ?></textarea> -->
	<?php $sw = new SPAW_Wysiwyg('body',stripslashes($body));
	$sw->show(); ?>
	<br />
	<!-- <small class="spacer">&middot;<?php //echo $_template['forum_links']; ?><br />
	&middot; <?php //echo $_template['forum_email_links']; ?><br />
	&middot; <?php //echo $_template['forum_html_disabled']; ?></small> -->
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	if ($_GET['reply']) {
?>
<tr>
	<td class="row1" align="right" valign="top"><label for="body"><b><?php echo $_template['forum_reply_to']; ?>:</b></label></td>
	<td class="row1">
	<textarea class="formfield" style="font-size: 8pt" cols="45" name="replytext" rows="5" /><?php echo $saved_post['body']; ?></textarea> 
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	} /* end if ($_GET['reply']) */
?>
<!-- <tr>
	<td class="row1" colspan="2"><a href="<?php // echo substr($_my_uri, 0, strlen($_my_uri)-1); ?>#jumpcodes" title="<?php //echo $_template['jump_codes']; ?>"><img src="images/clr.gif" height="1" width="1" alt="<?php ///echo $_template['jump_codes']; ?>" border="0" /></a><?php //require($_include_path.'html/code_picker.inc.php'); ?></td>
</tr> -->
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><a name="jumpcodes"></a><?php
	if (!$subscribed) {
	?><input type="checkbox" name="subscribe" value="1" id="sub" /><label for="sub"><?php echo $_template['thread_subscribe']; ?></label><?php } else {
	echo $_template['thread_already_subscribed'];
	}?><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><input name="submit" class="button" accesskey="s" type="submit" value=" <?php echo $_template['post']; ?> [Alt-s]" /></td>
</tr>
</table>

</form>
