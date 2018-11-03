<?php

$section = 'users';
$page	 = 'password';
$_public	= true;
$_include_path = 'include/';
require ($_include_path.'vitals.inc.php');
require ($_include_path.'lib/klore_mail.inc.php');

	if ($_POST['cancel']) {
		Header('Location: about.php');
		exit;
	}

if ($form_password_reminder)
{
	$sql	= "SELECT login, password, email FROM members WHERE email='$form_email'";
	$result = mysql_query($sql,$db);
	if (mysql_num_rows($result) == 0)
	{
		$errors[]=AT_ERROR_EMAIL_NOT_FOUND;
		
	} else {
		$row = mysql_fetch_array($result);
		$r_login = $row['login'];	
		$r_passwd= $row['password'];
		$r_email = $row['email'];

		$message = $_template['hello'].','."\n".$_template['password_request'].' '.$HTTP_SERVER_VARS["REMOTE_ADDR"].'. '.$_template['password_request2'].'.'."\n";
		$message .= $_template['login'].': '.$r_login."\n".$_template['password'].': '.$r_passwd."\n";
		klore_mail($r_email, 'klore '.$_template['password_reminder'], $message, ADMIN_EMAIL);
		$success = true;
	}
}

require($_include_path.'basic_html/header.php');

echo '<TR><TD COLSPAN="5">';
?>
<h2><?php //echo $_template['password_reminder'];  ?></h2>
<?php
		if ($errors && !$success) {
			print_errors($errors);
		}
?>
<form action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="form_password_reminder" value="true" />

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" width="60%" summary="">
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['password_reminder']; ?></h4></td>
</tr>
<?php
	if (!$success) {
?>
<tr>
	<td class="row1" align="left" colspan="2"><?php echo $_template['password_blurb']; ?><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td valign="top" align="right" class="row1"><label for="email"><b><?php echo $_template['email_address']; ?></b></label></td>
	<td valign="top" align="left" class="row1"><input type="text" class="formfield" name="form_email" id="email" /><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td align="center" colspan="2" class="row1"><input type="submit" name="submit" class="button" value="<?php echo $_template['submit']; ?>" /> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " /></td>
</tr>
<?php
	} else {
?>
<tr>
	<td align="center" colspan="2"><?php echo $_template['password_success']; ?></td>
</tr>
<?php
	}
?>
</table>
</form>
<?php
	require($_include_path.'basic_html/footer.php');
?>
