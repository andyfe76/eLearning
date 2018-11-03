<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['submit']) $member = $_POST['member_id'];
if (isset($_GET['member'])) $member = $_GET['member'];//** Security problem ? 

$group_id = $_POST['grp'];
if (isset($_GET['group'])) $group_id=$_GET['group'];//** --- ?

if (isset($_GET['mid'])) {
	$mid = $_GET['mid']; 
}

else if (isset($_POST['mid'])) {
	$mid = $_POST['mid'];
} else {
	$sql = "SELECT member_id FROM members WHERE login='$member'";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$mid = $row[0];
}

//echo $mid;

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

			if ($_POST['password'] == 'xxxxxxxxxxxxxxxx000') {
				$sql = "SELECT password FROM members WHERE member_id=$mid";
				$res = $db->query($sql);
				$row = $res->fetchRow();
				$this_passwd = $row[0];
			} else {
				$this_passwd = hash_pass($_POST['password']);
			}
			
			//***
			if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];	
			
			$sql = "UPDATE members_pers SET first_name='$first_name', last_name='$last_name' WHERE member_id=$mid";
			$result = $db->query($sql);
			if (PEAR::isError($result)) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			} 
//***
			// insert into the db.
			$sql = "UPDATE members SET login='$_POST[login]', password='".$this_passwd."', email='$_POST[email]', modif_date=SYSDATE, custom1='$_POST[custom1]', custom2='$_POST[custom2]', custom3='$_POST[custom3]', custom4='$_POST[custom4]', custom5='$_POST[custom5]', custom6='$_POST[custom6]', custom7='$_POST[custom7]', custom8='$_POST[custom8]', custom9='$_POST[custom9]', custom10='$_POST[custom10]' WHERE member_id=$mid";
			//echo $sql;
			
			$result = $db->query($sql);
			if (PEAR::isError($result)) {
				$errors[]=AT_ERROR_DB_NOT_UPDATED;
				print_errors($errors);
				exit;
			}
			
			Header('Location: ./usermng.php?grp='.$group_id.'&f='.urlencode_feedback(AT_FEEDBACK_PROFILE_UPDATED));
			exit;
		}
} else if ($_POST['cancel']) {
	Header('Location: ./usermng.php?grp='.$group_id.'&f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
	exit;
}


require($_include_path.'cc_html/header.inc.php');

//print_errors($errors);

$sql = "SELECT M.*, G.* FROM members M, mrel_groups G WHERE M.member_id=$mid AND G.member_id=$mid ORDER BY M.member_id";
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
	<input type="hidden" name="grp" value="<?php echo $group_id; ?>">
	<input type="hidden" name="mid" value="<?php echo $mid; ?>">
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
//**** 

$nsql	= "SELECT * FROM members_pers WHERE member_id='$mid'";
$nres	= $db->query($nsql);
$nrow =$nres->fetchRow(DB_FETCHMODE_ASSOC);

?>
<tr>
	<td class="row1" align="right"><label for="first_name"><b><?php echo $_template['first_name']; ?>:</b></label></td>
	<td class="row1" align="left"><input type="text" class="formfield" name="first_name" size="15" maxlength="32" value="<?php echo $nrow['FIRST_NAME']; ?>"></td>
</tr>

<tr>
	<td class="row1" align="right"><label for="last_name"><b><?php echo $_template['last_name']; ?>:</b></label></td>
	<td class="row1" align="left"><input type="text" class="formfield" name="last_name" size="15" maxlength="32" value="<?php echo $nrow['LAST_NAME']; ?>"></td>
</tr>


<?
//****
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
	<td class="row1" align="left"><input id="password" class="formfield" name="password"   type="password" size="15" maxlength="15" value="xxxxxxxxxxxxxxxx000<?php /*echo $mdata['PASSWORD'];*/ ?>" /><br />
	<small class="spacer">&middot; <?php echo $_template['combination']; ?><br />
	&middot; <?php echo $_template['15_max_chars']; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="password2"><b><?php echo $_template['password_again']; ?>:</b></label></td>
	<td class="row1" align="left"><input id="password2" class="formfield" name="password2" type="password" size="15" maxlength="15" value="xxxxxxxxxxxxxxxx000<?php /*echo $mdata['PASSWORD'];*/ ?>" /></td>
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
	// show member status
	echo '<br><b>'.$_template['courses_enrolled_in'].':</b><br>';
	
	$sql	= "SELECT * FROM members WHERE member_id=$mid";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	
	if ($status == 0) $cost_row = 'cost_student';
	else $cost_row = 'cost_instructor';

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
	echo '<tr>';
	echo '<th scope="col" width="200"><small>'.$_template['course_title'].'</small></th>';
	echo '<th scope="col"><small>'.$_template['course_description'].'</small></th>';
	echo '<th scope="col" width="100"><small>'.$_template['course_cost'].'</small></th>';
	echo '</tr>';
	$total_cost = 0;
	
	$sql	= "SELECT E.approved, C.*, R.* FROM course_enrollment E, courses C, roi R WHERE R.course_id=C.course_id AND E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();

	$num = $count0[0];
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			echo '<tr><td class="row1" width="150" valign="top"><small><b>';
			if (($row['APPROVED'] == 'y') || ($row['ACCESSTYPE'] != 'private')) {
				echo '<a href="bounce.php?course='.$row['COURSE_ID'].'">'.$row['TITLE'].'</a>';
			} else {
				echo $row['TITLE'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</small></b></td><td class="row1" valign="top">';

			echo '<small>';
			echo $row['DESCRIPTION'];
			echo '</small></td>';

			echo '<td class="row1" width="100" valign="top" align="right"><small>'.$row[$COST_ROW];
			$total_cost += $row[$COST_ROW];
			echo '</small></td>';
			
			/*echo '<td class="row1" valign="top">';
			echo '<a href="users/remove_course.php?course='.$row['COURSE_ID'].'">'.$_template['remove'].'</a>';
			echo '</td></tr>';*/
			
			if ($count < $num-1) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {
		echo '<tr><td class="row1" colspan="3"><small><i>'.$_template['no_enrolments'].'</i></small></td></tr>';
	}
	echo '<tr><td class="row1" colspan="3" align="right"><small><b>'.$_template['total_cost'].': '.$total_cost.' EURO</small></b><td></tr>';
	echo '</table><br><br>';
	
	if ($status == 1){
		/* instructor cost - tought coursed*/
		echo '<br><b>'.$_template['taught_courses2'].':</b><br>';
		echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
		echo '<tr>';
		echo '<th scope="col" width="200"><small>'.$_template['course_title'].'</small></th>';
		echo '<th scope="col"><small>'.$_template['course_description'].'</small></th>';
		echo '<th scope="col" width="100"><small>'.$_template['instructor_cost'].'</small></th>';
		echo '</tr>';
		$total_cost = 0;
		
		$sql	= "SELECT C.*, R.* FROM courses C, roi R WHERE member_id=$mid AND C.course_id=R.course_id ORDER BY title";
		$result = $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
	
		$num = $count0[0];
		$count = 1;
		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			do {
				echo '<tr>';
				
				echo '<td class="row1" width="150" valign="top"><a href="bounce.php?course='.$row[COURSE_ID].'"><b>'.$row[TITLE].'</b></a></td>';
				echo '<td class="row1"><small>'.$row['DESCRIPTION'];
	
				echo '<br /><br />&middot; '.$_template['access'].': ';
				$pending = '';
				switch ($row['ACCESSTYPE']){
					case 'public':
						echo $_template['public'];
						break;
					case 'protected':
						echo $_template['protected'];
						break;
					case 'private':
						echo $_template['private'];
						$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID] AND approved='n'";
						$c_result = $db->query($sql);
						$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
						$countsql = "SELECT COUNT(*) FROM (".$sql.")";
						$countres = $db->query($countsql);
						$count = $countres->fetchRow();

						$num_rows_c = $count[0];
						if($c_row[0] > 0){
							$pending  = ', '.$c_row[0].' '.$_template['pending_approval2'].'<a href="users/enroll_admin.php?course='.$row[COURSE_ID].'"> '.$_template['pending_approval3'].'</a>';
						}
						break;
				}
				$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				/* minus 1 because the instructor doesn't count */
				echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]-1).' '.$pending.'<br />';
				echo '&middot; '.$_template['created'].': '.$row[CREATED_DATE].'<br />';
	
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				echo '&middot; '.$_template['logins'];
				if ($row['ACCESSTYPE'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[COURSE_ID].SEP.'a='.$row['ACCESSTYPE'].'">'.$_template['details'].'</a><br />';
	
				echo '</small></td>';
	
				echo '<td class="row1" valign="top"><small>';
				echo $row[$COST_ROW];
				$total_cost += $row[$COST_ROW];
				echo '</small></td>';
				echo '</tr>';
	
				if ($count < $num) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
			} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		} else {
	
			echo '<tr><td class="row1" colspan="3"><i>'.$_template['not_teacher'].'</i></td></tr>';
		}
		echo '<tr><td class="row1" colspan="3" align="right"><small><b>'.$_template['total_cost'].': '.$total_cost.' EURO</small></b><td></tr>';
		echo '</table>';
	}

	/* Show test results for every course enrolled into */
	echo '<b>'.$_template['test_results'].'</b><br>';
	$sql	= "SELECT E.approved, C.*, R.* FROM course_enrollment E, courses C, roi R WHERE R.course_id=C.course_id AND E.member_id=$mid AND E.member_id<>C.member_id AND E.course_id=C.course_id ORDER BY C.title";
	$result_c = $db->query($sql);

	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count = $countres->fetchRow();

	$num = $count[0];
	if ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			/*echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
			echo '<tr><td class="row1" width="150" valign="top"><b>';
			if (($row_c['APPROVED'] == 'y') || ($row_c['ACCESSTYPE'] != 'private')) {
				echo '<a href="bounce.php?course='.$row_c['COURSE_ID'].'">'.$row_c['TITLE'].'</a>';
			} else {
				echo $row_c['TITLE'].' <small>'.$_template['pending_approval'].'</small>';
			}
			echo '</b></td></tr></table>';*/
			$course_id = $row_c['COURSE_ID'];

			$sql	= "SELECT T.title, T.course_id, R.* FROM tests T, tests_results R, tests_questions Q WHERE Q.test_id=T.test_id AND R.member_id=$mid AND R.test_id=T.test_id AND T.course_id=$course_id ORDER BY R.date_taken";
			//, SUM(Q.weight) AS outof ...  GROUP BY R.result_id 
			$result	= $db->query($sql);
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
			$num_results = $count0[0];

			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$this_course_id=0;
				do {
					$sql = "SELECT SUM(weight) AS outof FROM tests_questions WHERE test_id=$row[TEST_ID]";
					$res_sq = $db->query($sql);
					$row_sq = $res_sq->fetchRow(DB_FETCHMODE_ASSOC);
					if ($this_course_id != $row['COURSE_ID']) {
						if ($this_course_id > 0) {
							echo '</table><br />';
						}
						echo '<br><h2>'.$_template['course_title'].': '.$system_courses[$row['COURSE_ID']]['title'].'</h2>';
						echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%" align="center">';
						echo '<tr>';
						echo '<th scope="col" width="200"><small>'.$_template['title'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['date_taken'].'</small></th>';
						echo '<th scope="col"><small>'.$_template['mark'].'</small></th>';
						//echo '<th scope="col"><small>'.$_template['view_results'].'</small></th>';
						echo '</tr>';
		
						$this_course_id = $row['COURSE_ID'];
						$count =0;
					}
		
					if ($count > 0){
						echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
					}
		
					$count++;
					echo '<tr>';
					echo '<td class="row1"><small><b>'.$row['TITLE'].'</b></small></td>';
					echo '<td class="row1"><small>'.$row['DATE_TAKEN'].'</small></td>';
					echo '<td class="row1" align="right"><small>';
					if ($row['FINAL_SCORE'] == '') {
						echo '<em>'.$_template['unmarked'].'</em>';
					} else {
						echo '<strong>'.$row['FINAL_SCORE'].'</strong>/'.$row_sq['OUTOF'];
					}
					echo '</small></td>';
		
					/*echo '<td class="row1" align="center"><small>';
		
					if ($row['FINAL_SCORE'] != '') {
						echo '<a href="tools/view_results.php?tid='.$row['TEST_ID'].SEP.'rid='.$row['RESULT_ID'].SEP.'tt='.$row['TITLE'].'">'.$_template['view_results'].'</a>';
					} else {
						echo '<em>'.$_template['no_results_yet'].'</em>';
					}
		
					echo '</small></td>';*/
		
					echo '</tr>';
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
				echo '</table>';
			} else {
				// echo '<i>'.$_template['no_results_available'].'</i>';
			}
		} while ($row_c =$result_c->fetchRow(DB_FETCHMODE_ASSOC));
	}
	echo '<br />';


	require ($_include_path.'cc_html/footer.inc.php'); 
?>
