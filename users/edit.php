<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['ok']){
		$error = '';

		// email check
		if ($_POST['email'] == '') {
			$errors[]=AT_ERROR_EMAIL_MISSING;
		} else {
			if(!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $_POST['email']))
			{
				$errors[]=AT_ERROR_EMAIL_INVALID;
			}
		}

		// password check
		if ($password == '') { 
			$errors[] =AT_ERROR_PASSWORD_MISSING;
		}
		// check for valid passwords
		if ($password != $password2){
			$valid= 'no';
			$errors[]=AT_ERROR_PASSWORD_MISMATCH;
		}
		
		$login = strtolower($_POST['login']);
		if (!$errors) {
			if (($_POST['web_site']) && (!ereg('://',$_POST['web_site']))) { $_POST['web_site'] = 'http://'.$_POST['web_site']; }
			if ($_POST['web_site'] == 'http://') { $_POST['web_site'] = ''; }

			// insert into the db.
			$sql = "UPDATE members SET login='$_POST[login]', password='$_POST[password]', email='$_POST[email]', modif_date=NOW(), custom1='$_POST[custom1]', custom2='$_POST[custom2]', custom3='$_POST[custom3]', custom4='$_POST[custom4]', custom5='$_POST[custom5]', custom6='$_POST[custom6]', custom7='$_POST[custom7]', custom8='$_POST[custom8]', custom9='$_POST[custom9]', custom10='$_POST[custom10]' WHERE member_id=$_SESSION[member_id]";

			$result = mysql_query($sql);
			if (!$result) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			$sql = "UPDATE mrel_groups SET group_id=$_POST[group] WHERE member_id=$_SESSION[member_id]";
			$result = mysql_query($sql);

			Header('Location: ./index.php?f='.urlencode_feedback(AT_FEEDBACK_PROFILE_UPDATED));
			exit;
		}
} else if ($_POST['cancel']) {
	Header('Location: ./index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
	exit;
}


require($_include_path.'cc_html/header.inc.php');

print_errors($errors);

$sql = "SELECT M.*, G.* FROM members M, mrel_groups G WHERE M.member_id=$_SESSION[member_id] AND G.member_id=$_SESSION[member_id] ORDER BY M.member_id";
$res = mysql_query($sql, $db);
$mdata = mysql_fetch_array($res);
$group_no = $mdata['group_id'];
$sql = "SELECT * FROM member_groups WHERE group_id=$group_no";
$res = mysql_query($sql, $db);
$row = mysql_fetch_array($res);
$mcateg = $row['category'];
$mgroup = $row['name'];

?>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<h2><?php   echo $_template['edit_profile']; ?></h2>
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
	if ($mdata['status'] >0) {
		$sql = "SELECT name FROM member_categ";
		$res = mysql_query($sql, $db);
		
		echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
		while ($row = mysql_fetch_array($res)) {
			echo '<option value="'.$row['name'].'" ';
			if ($category == '') { 
				$category = $row['name']; 
				echo 'selected="selected">'.$row['name'];
			} else if ($mcateg == $row['name']) {
				echo 'selected="selected">'.$row['name'];
			} else {
				echo '>'.$row['name'];
			}
			echo '</option>'."\n";
		}
		echo '</select>&nbsp;'."\n";
		echo '</td>';
	} else {
		/* STUDENTS ARE NOT ALLOWED TO CHANGE THEIR CATEGORY OR GROUP */
		echo "\n".'&nbsp;'.$mcateg.'&nbsp;'."\n".'</td>';
	}
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
	if ($mdata['status'] >0) {
		echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">'."\n";
		while ($row = mysql_fetch_array($res)) {
			echo '<option value="'.$row['group_id'].'" ';
			if ($group_no == $row['group_id']) {
				echo 'selected="selected">'.$row['name'];
			} else {
				echo '>'.$row['name'];
			}
			
			echo '</option>'."\n";
		}
		echo '</select>&nbsp;'."\n";
		echo '</td>';
	} else {
		/* STUDENTS ARE NOT ALLOWED TO CHANGE THEIR CATEGORY OR GROUP */
		echo "\n".'<input type="hidden" name="group" value="'. $mdata['group_id'].'">';
		echo "\n".'&nbsp;'.$mgroup.'&nbsp;'."\n".'</td>';
	}
?>
</tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="login"><b><?php echo $_template['login']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="login" class="formfield" name="login" type="text" maxlength="20" size="15" value="<?php echo $mdata['login']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['contain_only']; ?><br />
	&middot; <?php echo $_template['20_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="password"><b><?php echo $_template['password']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password" class="formfield" name="password" type="password" size="15" maxlength="15" value="<?php echo $mdata['password']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['combination']; ?><br />
	&middot; <?php echo $_template['15_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="password2"><b><?php echo $_template['password_again']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password2" class="formfield" name="password2" type="password" size="15" maxlength="15" value="<?php echo $mdata['password']; ?>" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="email"><b><?php echo $_template['email_address']; ?></b></label></td>
	<td class="row1" align="left"><input id="email" class="formfield" name="email" type="text" size="30" maxlength="60" value="<?php echo $mdata['email']; ?>" /><br /><br /></td>
</tr>
<?php
	$sql = "SELECT * FROM user_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while ($row = mysql_fetch_array($res)) {
		if ($row['mandatory'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$row['name'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$mdata['custom'.$i].'"></td>';
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
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" value="'.$mdata['custom'.$i].'" /></td>';
			echo '</tr>';
		}
		$i++;
	}
?>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="center" colspan="2"><input type="submit" class="button" value=" <?php echo $_template['submit']; ?> [Alt-s] " name="ok" accesskey="s" /> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</form>
<?php
	require ($_include_path.'cc_html/footer.inc.php'); 
?>
