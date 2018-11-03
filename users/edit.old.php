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
			$sql = "UPDATE members SET login='$_POST[login]', password='$_POST[password]', email='$_POST[email]', modif_date=SYSDATE, custom1='$_POST[custom1]', custom2='$_POST[custom2]', custom3='$_POST[custom3]', custom4='$_POST[custom4]', custom5='$_POST[custom5]', custom6='$_POST[custom6]', custom7='$_POST[custom7]', custom8='$_POST[custom8]', custom9='$_POST[custom9]', custom10='$_POST[custom10]' WHERE member_id=$_SESSION[member_id]";

			$result = $db->query($sql);
			if (!$result) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			$sql = "UPDATE mrel_groups SET group_id=$_POST[group] WHERE member_id=$_SESSION[member_id]";
			$result = $db->query($sql);

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
$res = $db->query($sql);
if (!res) {
	echo 'DB Error: could not find user profile';
	exit;
}
$mdata =$res->fetchRow(DB_FETCHMODE_ASSOC);
$group_no = $mdata['GROUP_ID'];

$sql = "SELECT * FROM member_groups WHERE group_id=$group_no";
$res = $db->query($sql);
$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
$mcateg = $row['CATEGORY'];
$mgroup = $row['NAME'];

?>
<script language="JavaScript">
<!--
function checkPassword (strng) {
 var error = "";
 var last;
 var isbad;
 last = true;
 isbad=false;
 
 if ((strng.length < 6) || (strng.length > 19)) {
      error = "The password must have at least 6 characters and a maxmimum of 19.\n";
      alert(error);
      last=false;
      isbad=true;
   }
 
 if (!isbad){
 	isbad = true;
 	last = false;
 var letters=new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
 str=strng.toString();
 //str=str.toLowerCase();
 for(i=0;i<=str.length;i++) {
  for(j=0;j<=letters.length;j++) {
   if(str.substring(i,i+1)==letters[j]) {
    isbad=false;
    last=true;
   }
  }
 }
 
 if (isbad) {
  alert("Password must have at least one lowercase letter");
 }
 
 }
 
 if (!isbad){
 isbad=true;
 last = false;
 var numbers=new Array("1","2","3","4","5","6","7","8","9","0");
 str=strng.toString();
 str=str.toLowerCase();
 for(i=0;i<=str.length;i++) {
  for(j=0;j<=numbers.length;j++) {
   if(str.substring(i,i+1)==numbers[j]) {
    isbad=false;
    last=true;
   }
  }
 }
 
 if (isbad) {
  alert("Password must have at least one number.");
 }
 }
 
 if (last){
  //alert('Password checked.');
  document.rform.ok.value = "checked";
  document.rform.submit();
 }
}
// -->
</script>

<form name="rform" id="rform" method="post" action="<?php echo $PHP_SELF; ?>">
<h2><?php   echo $_template['edit_profile']; ?></h2>
<script language="JavaScript">
function change_categ() {
	document.form1.categ_change.value = "1";
	document.form1.submit();
}
</script>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="80%">
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
		$res = $db->query($sql);
		
		echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo '<option value="'.$row['NAME'].'" ';
			if ($category == '') { 
				$category = $row['NAME']; 
				echo 'selected="selected">'.$row['NAME'];
			} else if ($mcateg == $row['NAME']) {
				echo 'selected="selected">'.$row['NAME'];
			} else {
				echo '>'.$row['NAME'];
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
	$res	= $db->query($sql);
?>
	<td class="row1" align="right"><label for="group"><b><?php echo $_template['group']; ?>:</b></label></td>
	<td class="row1" align="left">
<?php
	if ($mdata['status'] >0) {
		echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">'."\n";
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo '<option value="'.$row['GROUP_ID'].'" ';
			if ($group_no == $row['GROUP_ID']) {
				echo 'selected="selected">'.$row['NAME'];
			} else {
				echo '>'.$row['NAME'];
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
	<td class="row1" align="left"><input id="login" class="formfield" name="login" type="text" maxlength="20" size="15" value="<?php echo $mdata['LOGIN']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['contain_only']; ?><br />
	&middot; <?php echo $_template['20_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="password"><b><?php echo $_template['password']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password" class="formfield" name="password" type="password" size="15" maxlength="15" value="<?php echo $mdata['PASSWORD']; ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['combination']; ?><br />
	&middot; <?php echo $_template['15_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="password2"><b><?php echo $_template['password_again']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password2" class="formfield" name="password2" type="password" size="15" maxlength="15" value="<?php echo $mdata['PASSWORD']; ?>" /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="email"><b><?php echo $_template['email_address']; ?></b></label></td>
	<td class="row1" align="left"><input id="email" class="formfield" name="email" type="text" size="30" maxlength="60" value="<?php echo $mdata['EMAIL']; ?>" /><br /><br /></td>
</tr>
<?php
	$sql = "SELECT * FROM user_custom_fields ORDER BY id";
	$res = $db->query($sql);
	$i =1;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($row['MANDATORY'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$row['NAME'].' :</b></td>';
			$cindex = 'CUSTOM'.$i;
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$mdata[$cindex].'"></td>';
			echo '</tr>';
		}
		$i++;
	}
?>
</table>
<br><br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="80%">
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['personal_information'].' ('.$_template['optional'].')'; ?> </h4></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	$sql = "SELECT * FROM user_custom_fields ORDER BY id";
	$res = $db->query($sql);
	$i =1;
	while($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (($row['MANDATORY'] ==0) && ($row['NAME'] <>'')) {
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$row['NAME'].' :</b></td>';
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" value="'.$mdata['CUSTOM'.$i].'" /></td>';
			echo '</tr>';
		}
		$i++;
	}
?>

<TABLE>
<br><br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="80%">
<tr>
	<td class="row1" align="center" colspan="2">
	<input type="hidden" name="ok" id="ok" value="">
	<input type="button" class="button" value=" <?php echo $_template['submit']; ?> [Alt-s] " accesskey="s" onClick="checkPassword(document.rform.password.value)"> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</form>
<?php
	require ($_include_path.'cc_html/footer.inc.php'); 
?>
