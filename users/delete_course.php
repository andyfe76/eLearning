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

<h2><?php echo $_template['delete_course']; ?></h2>

<?php

/* make sure we own this course that we're approving for! */
$course = intval($_GET['course']);
if (!$_SESSION['s_is_super_admin'] && !$_SESSION['is_admin'] && !$_SESSION['c_instructor']) {
	$sql	= "SELECT * FROM courses WHERE course_id=$course AND member_id=$_SESSION[member_id]";
	$result	= mysql_query($sql, $db);
	if (mysql_num_rows($result) != 1) {
		echo $_template['not_your_course'];
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
}
if (!$_GET['d']) {
	$warnings[]= array(AT_WARNING_SURE_DELETE_COURSE1, $system_courses[$course][title]);
	print_warnings($warnings);
	//phpinfo();
	if(ereg("admin" , $_SERVER[HTTP_REFERER])){
		if($_GET['member_id']){
			echo '<center><a href="'.$PHP_SELF.'?course='.$course.SEP.'d=1'.SEP.'ad=1'.SEP.'member_id='.$_GET['member_id'].'">'.$_template['yes_delete'].'</a> | <a href="users/admin/courses.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'member_id='.$_GET['member_id'].'">'.$_template['no_cancel'].'</a></center>';
		}else{
			echo '<center><a href="'.$PHP_SELF.'?course='.$course.SEP.'d=1'.SEP.'ad=1">'.$_template['yes_delete'].'</a> | <a href="users/admin/courses.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></center>';
		}
	}else{
		echo	'<center><a href="'.$PHP_SELF.'?course='.$course.SEP.'d=1'.'">'.$_template['yes_delete'].'</a> | <a href="users/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></center>';
	}
?>
	<!--center><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=1'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center-->
<br />
<?php
	} else if ($_GET['d'] == 1){
		$warnings[]=array(AT_WARNING_SURE_DELETE_COURSE2, $system_courses[$course][title]);
		print_warnings($warnings);
?>
	<?php if($_GET['ad'] == 1){?>
		<?php if($_GET['member_id']){ ?>
			<center><br /><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=2'.SEP.'member_id='.$_GET['member_id'].'"'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/admin/courses.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'member_id='.$_GET['member_id']; ?>"><?php echo $_template['no_cancel']; ?></a></center>
		<?php }else{ ?>
			<center><br /><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/admin/courses.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center>
		<?php } ?>
		<!--center><br /><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/admin/courses.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center -->
	<?php }else{ ?>
		<center><br /><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center>
	<?php } ?>


	<!--center><br /><a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center> -->

	<?php
	} else if ($_GET['d'] == 2){
		echo '<b>'.$_template['deleting_course'].'</b><pre>';

		// course_enrollment:
		$sql	= "DELETE FROM course_enrollment WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['enrolled'].': '.mysql_affected_rows($db)."\n";

		// news:
		$sql	= "SELECT * FROM news WHERE course_id=$course";
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO del_news VALUES ($row[news_id], $row[course_id], $row[member_id], '$row[date]', $row[formatting], '$row[title]', '$row[body]')";
			$result = mysql_query($sql, $db);
		}
		$sql	= "DELETE FROM news WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['announcements'].': '.mysql_affected_rows($db)."\n";
		//echo $sql;

		// related_content + content:
		$sql	= "SELECT * FROM content WHERE course_id=$course";
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO del_content VALUES ($row[content_id], $row[course_id], $row[content_parent_id], $row[ordering], '$row[last_modified]', $row[revision], $row[formatting], '$row[release_date]', '$row[title]', '$row[text]')";
			$result = mysql_query($sql, $db);
		}
		/*$sql	= "SELECT * FROM content WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		while ($row = mysql_fetch_array($result)) {
			$sql	= "DELETE FROM content_learning_concepts WHERE content_id=$row[0]";
			$result2 = mysql_query($sql, $db);
	
			$sql	= "DELETE FROM related_content WHERE content_id=$row[0]";
			$result2 = mysql_query($sql, $db);
		}*/
		
		$sql = "DELETE FROM content WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['content'].':                            '.mysql_affected_rows($db)."\n";

		$sql = "OPTIMIZE TABLE content";
		$result = mysql_query($sql, $db);

		/************************************/
		// course stats:
		/*$sql = "DELETE FROM course_stats WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['course_stats'].':                  '.mysql_affected_rows($db)."\n";*/

		/************************************/
		// links:
		/*$sql	= "SELECT * FROM resource_categories WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		$total_links = 0;
		while ($row = mysql_fetch_array($result)) {
			$sql = "DELETE FROM resource_links WHERE CatID=$row[0]";
			$result2 = mysql_query($sql, $db);
			$total_links += mysql_affected_rows($db);
		}
		$sql	= "DELETE FROM resource_categories WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['resource_categories'].':                '.mysql_affected_rows($db)."\n";
		echo $_template['resource_links'].':                     '.$total_links."\n";*/

		/************************************/
		// glossary:
		/*$sql	= "DELETE FROM glossary WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['glossary_terms'].':                     '.mysql_affected_rows($db)."\n";*/

		/************************************/
		/* forum */
		/*$sql	= "SELECT post_id FROM forums_threads WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		while ($row = mysql_fetch_array($result)) {
			$sql	 = "DELETE FROM forums_accessed WHERE post_id=$row[post_id]";
			$result2 = mysql_query($sql, $db);

			$sql	 = "DELETE FROM forums_subscriptions WHERE post_id=$row[post_id]";
			$result2 = mysql_query($sql, $db);
		}*/

		/************************************/
		/*$sql = "DELETE FROM forums_threads WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['forum_threads'].':                      '.mysql_affected_rows($db)."\n";

		$sql = "DELETE FROM forums WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['forums'].':                             '.mysql_affected_rows($db)."\n";

		$sql = "OPTIMIZE TABLE forums_threads";
		$result = mysql_query($sql, $db);

		$sql = "DELETE FROM preferences WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		echo $_template['preferences'].':                        '.mysql_affected_rows($db)."\n";

		$sql = "DELETE FROM g_click_data WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		// no feedback for this item.


		// tests + tests_questions + tests_answers + tests_results:
		$sql	= "SELECT test_id FROM tests WHERE course_id=$course";
		$result = mysql_query($sql, $db);
		while ($row = mysql_fetch_array($result)) {
			$sql	= "DELETE FROM tests_questions WHERE test_id=$row[0]";
			$result2 = mysql_query($sql, $db);
	
			$sql2	= "SELECT result_id FROM tests_results WHERE test_id=$row[0]";
			$result2 = mysql_query($sql2, $db);
			while ($row2 = mysql_fetch_array($result2)) {
				$sql3	= "DELETE FROM tests_answers WHERE result_id=$row2[0]";
				$result3 = mysql_query($sql3, $db);
			}

			$sql	= "DELETE FROM tests_results WHERE test_id=$row[0]";
			$result2 = mysql_query($sql, $db);
		}

		$sql	= "DELETE FROM tests WHERE course_id=$course";
		$result = mysql_query($sql, $db);

		echo $_template['tests'].':                              '.mysql_affected_rows($db)."\n";

		// files:
		$path = '../content/'.$course.'/';
		clr_dir($path);*/

		// courses:
		$sql	= "SELECT * FROM courses WHERE course_id=$course";
		$res	= mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)){
			$sql	= "INSERT INTO del_courses VALUES ($row[course_id], $row[member_id], '$row[access]', '$row[created_date]', '$row[title]', '$row[description]', $row[notify], '$row[max_quota]', '$row[max_file_size]', '$row[hide]', '$row[preferences]', '$row[header]', '$row[footer]', '$row[copyright]', '$row[tracking]', '$row[custom1]', '$row[custom2]', '$row[custom3]', '$row[custom4]', '$row[custom5]', '$row[custom6]', '$row[custom7]', '$row[custom8]', '$row[custom9]', '$row[custom10]', '$row[modif_date]')";
			$result = mysql_query($sql, $db);
		}
		$sql = "DELETE FROM courses WHERE course_id=$course";
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
		$feedback[]=AT_FEEDBACK_COURSE_DELETED;
		print_feedback($feedback);

	}

require ($_include_path.'cc_html/footer.inc.php');

?>