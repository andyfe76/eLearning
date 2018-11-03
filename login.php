<?php

$section = 'users';
$page	 = 'login';
$_public	= true;
$_include_path = 'include/';
require ($_include_path.'vitals.inc.php');

if (isset($_POST['cancel'])) {
	Header('Location: about.php');
	exit;
}

// check if we have a cookie
if (isset($_COOKIE['ATLogin'])) {
	$cookie_login = $_COOKIE['ATLogin'];
}
if (isset($_COOKIE['ATPass'])) {
	$cookie_pass  = $_COOKIE['ATPass'];
}

if (isset($cookie_login, $cookie_pass) && !isset($_POST['submit_login'])) {
	
	/* auto login */
	$this_login		= $cookie_login;
	$this_password	= $cookie_pass;
	$auto_login		= 1;
	$used_cookie	= true;
	
} else if (isset($_POST['submit_login'])) {
	/* form post login */
	$this_login		= $_POST['form_login'];
	$this_password  = hash_pass($_POST['form_password']);
	$auto_login		= intval($_POST['auto']);
	$used_cookie	= false;
}


if (isset($this_login, $this_password)) {
	if ($_GET['course'] != '') {
		$_POST['form_course_id'] = intval($_GET['course']);
	} else {
		$_POST['form_course_id'] = intval($_POST['form_course_id']);
	}

	if ($used_cookie) {
		// check if that cookie is valid
		$sql = "SELECT member_id, login, preferences, TO_CHAR(creation_date, 'DD/MM/YYYY HH24:MM:SS') AS creation_date, TO_CHAR(modif_date, 'DD/MM/YYYY HH24:MM:SS') as modif_date, status, password AS pass FROM members WHERE login='$this_login' AND password='$this_password'";

	} else {
		$sql = "SELECT member_id, login, preferences, TO_CHAR(creation_date, 'DD/MM/YYYY HH24:MM:SS') AS creation_date, TO_CHAR(modif_date, 'DD/MM/YYYY HH24:MM:SS') as modif_date, status, password AS pass FROM members WHERE login='$this_login' AND password='$this_password'";
	}

	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count = $countres->fetchRow();
	if ($count[0] == 1) {
		$row =$result->fetchRow(DB_FETCHMODE_ASSOC);
				
		//***
		
		$sql="DELETE FROM LOGIN_ATEMPTS WHERE M_ID='$row[MEMBER_ID]'";
		$db->query($sql);
		//***
		$_SESSION['login']		= $row['LOGIN'];
		$_SESSION['valid_user'] = true;
		$_SESSION['member_id']	= intval($row['MEMBER_ID']);
		$_SESSION['prefs']		= unserialize(stripslashes($row['PREFERENCES']));
		$_SESSION['is_guest']	= 0;
		$_SESSION['status'] 	= $row['STATUS'];
		if ($row['STATUS'] == STATUS_STUDENT)	{
			$_SESSION['c_instructor'] = false;
			$_SESSION['is_admin'] = false;
			$_SESSION['is_super_admin'] = false;
			
		} else if ($row['STATUS'] == STATUS_TRAINER) {
			$_SESSION['c_instructor'] = true;
			$_SESSION['is_admin'] = true;
			$_SESSION['is_super_admin'] = false;
			
		} else if ($row['STATUS'] == STATUS_GROUP_MANAGER){
			$_SESSION['is_admin'] = false;
			$_SESSION['group_mng'] = true;
			$_SESSION['is_super_admin'] = false;
			
		}else if ($row['STATUS'] == STATUS_COORDINATOR) {
			$_SESSION['is_admin'] = false;
			$_SESSION['coordinator'] = true;
			$_SESSION['is_super_admin'] = false;
			
		} else if ($row['STATUS'] == STATUS_ADMINISTRATOR){
			$_SESSION['c_instructor'] =true;
			$_SESSION['coordinator'] =true;
			$_SESSION['is_admin'] = true;
			$_SESSION['is_super_admin'] = true;
		} else if ($row['STATUS'] == STATUS_TRAINING_MANAGER) {
			$_SESSION['c_instructor'] =true;
			$_SESSION['coordinator'] =false;
			$_SESSION['is_admin'] = true;
			$_SESSION['is_super_admin'] = true;
		}

		if ($auto_login == 1) {
			$parts = parse_url($_base_href);
			// update the cookie.. increment to another 2 days
			$cookie_expire = time()+172800; // two days
			setcookie('ATLogin', $this_login, $cookie_expire, $parts['path'], $parts['host'], 0);
			setcookie('ATPass',  $row['PASS'],  $cookie_expire, $parts['path'], $parts['host'], 0);
		}
		
		$sql = "SELECT stime FROM loggedin WHERE member_id=$_SESSION[member_id]";
		$resli = $db->query($sql);
		$rowli = $resli->fetchRow(DB_FETCHMODE_ASSOC);
		$last_time = strtotime($rowli['STIME']);
		$expiry_time = strtotime("-30 sec");
		if ($last_time < $expiry_time) {
			//echo 'DEBUG: deleting ...';
			$sql_e = "DELETE FROM loggedin WHERE member_id=$_SESSION[member_id]";
			$res = $db->query($sql_e);
		}
		/*echo $sql_e.'<br>';
		echo date('r', $expiry_time).'<br>';
		echo date('r', $last_time); */
		//exit; 
		
		
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count = $countres->fetchRow();
		if ($count[0] > 0) {
			$errors[] = AT_ERROR_USER_ALREADY_LOGGEDIN;
		} else {
			$server_key = md5($REMOTE_ADDR.time().rand());
			$time = time();

			//*** First Login ***//
			
			$l_sql="SELECT ln FROM first_login WHERE m_id=$_SESSION[member_id]";

			$l_result=$db->query($l_sql);
			$l_row = $l_result->fetchRow();

			if ($l_row[0]==1) {
				
				
			$sql = "INSERT INTO loggedin VALUES ($_SESSION[member_id], '".$HTTP_SERVER_VARS[REMOTE_ADDR]."', '$server_key', SYSDATE)"; 
			$res = $db->query($sql);
			
			Header('Location: ./bounce.php?newpass=1');
			exit;				
			}
			//*** ---------- ***//
					
			$pass = passwd_expired($row['STATUS'], $row['CREATION_DATE'], $row['MODIF_DATE']);
			if ( $pass == AT_PASSWORD_EXPIRED){
				Header('Location: ./bounce.php?course='.$_POST['form_course_id'].'&pexp=1');
			} else if ( $pass > 0 ) {
				$sql = "INSERT INTO loggedin VALUES ($_SESSION[member_id], '".$HTTP_SERVER_VARS[REMOTE_ADDR]."', '$server_key', SYSDATE)"; 
				$res = $db->query($sql);
				if (PEAR::isError($res)) {
					print_r($res);
					exit;
				}
				Header('Location: ./bounce.php?course='.$_POST['form_course_id'].SEP.'f='.AT_FEEDBACK_PASSWORD_EXP);
			} else {
				$sql = "INSERT INTO loggedin VALUES ($_SESSION[member_id], '".$HTTP_SERVER_VARS[REMOTE_ADDR]."', '$server_key', SYSDATE)"; 
				$res = $db->query($sql);
				if (PEAR::isError($res)) {
					print_r($res);
					exit;
				}
				Header('Location: ./bounce.php?course='.$_POST['form_course_id']);
			}
			exit;
		}
	} else {
		//***
		
		$errors[] = AT_ERROR_INVALID_LOGIN;
		
		
		$sql = "SELECT member_id FROM members WHERE login='$this_login'";
		$result=$db->query($sql);
		if ($result) 
		
			{//echo "<br> - User Exists ...";
				$mrow = $result->fetchRow();
				
				$m_id=$mrow[0] ;echo $mid;
				$sql = "SELECT count(*) FROM LOGIN_ATEMPTS WHERE M_ID='$m_id'";
				$result=$db->query($sql);
				$a_count = $result->fetchRow();
				if ($a_count[0]>0)  
					{//user exists 
					//echo "<br> - User Registered in L.A. ...";
						$sql = "SELECT A_NR FROM LOGIN_ATEMPTS WHERE M_ID ='$m_id'"; 
						$result=$db->query($sql);
						$anr = $result->fetchRow();
						if ($anr[0]==9)
							{//max atempts
								//echo "<br> - Locked Acount ...";								
								$sql = "UPDATE members SET modif_date=TO_DATE('01/01/1980 00:00:00', 'DD/MM/YYYY HH24:MI:SS') WHERE login='$this_login'"; 
								$res = $db->query($sql);
							}
						else
							{//atempts ++
							//echo "<br> - Atempt no.  [".($anr[0])."]+1";
							$sql = "UPDATE LOGIN_ATEMPTS SET A_NR=A_NR+1 WHERE M_ID ='$m_id'";
							$result=$db->query($sql);
							}
						
					}
				else 
					{//first atempt	
						//echo "<br> - First Atempt";		
						$sql = "INSERT INTO LOGIN_ATEMPTS VALUES ('$m_id',1)"; 
						$result=$db->query($sql);
					}
				
				
			}
		
			
		//***
	}
}

$sql = "DELETE FROM users_online WHERE member_id=$_SESSION[member_id]";
$result = @$db->query($sql);

session_destroy();


$onload = 'onload="document.login_form.form_login.focus()"';

require($_include_path.'basic_html/header.php');

?>
<script language="JavaScript">
	function change_language() {
		document.all.login_form.submit();
	}

</script>

<form action="<?php echo $PHP_SELF; ?>" method="post" name="login_form">
<input type="hidden" name="form_login_action" value="true" />
<input type="hidden" name="form_course_id" value="<?php echo $_GET[course]; ?>" />
	<?php
		if (isset($errors)) {
			echo '<tr><td colspan="5">';
			print_errors($errors);
			echo '</td></tr>';
		}
	?>
	<TR>
		<TD ROWSPAN=6>
			<IMG SRC="images/login/login_05.jpg" WIDTH=34 HEIGHT=313></TD>
		<TD COLSPAN=3 background="images/login/login_06.jpg">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td colspan="2">
						<img src="images/login/spacer.gif" width="482" height="44"></td>
				</tr>
				<tr >
					<td align="left" width="20%">
						<span class="ngrey" style="font-family: Verdana, Arial; font-size: 9pt;">&nbsp;Login:</span></td>
					<td align="left">
						<input type="text" size="20" name="form_login" id="login"></td>
				</tr>
				<tr>
					<td align="left" width="10%">
						<span class="ngrey" style="font-family: Verdana, Arial; font-size: 9pt;">&nbsp;Password:&nbsp;&nbsp;&nbsp;</span></td>
					<td align="left">
						<input type="password" size="20" name="form_password" id="password"></td>
				</tr>
				<tr>
					<td>&nbsp;
						</td>
					<td>
						<span class="nblack" style="font-family: Verdana, Arial; font-size: 8pt;"><input type="checkbox" name="auto" value="1" id="auto" /><label for="auto"><?php echo $_template['auto_login2']; ?></label></span></td>
				</tr>
				
			</table>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2">
			<!--input type="image" name="s_login" src="images/login/login_btnlogin.jpg" value="1" border="0">
			<input type="image" name="cancel" src="images/login/login_btncancel.jpg" value="1" border="0"-->
			<img src="images/login/spacer.gif" width="90" height="1">
			<input type="submit" name="submit_login" class="button" value="Login">
		</TD>
		<TD>
			<?php
			echo $_template['language'].': &nbsp;&nbsp;';
			echo '<select name="lang" class="dropdown" onChange="change_language();">';
			echo '<option value="en"';
			if ($_SESSION['lang'] == 'en') {
				echo ' selected="selected"';
			}
			echo '>English</option>'."\n";
			echo '<option value="ro"';
			if ($_SESSION['lang'] == 'ro') {
				echo ' selected="selected"';
			}
			echo '>Romana</option>'."\n";
			echo '</select>';
			?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=3>
			<IMG SRC="images/login/login_08.jpg" WIDTH=482 HEIGHT=43></TD>
	</TR>
	<TR>
		<TD COLSPAN=3>
			<!-- IMG SRC="images/login/login_09.jpg" WIDTH=482 HEIGHT=19 -->
			<span class="nblack" style="font-family: Verdana, Arial; font-size: 8pt;">&nbsp;&nbsp;<?php echo $_template['forgot']; ?></span>
			<a href="password_reminder.php" style="font-family: Verdana, Arial; font-size: 7pt;"><?php echo $_template['click_here']; ?></a></TD>
	</TR>
	<TR>
		<TD COLSPAN=3>
			<IMG SRC="images/login/login_10.jpg" WIDTH=482 HEIGHT=40></TD>
	</TR>
	<TR>
		<TD COLSPAN=3>
			<!-- IMG SRC="images/login/login_11.jpg" WIDTH=482 HEIGHT=43>
			<span class="nblack" style="font-family: Verdana, Arial; font-size: 8pt;">&nbsp;&nbsp;<?php //echo $_template['no_account']; ?>
			<a href="registration.php" style="font-family: Verdana, Arial; font-size: 7pt;"><b><?php //echo $_template['free_account']; ?></b></a-->
			</TD>
	</TR>
	<TR>
		<TD COLSPAN=4>
			<IMG SRC="images/login/login_12.jpg" WIDTH=516 HEIGHT=34></TD>
	</TR>
</TABLE>

</form>

<?php

	//require($_include_path.'basic_html/footer.php');
?>
