<?php

$section = 'users';
$_include_path = 'include/';
require($_include_path.'vitals.inc.php');



$member_id = $_SESSION['member_id'];
$mid=$member_id;
if ($_POST['ok']){
		$error = '';

		// password check
		if ($password == '') { 
			$errors[] =AT_ERROR_PASSWORD_MISSING;
		}
		// check for valid passwords
		if ($password != $password2){
			$valid= 'no';
			$errors[]=AT_ERROR_PASSWORD_MISMATCH;
		}

		if (!$errors) {
			
			// insert into the db.
			$sql = "UPDATE members SET password='".hash_pass($_POST['password'])."', modif_date=SYSDATE WHERE member_id=$mid";
						
			$result = $db->query($sql);
			if (PEAR::isError($result)) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			$sql="UPDATE first_login SET ln=0 WHERE m_id=$mid";
			
			$result = $db->query($sql);
			if (PEAR::isError($result)) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			Header('Location: ./bounce.php?course='.$_POST['form_course_id'].'&f='.urlencode_feedback(AT_FEEDBACK_PROFILE_UPDATED));
			exit;
		}
} else if ($_POST['cancel']) {
		Header('Location: ./login.php');
	exit;
}


require($_include_path.'basic_html/header.php');
print_errors($errors);


$sql = "SELECT M.*, G.* FROM members M, mrel_groups G WHERE M.member_id=$member_id AND G.member_id=$member_id ORDER BY M.member_id";
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

<script language="JavaScript">
function change_categ() {
	document.form1.categ_change.value = "1";
	document.form1.submit();
}
</script>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="516">
<tr><td>
<h2><?php   echo $_template['edit_profile']; ?></h2>
</td></tr>
<tr>
	<td class="cat" colspan="2"><font size="+2" color="#FF0000"><?php echo $_template['please_change_password']; ?></font><br><br>
	<h4><?php echo $_template['account_information']; ?>(<?php echo $_template['required']; ?>)</h4></td>
</tr>
<tr>
	<td class="row1" align="right"><label for="category"><b><?php echo $_template['category']; ?>:</b></label></td>
	<td class="row1" align="left">
	<input type="hidden" name="categ_change">
<?php

		echo "\n".'&nbsp;'.$mcateg.'&nbsp;'."\n".'</td>';

?>
</tr>
<tr>

	<td class="row1" align="right"><label for="group"><b><?php echo $_template['group']; ?>:</b></label></td>
	<td class="row1" align="left">
<?php
			echo "\n".'&nbsp;'.$mgroup.'&nbsp;'."\n".'</td>';

?>
</tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="password"><b><?php echo $_template['password']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password" class="formfield" name="password" type="password" size="15" maxlength="15" value="<?php /*echo $mdata['PASSWORD'];*/ ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['combination']; ?><br />
	&middot; <?php echo $_template['15_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="password2"><b><?php echo $_template['password_again']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password2" class="formfield" name="password2" type="password" size="15" maxlength="15" value="<?php /*echo $mdata['PASSWORD'];*/ ?>" /></td>
</tr>
</table>
<br><br>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="516">
<tr>
	<td class="row1" align="center" colspan="2">
	<input type="hidden" name="ok" id="ok" value="">
	<input type="button" class="button" value=" <?php echo $_template['submit']; ?> [Alt-s] " accesskey="s" onClick="checkPassword(document.rform.password.value)"></td>
</tr>
</table>
</form>
<?php
	require ($_include_path.'cc_html/footer.inc.php'); 
?>
