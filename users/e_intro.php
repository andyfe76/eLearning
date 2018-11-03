<?php
$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
$_SESSION['s_is_super_admin'] = false;

if ($_GET['auto'] == 'disable') {
	$parts = parse_url($_base_href);
	setcookie('ATLogin', '', time()-172800, $parts['path'], $parts['host'], 0);
	setcookie('ATPass',  '', time()-172800, $parts['path'], $parts['host'], 0);
	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_AUTO_DISABLED));
	exit;
} else if ($_GET['auto'] == 'enable') {
	$parts = parse_url($_base_href);

	$sql	= "SELECT PASSWORD(password) AS pass FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

	setcookie('ATLogin', $_SESSION['login'], time()+172800, $parts['path'], $parts['host'], 0);
	setcookie('ATPass',  $row['PASS'], time()+172800, $parts['path'], $parts['host'], 0);

	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_AUTO_ENABLED));
	exit;
}

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	$login  = $row['LOGIN'];

	require($_include_path.'cc_html/header.inc.php');

	if ($_GET['f'] == AT_FEEDBACK_AUTO_ENABLED) {
		$warnings[] = AT_WARNING_AUTO_LOGIN;
		print_warnings($warnings);
	}
	print_errors($errors);
	echo $auto;
?>
<h1 class="center"><?php echo $_template['about_elearning'];  ?></h1>
<?php

	$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);
	$status	= $row['STATUS'];
	$email  = $row['EMAIL'];
	$login  = $row['LOGIN'];

	$help[] = AT_HELP_CONTROL_CENTER1;
	if ($status == 1) {
		$_SESSION['c_instructor'] = true;
		$help[] = AT_HELP_CONTROL_CENTER2;
	} else if ($status == 2) {	
		$_SESSION['is_admin'] = true;
		$help[] = AT_HELP_CONTROL_CENTER3;
	}
	//print_help($help);
 ?>

<br />
<?php
	if ($status == 2) {
	/* admin mode */
	
	}
?>
<BR />
<?php 
	if ($status <> 2) {
?>
<div align="left">
<h2><?php echo $_template['enrolled_courses']; ?></h2><br></div>
	
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr><td height="1" class="row2" colspan="3"></td></tr>
	<!--tr>
		<th scope="col" width="150"><?php  //echo $_template['course_name'];  ?></th>
		<th scope="col"><?php // echo $_template['description'];  ?></th>
		<!-- <th scope="col"><?php  //echo $_template['remove'];  ?></th>
	</tr -->
	<?php 
		include($_include_path.'about_elearning.php');
	?>
	</table>
	<?php
	require ($_include_path.'cc_html/footer.inc.php');
?>
