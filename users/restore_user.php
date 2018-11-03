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

$course = intval($_GET['course']);

	$sql = "SELECT * FROM del_members WHERE member_id=$_GET[mid]";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
	
	$sql = "INSERT INTO members VALUES ($row[member_id], '$row[login]', '$row[password]', '$row[email]', $row[status], '$row[preferences]', '$row[creation_date]', '$row[modif_date]', '$row[custom1]', '$row[custom2]', '$row[custom3]', '$row[custom4]', '$row[custom5]', '$row[custom6]', '$row[custom7]', '$row[custom8]', '$row[custom9]', '$row[custom10]')";
	$res = mysql_query($sql, $db);
	$sql = "DELETE FROM del_members WHERE member_id=$_GET[mid]";
	$res = mysql_query($sql, $db);
	
	$sql = "OPTIMIZE TABLE del_members";
	$result = mysql_query($sql, $db);
		
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