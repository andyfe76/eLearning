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

		echo '<b>'.$_template['restoring_course'].'</b><pre>';

		// news:
		$sql	= "SELECT * FROM del_news WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO news VALUES ($row[NEWS_ID], $row[COURSE_ID], $row[MEMBER_ID], '$row[DATA]', $row[FORMATTING], '$row[TITLE]', '$row[BODY]')";
			$result = $db->query($sql);
		}
		$sql	= "DELETE FROM del_news WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['announcements'].': '.mysql_affected_rows($db)."\n";
		//echo $sql;

		// related_content + content:
		$sql	= "SELECT * FROM del_content WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO content VALUES ($row[CONTENT_ID], $row[COURSE_ID], $row[CONTENT_PARENT_ID], $row[ORDERING], TO_DATE('$row[LAST_MODIFIED]', 'DD/MM/YYYY HH24:MI:SS'), $row[REVISION], $row[FORMATTING], TO_DATE('$row[RELEASE_DATE]', 'DD/MM/YYYY HH24:MI:SS'), '$row[TITLE]', '$row[TEXT]')";
			$result = $db->query($sql);
		}
		
		$sql = "DELETE FROM del_content WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['content'].':                            '.mysql_affected_rows($db)."\n";

		$sql = "OPTIMIZE TABLE del_content";
		$result = $db->query($sql);

		
		// courses:
		$sql	= "SELECT * FROM del_courses WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO courses VALUES ($row[COURSE_ID], $row[MEMBER_ID], '$row[ACCESSTYPE]', '$row[CREATED_DATE]', '$row[TITLE]', '$row[DESCRIPTION]', $row[NOTIFY], '$row[MAX_QUOTA]', '$row[MAX_FILE_SIZE]', '$row[HIDE]', '$row[PREFERENCES]', '$row[HEADER]', '$row[FOOTER]', '$row[COPYRIGHT]', '$row[TRACKING]', '$row[CUSTOM1]', '$row[CUSTOM2]', '$row[CUSTOM3]', '$row[CUSTOM4]', '$row[CUSTOM5]', '$row[CUSTOM6]', '$row[CUSTOM7]', '$row[CUSTOM8]', '$row[CUSTOM9]', '$row[CUSTOM10]', '$row[MODIF_DATE]')";
			$result = $db->query($sql);
		}
		$sql = "DELETE FROM del_courses WHERE course_id=$course";
		$result = $db->query($sql);
		echo '<b>'.$_template['course'].': '.mysql_affected_rows($db).' '.$_template['always_one'].'</b>'."\n";

		echo '</pre><br />'.$_template['return'].' ';
		
		if (!$_SESSION['s_is_super_admin']) {
			echo '<a href="users/">'.$_template['home'].'</a>.';
		} else {
			echo '<a href="users/admin/">'.$_template['home'].'</a>.';
		}

		// purge the system_courses cache! (if successful)
		cache_purge('system_courses','system_courses');
		$feedback[]=AT_FEEDBACK_COURSE_RESTORED;
		print_feedback($feedback);

require ($_include_path.'cc_html/footer.inc.php');

?>
