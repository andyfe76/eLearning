<?php $section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_GET['delete']) {
	$sql = "SELECT * FROM members WHERE member_id=$_GET[mid]";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	
	$new_mid = $db->nextId("AUTO_DEL_MEMBERS_MID");
	$sql = "INSERT INTO del_members VALUES ($new_mid, '$row[LOGIN]', '$row[PASSWORD]', '$row[EMAIL]', $row[STATUS], '$row[PREFERENCES]', '$row[CREATION_DATE]', '$row[MODIF_DATE]', '$row[CUSTOM1]', '$row[CUSTOM2]', '$row[CUSTOM3]', '$row[CUSTOM4]', '$row[CUSTOM5]', '$row[CUSTOM6]', '$row[CUSTOM7]', '$row[CUSTOM8]', '$row[CUSTOM9]', '$row[CUSTOM10]')";
	$res = $db->query($sql);
	$sql = "DELETE FROM members WHERE member_id=$_GET[mid]";
	$res = $db->query($sql);
	Header('Location: usermng.php?f='.AT_FEEDBACK_USER_DELETED);
	exit;
} else if ($_GET['cancel']) {
	Header('Location: usermng.php');
	exit;
}



require($_include_path.'cc_html/header.inc.php');
print_errors($errors);

$sql	= "SELECT login FROM members WHERE member_id=$_GET[mid]";
$res	= $db->query($sql);
$row	=$res->fetchRow(DB_FETCHMODE_ASSOC);

$warnings[]=array(AT_WARNING_DELETE_USER, $row[LOGIN]);
print_warnings($warnings);

echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">';
echo '<tr><td align="center">';

echo '<a href="'.$PHP_SELF.'?mid='.$_GET['mid'].SEP.'delete=1">'.$_template['yes_delete'].'</a>';
echo ' <span class="bigspacer">|</span> ';
echo '<a href="'.$PHP_SELF.'?cancel=1">'.$_template['no_cancel'].'</a>.';

echo '</td></tr></table>';
require ($_include_path.'cc_html/footer.inc.php'); 

?>
