<?php

	

	$section = 'users';
	$_include_path = '../include/';
	require ($_include_path.'vitals.inc.php');
	require($_include_path.'lib/klore_mail.inc.php');
	
	
	if ((!$_SESSION['c_instructor']) && (!$_SESSION['is_admin']) && (!$_SESSION['group_mng']) && (!$_SESSION['coordinator'])){
		require ($_include_path.'header.inc.php');	
		print_errors(AT_ERROR_ACCESS_DENIED);
		require ($_include_path.'footer.inc.php');
		exit;
	}
	
	if (isset($_POST['cancel'])) {
		Header('Location: usermng.php?grp='.$group);
		exit;
	}

	$sqllic = "SELECT COUNT(*) AS no FROM members";
	$reslic = $db->query($sqllic);
	$rowlic = $reslic->fetchRow(DB_FETCHMODE_ASSOC);
	$no_members = $rowlic['NO'];
	$no_licenses = 1800 - $no_members;
	if ($no_licenses <1) {
		$errors[] = AT_ERROR_USER_LICENSES_LIMIT;
		print_errors($errors);
		exit;
	}


	if (isset($_POST['ok'])) {
		// email check
		if ($_POST['email'] == '') {
			$errors[] = AT_ERROR_EMAIL_MISSING;
		} else if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $_POST['email'])) {
			$errors[] = AT_ERROR_EMAIL_INVALID;
		}
		
		if ($_POST['first_name'] == '') {
			$errors[] = AT_ERROR_FIRST_NAME_MISSING;
		}
		
		if ($_POST['last_name'] == '') {
			$errors[] = AT_ERROR_LAST_NAME_MISSING;
		}
		
		/*$sql = "SELECT * FROM members WHERE email LIKE '$_POST[email]'";
		$result = $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		if ($count0[0] != 0) {
				$valid = 'no';
				$errors[] = AT_ERROR_EMAIL_EXISTS;
		}*/

		/* login name check: */
		if ($_POST['login'] == ''){
			$errors[] = AT_ERROR_LOGIN_NAME_MISSING;
		} else {
			/* check for special characters */
			if (!(eregi("^[a-zA-Z0-9_]([a-zA-Z0-9_])*$", $_POST['login']))){
				$errors[] = AT_ERROR_LOGIN_CHARS;
			}
		}
		$sql = "SELECT member_id FROM members WHERE login='$_POST[login]'";
		$result = $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		if($count0[0] != 0) {
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
		
		/* group check */
		if ($_POST['group_id'] == '') {
			$errors[] = AT_ERROR_GROUP_MISSING;
		}	
		
		/* Category check */
		/* TBC */
		$_POST['login'] = strtolower($_POST['login']);

		if (!$errors) {
			if (($_POST['website']) && (!ereg("://",$_POST['website']))) { 
				$_POST['website'] = "http://".$_POST['website']; 
			}
			
			if ($_POST['website'] == 'http://') { 
				$_POST['website'] = ''; 
			}
			$_POST['postal'] = strtoupper(trim($_POST['postal']));

			
			//***
			//send email !!! -- ToDo : replace with $_template[..]
		$kprenume=$_POST['first_name'];
		$knume=$_POST['last_name'];
					


			$kmessage='<br>

Aici vei gasi programe de instruire
oferite de echipa Sales Training pentru a deveni un bun reprezentant de vanzari!
<p>Pentru a accesa acest sistem ai nevoie de un Utilizator [username] si o Parola
  [password].</p>
<p>Acum tine minte utilizatorul si parola ta:<br>
  Username : <b>'.$_POST['login'].'</b> <br>
  Password : <b>'.$_POST['password'].'</b> <br>
  [elementele de identificare trebuie utilizate intocmai ca in acest mesaj]</p>
<p>La prima accesare sistemul solicita schimbarea parolei. Noua ta parola trebuie
  sa contina litere si cifre si poate avea o lungime de maxim 15 caractere. Aceste
  informatii sunt confidentiale. </p>
<p>Accesul la sistemul  <a href="http://elearning.connex.ro/">Connex e-Learning</a> va fi disponibil pe o perioada determinata
  de timp, aferenta fiecarui curs. Iti recomandam sa salvezi/tiparesti materialul cursului
  inainte de incheierea cursului.</p>
<p>Pentru fiecare curs la care vei fi inscris, vei primi cate un mesaj e-mail
  cu detalii privind perioada de acces si conditiile de absolvire.</p>
<p>Succes la invatat!</p>
<p>Sales Training Team</p>

  <p>
  <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
  </p>

';			
			$subj=$knume.' '.$kprenume.', Bine ai venit in sistemul Connex e-Learning !';
			klore_mail($_POST[email],$subj,$kmessage,'dealer.training@connex.ro');
			
			//***
			$npass=hash_pass($_POST['password']);
			
			/* insert into the db. */
			$m_id = $db->nextId("AUTO_MEMBERS_MEMBER_ID_SEQ");
			
			$prefs = 'a:17:{s:10:"PREF_STACK";a:5:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";}s:14:"PREF_MAIN_MENU";i:1;s:9:"PREF_MENU";i:1;s:19:"PREF_MAIN_MENU_SIDE";i:1;s:8:"PREF_SEQ";i:3;s:8:"PREF_TOC";i:2;s:14:"PREF_SEQ_ICONS";i:0;s:14:"PREF_NAV_ICONS";i:0;s:16:"PREF_LOGIN_ICONS";i:0;s:9:"PREF_FONT";i:0;s:15:"PREF_STYLESHEET";i:0;s:14:"PREF_NUMBERING";i:0;s:13:"PREF_HEADINGS";i:0;s:16:"PREF_BREADCRUMBS";i:1;s:13:"PREF_OVERRIDE";i:0;s:9:"PREF_HELP";i:1;s:14:"PREF_MINI_HELP";i:1;}';
			$sql = "INSERT INTO members VALUES ($m_id,'$_POST[login]','$npass','$_POST[email]',0,'$prefs', SYSDATE, SYSDATE, '$_POST[custom1]', '$_POST[custom2]', '$_POST[custom3]', '$_POST[custom4]', '$_POST[custom5]', '$_POST[custom6]', '$_POST[custom7]', '$_POST[custom8]', '$_POST[custom9]', '$_POST[custom10]')";
			$result = $db->query($sql) ;
			
			
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				echo 'Database error<br>'.$sql;
				exit;
			}
			
			$sql = "INSERT INTO first_login VALUES ($m_id,1)";
			$result = $db->query($sql) ;
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				echo 'Database error<br>'.$sql;
				exit;
			}
			
			$sql = "INSERT INTO members_pers VALUES ($m_id, '$_POST[first_name]', '$_POST[last_name]')";
			$result = $db->query($sql);
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				echo 'Database error<br>'.$sql;
				exit;
			}
			
			$sql	= "INSERT INTO member_cost VALUES ($m_id,0)";//*** 
			$result = $db->query($sql);
			
			$sql 	= "INSERT INTO mrel_groups VALUES ($m_id, 0, $_POST[group_id])";
			$result = $db->query($sql);
			if (!$result) {
				require($_include_path.'basic_html/header.php');
				$error[] = AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				echo 'Group assignment error<br>'.$sql;
				exit;
			}

			if ($_POST['pref'] == 'access') {
				$_SESSION['member_id'] = $m_id;
				save_prefs();
			}

			
			
			
			$feedback[]=AT_FEEDBACK_ADDED_USER;
			/* require($_include_path.'basic_html/header.php');
			print_feedback($feedback);
			require($_include_path.'basic_html/footer.php');*/
			header( 'Location: usermng.php?grp='.$group_id.'&amid='.$m_id );
			exit; 
		}
}

$onload = 'onload="document.form1.first_name.focus();"';
require($_include_path.'cc_html/header.inc.php');

?>

<script language="JavaScript">
function change_categ() {
	document.form1.categ_change.value = "1";
	document.form1.submit();
}
</script>

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
  document.form1.ok.value = "checked";
  document.form1.submit();
 }
}
// -->
</script>


<form method="post" action="<?php echo $PHP_SELF; ?>" name="form1">

<?php

	if (isset($_GET['categ'])) {
		$category = $_GET['categ'];
	}
	if (isset($_GET['grp']) || isset($_POST['group_id'])) {
		$group = $_GET['grp'];
		if ($group == '') $group = $_POST['group_id'];
	} else {
		$errors[] = AT_ERROR_GROUP_MISSING;
		print_errors($errors);
		exit;
	}
	echo '<input type="hidden" name="group_id" value="'.$group.'">';
	//print_errors($errors);
?>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="80%">
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['account_information']; ?>(<?php echo $_template['required']; ?>)</h4></td>
</tr>
<?php
	
	echo '<tr><td class="row1" align="right">';
	echo '<b>'.$_template['first_name'].'</b></td>';
	echo '<td class="row1" align="left">';
	echo '<input type="text" name="first_name" id="first_name" size="24">';
	echo '</td></tr>';
	echo '<tr><td class="row1" align="right">';
	echo '<b>'.$_template['last_name'].'</b></td>';
	echo '<td class="row1" align="left">';
	echo '<input type="text" name="last_name" id="last_name" size="24"';
	echo '</td></tr>';
	
	// auto generate Login / Passwd
	if (!$_POST['login']) {
		$logid = $db->nextId("AUTO_LOGIN_SEQ");
		$_POST['login'] = 'lms'.$logid;
	}
	if (!$_POST['password']) {
		$logpw = $db->nextId("AUTO_PASSWD_SEQ");
		$_POST['password'] = 'Connex'.$logid;
		$_POST['password2'] = 'Connex'.$logid;
	}
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
	$sql = "SELECT * FROM user_custom_fields ORDER BY id";
	$res = $db->query($sql);
	$i =1;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($row['MANDATORY'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$row['NAME'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$_POST['custom'.$i].'"></td>';
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
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" value="'.$_POST['custom'.$i].'" /></td>';
			echo '</tr>';
		}
		$i++;
	}
?>

</table>
<br><br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="" width="80%">
<tr>
	<input type="hidden" name="ok" id="ok" value="">
	<td class="row1" colspan="2" align="center"><input type="button" class="button" value=" <?php echo $_template['submit']; ?> [Alt-s] " accesskey="s"  onClick="checkPassword(document.form1.password.value)" /> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " /></td>
</tr>
</table>
</form>

<?php
	require($_include_path.'cc_html/footer.inc.php');
?>
