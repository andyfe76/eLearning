<?php


$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['form_login'])
{
	if (($_POST['form_login'] == 'admin') && ($_POST['form_password'] == ADMIN_PASSWORD)) {
		$_SESSION['s_is_super_admin'] = true;
		Header('Location: admin/');
		exit;
	} else {
		$errors[]=AT_ERROR_INVALID_LOGIN;
	}
}

require($_include_path.'cc_html/header.inc.php'); 


?>
	<br /><br />
	<form method="post" action="<?php echo $PHP_SELF; ?>">
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
	<tr>
		<td class="cat" colspan="2"><h4><?php echo $_template['sysadmin_login']; ?></h4></td>
	</tr>
	<tr>
		<td class="row1" align="right"><label for="login"><b><?php echo $_template['login']; ?>:</b></label></td>
		<td class="row1" align="left"><input type="text" class="formfield" name="form_login" id="login" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="pass"><b><?php echo $_template['password']; ?>:</b></label></td>
		<td class="row1" align="left" valign="top"><input type="password" class="formfield" name="form_password" id="pass" /><br /><br /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td align="center" colspan="2" class="row1"><input type="submit" name="submit" class="button" value="<?php echo $_template['login']; ?>" /></td>
	</tr>
	</table> 
	<br /><br />
	</form>

<?php
require($_include_path.'cc_html/footer.inc.php'); 
?>