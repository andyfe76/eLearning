<?php


	$section = 'users';
	$page	 = 'register';
	$_public	= true;
	$_include_path = 'include/';
	require ($_include_path.'vitals.inc.php');

	if (isset($_POST['cancel'])) {
		Header('Location: ./about.php');
		exit;
	}

	if (isset($_POST['ok'])) {
		// email check
		if ($_POST['email'] == '') {
			$errors[] = AT_ERROR_EMAIL_MISSING;
		} else if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $_POST['email'])) {
			$errors[] = AT_ERROR_EMAIL_INVALID;
		}
		$result = mysql_query("SELECT * FROM members WHERE email LIKE '$_POST[email]'",$db);
		if (mysql_num_rows($result) != 0) {
				$valid = 'no';
				$errors[] = AT_ERROR_EMAIL_EXISTS;
		}

		/* login name check: */
		if ($_POST['login'] == ''){
			$errors[] = AT_ERROR_LOGIN_NAME_MISSING;
		} else {
			/* check for special characters */
			if (!(eregi("^[a-zA-Z0-9_]([a-zA-Z0-9_])*$", $_POST['login']))){
				$errors[] = AT_ERROR_LOGIN_CHARS;
			}
		}
		$result = mysql_query("SELECT * FROM members WHERE login='$_POST[login]'",$db);
		if(mysql_num_rows($result) != 0) {
			$valid = 'no';
			$errors[] = AT_ERROR_LOGIN_EXISTS;
		}

		/* password check:	*/
		if ($_POST['password'] == '') { 
			$errors[] = AT_ERROR_PASSWORD_MISSING;
		} else {
			// check for valid passwords
			if ($_POST['password'] != $_POST['password2']){
				$valid= 'no';
				$errors[] = AT_ERROR_PASSWORD_MISMATCH;
			}
		}
		
		/* Group check */
		if ($_POST['group'] == ''){
			$errors[] = AT_ERROR_GROUP_MISSING;
		}
		
		/* Category check */
		/* TBC */
		
		$_POST['login'] = strtolower($_POST['login']);

		if (!$errors && (!$_POST['categ_change'])) {
			if (($_POST['website']) && (!ereg("://",$_POST['website']))) { 
				$_POST['website'] = "http://".$_POST['website']; 
			}
			
			if ($_POST['website'] == 'http://') { 
				$_POST['website'] = ''; 
			}
			$_POST['postal'] = strtoupper(trim($_POST['postal']));

			/* insert into the db. (the last 0 for status) */
			$sql = "INSERT INTO members VALUES (0,'$_POST[login]','$_POST[password]','$_POST[email]',0,'', NOW(), NOW(), '$_POST[custom1]', '$_POST[custom2]', '$_POST[custom3]', '$_POST[custom4]', '$_POST[custom5]', '$_POST[custom6]', '$_POST[custom7]', '$_POST[custom8]', '$_POST[custom9]', '$_POST[custom10]')";
			$result = mysql_query($sql);
			$m_id = mysql_insert_id();
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			if ($_POST['pref'] == 'access') {
				$_SESSION['member_id'] = $m_id;
				save_prefs();
			}

			$sql = "INSERT INTO member_cost VALUES ($m_id, 0)";
			$result = mysql_query($sql);
			
			$sql = "INSERT INTO mrel_groups VALUES ($m_id, NULL, $_POST[group])";
			$result = mysql_query($sql);
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			$feedback[]=AT_FEEDBACK_REG_THANKS;
			require($_include_path.'basic_html/header.php');
			print_feedback($feedback);
			require($_include_path.'basic_html/footer.php');
			exit;
		}
}


$onload = 'onload="document.form1.login.focus();"';
require($_include_path.'basic_html/header.php');
session_destroy();

?>
<form method="post" action="<?php echo $PHP_SELF; ?>" name="form1">

<?php
echo '<TR><TD COLSPAN="5"><br>';

?>
<h2><?php echo SITE_NAME; ?>
<?php echo '<br>'.$_template['registration'];  ?><br></h2>
<?php print_errors($errors); ?>
<script language="JavaScript">
function change_categ() {
	document.form1.categ_change.value = "1";
	document.form1.submit();
}
</script>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['account_information']; ?>(<?php echo $_template['required']; ?>)</h4></td>
</tr>
<tr>
	<td class="row1" align="right"><label for="category"><b><?php echo $_template['category']; ?>:</b></label></td>
	<td class="row1" align="left">
	<input type="hidden" name="categ_change">
<?php
	$sql = "SELECT name FROM member_categ";
	$res = mysql_query($sql, $db);
	
	echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
	while ($row = mysql_fetch_array($res)) {
		echo '<option value="'.$row['name'].'"';
		if ($category == '') { 
			$category = $row['name']; 
			echo 'selected="selected">'.$row['name'];
		} else if ($category == $row['name']) {
			echo 'selected="selected">'.$row['name'];
		} else {
			echo '>'.$row['name'];
		}
		echo '</option>'."\n";
	}
	echo '</select>&nbsp;'."\n";
	echo '</td>';
?>
</tr>
<tr>
<?php
	$sql	= "SELECT * FROM member_groups WHERE category='$category'";
	$res	= mysql_query($sql, $db);
?>
	<td class="row1" align="right"><label for="group"><b><?php echo $_template['group']; ?>:</b></label></td>
	<td class="row1" align="left">
<?php
	echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">'."\n";
	while ($row = mysql_fetch_array($res)) {
		echo '<option value="'.$row['group_id'].'">'.$row['name'];
		echo '</option>'."\n";
	}
	echo '</select>&nbsp;'."\n";
	echo '</td>';
	echo '</tr>';
?>
<tr>
	<td class="row1" align="right" valign="top"><label for="login"><b><?php echo $_template['login']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="login" class="formfield" name="login" type="text" maxlength="20" size="15" value="<?php echo $_POST['login']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['contain_only']; ?><br />
	&middot; <?php echo $_template['20_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="password"><b><?php echo $_template['password']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password" class="formfield" name="password" type="password" size="15" maxlength="15" value="<?php echo $_POST['password']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['combination']; ?><br />
	&middot; <?php echo $_template['15_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="password2"><b><?php echo $_template['password_again']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password2" class="formfield" name="password2" type="password" size="15" maxlength="15" value="<?php echo $_POST['password2']; ?>" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="email"><b><?php echo $_template['email_address']; ?></b></label></td>
	<td class="row1" align="left"><input id="email" class="formfield" name="email" type="text" size="30" maxlength="60" value="<?php echo $_POST['email']; ?>" /><br /><br /></td>
</tr>
<?php
	$sql = "SELECT * FROM user_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while ($row = mysql_fetch_array($res)) {
		if ($row['mandatory'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$row['name'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$_POST['custom'.$i].'"></td>';
			echo '</tr>';
		}
		$i++;
	}
?>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['personal_information'].' ('.$_template['optional'].')'; ?> </h4></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	$sql = "SELECT * FROM user_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while($row = mysql_fetch_array($res)) {
		if (($row['mandatory'] ==0) && ($row['name'] <>'')) {
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$row['name'].' :</b></td>';
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" value="'.$_POST['custom'.$i].'" /></td>';
			echo '</tr>';
		}
		$i++;
	}
?>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2" align="center"><input type="submit" class="button" value=" <?php echo $_template['submit']; ?> [Alt-s] " name="ok" accesskey="s" /> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</form>

<?php
	require($_include_path.'basic_html/footer.php');
?>
