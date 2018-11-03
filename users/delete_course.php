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
		$result = $db->query($sql);
		echo $_template['enrolled'].': '.$db->affectedRows()."\n";

		// news:
		$sql	= "SELECT * FROM news WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO del_news VALUES ($row[NEWS_ID], $row[COURSE_ID], $row[MEMBER_ID], '$row[DATA]', $row[FORMATTING], '$row[TITLE]', '$row[BODY]')";
			$result = $db->query($sql);
		}
		$sql	= "DELETE FROM news WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['announcements'].': '.$db->affectedRows()."\n";
		//echo $sql;

		// related_content + content:
		$sql	= "SELECT * FROM content WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO del_content VALUES ($row[CONTENT_ID], $row[COURSE_ID], $row[CONTENT_PARENT_ID], $row[ORDERING], TO_DATE('$row[LAST_MODIFIED]', 'DD/MM/YYYY HH24:MI:SS'), $row[REVISION], $row[FORMATTING], TO_DATE('$row[R_DATE]', 'DD/MM/YYYY HH24:MI:SS'), '$row[TITLE]', '$row[TEXT]')";
			$result = $db->query($sql);
		}
		/*$sql	= "SELECT * FROM content WHERE course_id=$course";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sql	= "DELETE FROM content_learning_concepts WHERE content_id=$row[0]";
			$result2 = $db->query($sql);
	
			$sql	= "DELETE FROM related_content WHERE content_id=$row[0]";
			$result2 = $db->query($sql);
		}*/
		
		$sql = "DELETE FROM content WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['content'].':                            '.$db->affectedRows()."\n";

		$sql = "OPTIMIZE TABLE content";
		$result = $db->query($sql);

		/************************************/
		// course stats:
		/*$sql = "DELETE FROM course_stats WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['course_stats'].':                  '.$db->affectedRows()."\n";*/

		/************************************/
		// links:
		/*$sql	= "SELECT * FROM resource_categories WHERE course_id=$course";
		$result = $db->query($sql);
		$total_links = 0;
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sql = "DELETE FROM resource_links WHERE CatID=$row[0]";
			$result2 = $db->query($sql);
			$total_links += $db->affectedRows();
		}
		$sql	= "DELETE FROM resource_categories WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['resource_categories'].':                '.$db->affectedRows()."\n";
		echo $_template['resource_links'].':                     '.$total_links."\n";*/

		/************************************/
		// glossary:
		/*$sql	= "DELETE FROM glossary WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['glossary_terms'].':                     '.$db->affectedRows()."\n";*/

		/************************************/
		/* forum */
		/*$sql	= "SELECT post_id FROM forums_threads WHERE course_id=$course";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sql	 = "DELETE FROM forums_accessed WHERE post_id=$row[POST_ID]";
			$result2 = $db->query($sql);

			$sql	 = "DELETE FROM forums_subscriptions WHERE post_id=$row[POST_ID]";
			$result2 = $db->query($sql);
		}*/

		/************************************/
		/*$sql = "DELETE FROM forums_threads WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['forum_threads'].':                      '.$db->affectedRows()."\n";

		$sql = "DELETE FROM forums WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['forums'].':                             '.$db->affectedRows()."\n";

		$sql = "OPTIMIZE TABLE forums_threads";
		$result = $db->query($sql);

		$sql = "DELETE FROM preferences WHERE course_id=$course";
		$result = $db->query($sql);
		echo $_template['preferences'].':                        '.$db->affectedRows()."\n";

		$sql = "DELETE FROM g_click_data WHERE course_id=$course";
		$result = $db->query($sql);
		// no feedback for this item.


		// tests + tests_questions + tests_answers + tests_results:
		$sql	= "SELECT test_id FROM tests WHERE course_id=$course";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sql	= "DELETE FROM tests_questions WHERE test_id=$row[0]";
			$result2 = $db->query($sql);
	
			$sql2	= "SELECT result_id FROM tests_results WHERE test_id=$row[0]";
			$result2 = $db->query($sql2, $db);
			while ($row2 =$result2->fetchRow(DB_FETCHMODE_ASSOC)) {
				$sql3	= "DELETE FROM tests_answers WHERE result_id=$row2[0]";
				$result3 = $db->query($sql3, $db);
			}

			$sql	= "DELETE FROM tests_results WHERE test_id=$row[0]";
			$result2 = $db->query($sql);
		}

		$sql	= "DELETE FROM tests WHERE course_id=$course";
		$result = $db->query($sql);

		echo $_template['tests'].':                              '.$db->affectedRows()."\n";

		// files:
		$path = '../content/'.$course.'/';
		clr_dir($path);*/

		// courses:
		$sql	= "SELECT * FROM courses WHERE course_id=$course";
		$res	= $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)){
			$sql	= "INSERT INTO del_courses VALUES ($row[COURSE_ID], $row[MEMBER_ID], '$row[ACCESSTYPE]', '$row[CREATED_DATE]', '$row[TITLE]', '$row[DESCRIPTION]', $row[NOTIFY], '$row[MAX_QUOTA]', '$row[MAX_FILE_SIZE]', '$row[HIDE]', '$row[PREFERENCES]', '$row[HEADER]', '$row[FOOTER]', '$row[COPYRIGHT]', '$row[TRACKING]', '$row[CUSTOM1]', '$row[CUSTOM2]', '$row[CUSTOM3]', '$row[CUSTOM4]', '$row[CUSTOM5]', '$row[CUSTOM6]', '$row[CUSTOM7]', '$row[CUSTOM8]', '$row[CUSTOM9]', '$row[CUSTOM10]', '$row[MODIF_DATE]')";
			$result = $db->query($sql);
		}
		$sql = "DELETE FROM courses WHERE course_id=$course";
		$result = $db->query($sql);
		echo '<b>'.$_template['course'].': '.$db->affectedRows().' '.$_template['always_one'].'</b>'."\n";

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
