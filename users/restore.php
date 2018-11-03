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
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO news VALUES ($row[news_id], $row[course_id], $row[member_id], '$row[date]', $row[formatting], '$row[title]', '$row[body]')";
			$result = mysql_query($sql, $db);
		}
		$sql	= "DELETE FROM del_news WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['announcements'].': '.mysql_affected_rows($db)."\n";
		//echo $sql;

		// related_content + content:
		$sql	= "SELECT * FROM del_content WHERE course_id=$course";
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO content VALUES ($row[content_id], $row[course_id], $row[content_parent_id], $row[ordering], '$row[last_modified]', $row[revision], $row[formatting], '$row[release_date]', '$row[title]', '$row[text]')";
			$result = mysql_query($sql, $db);
		}
		
		$sql = "DELETE FROM del_content WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['content'].':                            '.mysql_affected_rows($db)."\n";

		$sql = "OPTIMIZE TABLE del_content";
		$result = mysql_query($sql, $db);

		
		// courses:
		$sql	= "SELECT * FROM del_courses WHERE course_id=$course";
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO courses VALUES ($row[course_id], $row[member_id], '$row[access]', '$row[created_date]', '$row[title]', '$row[description]', $row[notify], '$row[max_quota]', '$row[max_file_size]', '$row[hide]', '$row[preferences]', '$row[header]', '$row[footer]', '$row[copyright]', '$row[tracking]', '$row[custom1]', '$row[custom2]', '$row[custom3]', '$row[custom4]', '$row[custom5]', '$row[custom6]', '$row[custom7]', '$row[custom8]', '$row[custom9]', '$row[custom10]', '$row[modif_date]')";
			$result = mysql_query($sql, $db);
		}
		$sql = "DELETE FROM del_courses WHERE course_id=$course";
		$result = mysql_query($sql, $db);
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