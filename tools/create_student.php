<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = 'Tools';
$_section[0][1] = 'tools/';
$_section[1][0] = 'Create Student';



if ($new_user)
{
	$sql = "SELECT * FROM members WHERE login='$form_login'";
	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	if ($count0[0] == 1)
	{
		$error = 'An account with that login already exists.';
	} else {
		/* login name rules should go here. what is a valid login? */
		$sql = "INSERT INTO members VALUES (0,'$form_login','$form_password',0)";
		$result = $db->query($sql);
		$success = true;
	}
}

require($_include_path.'header.inc.php');
?>
<h2>Tools</h2>
<h2>New Student</h2>
<br />
<?php
if ($error)
{
	echo $error;
}
if ($success)
{
	echo 'New account created successfully.';
}

?>
<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="new_user" value="true">
	Login: <input type="text" name="form_login" class="formfield"><br />
	Password: <input type="text" name="form_password" class="formfield"><br />
	<input type="submit" name="submit" value="Create" class="button">
</form>

<?php
require($_include_path.'footer.inc.php');
?>
