<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

if ($_POST['delete_news'] && $_SESSION['is_admin']) {
	$_POST['form_news_id'] = intval($_POST['form_news_id']);

	$sql = "DELETE FROM news WHERE news_id=$_POST[form_news_id] AND course_id=$_SESSION[course_id]";
	$result = $db->query($sql);

	Header('Location: ../index.php?f='.urlencode_feedback(AT_FEEDBACK_NEWS_DELETED));
	exit;
}

$_section[0][0] = 'Delete Announcement';

require($_include_path.'header.inc.php');
?>
<h2><?php echo $_template['delete_announcement']; ?></h2>
<?php

	$_GET['aid'] = intval($_GET['aid']); 

	$sql = "SELECT * FROM news WHERE news_id=$_GET[aid] AND member_id=$_SESSION[member_id] AND course_id=$_SESSION[course_id]";

	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	if ($count0[0] == 0) {
		$errors[]=AT_ERROR_ANN_NOT_FOUND;
		print_errors($errors);
	} else {
		$row =$result->fetchRow(DB_FETCHMODE_ASSOC);
?>
	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="delete_news" value="true">
	<input type="hidden" name="form_news_id" value="<?php echo $row[NEWS_ID]; ?>">
	<?php
		$warnings[]=array(AT_WARNING_DELETE_NEWS, $row[TITLE]);
		print_warnings($warnings);

	?>
	<input type="submit" name="submit" value="<?php echo $_template['delete']; ?>" class="button"> - <input type="submit" name="cancel" class="button" value=" <?php echo $_template['cancel']; ?> " />
	</form>
	<?php
}
require($_include_path.'footer.inc.php');
?>
