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

if (isset($cookie_login, $cookie_pass) && !isset($_POST['submit'])) {
	
	/* auto login */
	$this_login		= $cookie_login;
	$this_password	= $cookie_pass;
	$auto_login		= 1;
	$used_cookie	= true;
	
} else if (isset($_POST['submit'])) {
	/* form post login */
	$this_login		= $_POST['form_login'];
	$this_password  = $_POST['form_password'];
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
		$sql = "SELECT member_id, login, preferences, creation_date, modif_date, status, PASSWORD(password) AS pass FROM members WHERE login='$this_login' AND PASSWORD(password)='$this_password'";

	} else {
		$sql = "SELECT member_id, login, preferences, creation_date, modif_date, status, PASSWORD(password) AS pass FROM members WHERE login='$this_login' AND PASSWORD(password)=PASSWORD('$this_password')";
	}

	$result = mysql_query($sql);
	if (mysql_num_rows($result) == 1) {
		$row = mysql_fetch_array($result);

		$_SESSION['login']		= $row['login'];
		$_SESSION['valid_user'] = true;
		$_SESSION['member_id']	= intval($row['member_id']);
		$_SESSION['prefs']		= unserialize(stripslashes($row['preferences']));
		$_SESSION['is_guest']	= 0;
		$_SESSION['status'] 	= $row['status'];
		if ($row['status'] == 0)	{
			$_SESSION['c_instructor'] = false;
			$_SESSION['is_admin'] = false;
		} else if ($row['status'] == 1) {
			$_SESSION['c_instructor'] = true;
			$_SESSION['is_admin'] = false;
		} else {
			$_SESSION['c_instructor'] = false;
			$_SESSION['is_admin'] = true;
			$_SESSION['is_super_admin'] = true;
		}

		if ($auto_login == 1) {
			$parts = parse_url($_base_href);
			// update the cookie.. increment to another 2 days
			$cookie_expire = time()+172800; // two days
			setcookie('ATLogin', $this_login, $cookie_expire, $parts['path'], $parts['host'], 0);
			setcookie('ATPass',  $row['pass'],  $cookie_expire, $parts['path'], $parts['host'], 0);
		}
		
		$pass = passwd_expired($row['status'], $row['creation_date'], $row['modif_date']);
		
		if ( $pass == AT_PASSWORD_EXPIRED){
			Header('Location: ./bounce.php?course='.$_POST['form_course_id'].'&pexp=1');
		} else if ( $pass > 0 ) {
			Header('Location: ./bounce.php?course='.$_POST['form_course_id'].SEP.'f='.AT_FEEDBACK_PASSWORD_EXP);
		} else {
			Header('Location: ./bounce.php?course='.$_POST['form_course_id']);
		}
		exit;
	} else {
		
		$errors[] = AT_ERROR_INVALID_LOGIN;
	}
}

$sql = "DELETE FROM users_online WHERE member_id=$_SESSION[member_id]";
$result = @mysql_query($sql, $db);

session_destroy();

$onload = 'onload="document.form.form_login.focus()"';

require($_include_path.'basic_html/header.php');
?>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form">
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
					<td>
						&nbsp;</td>
					<td>
						<span class="nblack" style="font-family: Verdana, Arial; font-size: 8pt;"><input type="checkbox" name="auto" value="1" id="auto" /><label for="auto"><?php echo $_template['auto_login2']; ?></label></span></td>
				</tr>
				
			</table>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="3">
			<!--input type="image" name="s_login" src="images/login/login_btnlogin.jpg" value="1" border="0">
			<input type="image" name="cancel" src="images/login/login_btncancel.jpg" value="1" border="0"-->
			<img src="images/login/spacer.gif" width="90" height="1">
			<input type="submit" name="submit" class="button" value="Login">
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
			<!-- IMG SRC="images/login/login_11.jpg" WIDTH=482 HEIGHT=43 -->
			<span class="nblack" style="font-family: Verdana, Arial; font-size: 8pt;">&nbsp;&nbsp;<?php echo $_template['no_account']; ?>
			<a href="registration.php" style="font-family: Verdana, Arial; font-size: 7pt;"><b><?php echo $_template['free_account']; ?></b></a>.
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
