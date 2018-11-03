<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/filemanager.inc.php');

if ($_SESSION['s_is_super_admin']) {
	require($_include_path.'admin_html/header.inc.php'); 
} else {
	require($_include_path.'cc_html/header.inc.php');
}
$member_id=$_SESSION['member_id'];
?>

<h2><?php echo $_template['restore']; ?></h2>
<?php
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

$course = intval($_GET['course']);

	$sql = "SELECT * FROM del_members WHERE member_id=$_GET[mid]";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	
	// recovering member into the selected group
	$group_id = $_GET['group_id'];
	if ($group_id == '') $group_id = $_POST['group_id'];
	if ($group_id == '') $group_id = 1;
	
	// check for duplicate login
	$sql = "SELECT COUNT(member_id) FROM members WHERE login='$row[LOGIN]'";
	$res = $db->query($sql);
	$row1 = $res->fetchRow();
	$count0 = $row1[0];
	if ($count0 >0) {
		$errors[] = AT_ERROR_LOGIN_EXISTS;
		print_errors($errors);
		exit;
	}
	$new_mid = $db->nextID("AUTO_MEMBERS_MEMBER_ID_SEQ");
	$sql = "INSERT INTO members VALUES ($new_mid, '$row[LOGIN]', '$row[PASSWORD]', '$row[EMAIL]', $row[STATUS], '$row[PREFERENCES]', '$row[CREATION_DATE]', '$row[MODIF_DATE]', '$row[CUSTOM1]', '$row[CUSTOM2]', '$row[CUSTOM3]', '$row[CUSTOM4]', '$row[CUSTOM5]', '$row[CUSTOM6]', '$row[CUSTOM7]', '$row[CUSTOM8]', '$row[CUSTOM9]', '$row[CUSTOM10]')";		
	$res = $db->query($sql);
	if (PEAR::isError($res)) {
		echo 'Database error...<br><br>';
		print_r($res);
		exit;
	}
	
	// associate to member group
	$sql = "INSERT INTO mrel_groups VALUES ($new_mid, 0, $group_id)";
	$res = $db->query($sql);
	if (PEAR::isError($res)){
		echo 'Database error...<br><br>';
		print_r($res);
		exit;
	}
	
	// check for personal data
	$sql = "SELECT * FROM members_pers WHERE member_id=$row[MEMBER_ID]";
	$res = $db->query($sql);
	$row1 = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$sql = "INSERT INTO members_pers VALUES ($new_mid, '$row1[FIRST_NAME]', '$row1[LAST_NAME]')";
	$res = $db->query($sql);
	
	// delete from del db
	
	$sql = "DELETE FROM del_members WHERE member_id=$_GET[mid]";
	$res = $db->query($sql);
	
	$sql = "OPTIMIZE TABLE del_members";
	$result = $db->query($sql);
		
		if (!$_SESSION['s_is_super_admin']) {
			echo '<a href="users/">'.$_template['home'].'</a>.';
		} else {
			echo '<a href="users/admin/">'.$_template['home'].'</a>.';
		}

		// purge the system_courses cache! (if successful)
		cache_purge('system_courses','system_courses');
		$feedback[]=AT_FEEDBACK_USER_RESTORED;
		print_feedback($feedback);

require ($_include_path.'cc_html/footer.inc.php');

?>
