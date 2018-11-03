<?php $section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_GET['delete']) {
	$sql = "SELECT * FROM members WHERE member_id=$_GET[mid]";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
	
	$sql = "INSERT INTO del_members VALUES ($row[member_id], '$row[login]', '$row[password]', '$row[email]', $row[status], '$row[preferences]', '$row[creation_date]', '$row[modif_date]', '$row[custom1]', '$row[custom2]', '$row[custom3]', '$row[custom4]', '$row[custom5]', '$row[custom6]', '$row[custom7]', '$row[custom8]', '$row[custom9]', '$row[custom10]')";
	$res = mysql_query($sql, $db);
	$sql = "DELETE FROM members WHERE member_id=$_GET[mid]";
	$res = mysql_query($sql, $db);
	Header('Location: usermng.php?f='.AT_FEEDBACK_USER_DELETED);
	exit;
} else if ($_GET['cancel']) {
	Header('Location: usermng.php');
	exit;
}



require($_include_path.'cc_html/header.inc.php');
print_errors($errors);

$sql	= "SELECT login FROM members WHERE member_id=$_GET[mid]";
$res	= mysql_query($sql, $db);
$row	= mysql_fetch_array($res);

$warnings[]=array(AT_WARNING_DELETE_USER, $row[login]);
print_warnings($warnings);

echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
echo '<tr><td>';

echo '<a href="'.$PHP_SELF.'?mid='.$_GET['mid'].SEP.'delete=1">'.$_template['yes_delete'].'</a>';
echo ' <span class="bigspacer">|</span> ';
echo '<a href="'.$PHP_SELF.'?cancel=1">'.$_template['no_cancel'].'</a>.';

echo '</td></tr></table>';
require ($_include_path.'cc_html/footer.inc.php'); 

?>