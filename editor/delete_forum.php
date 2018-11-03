<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['cancel']) {
	Header('Location: ../discussions/?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
	exit;

}
if ($_POST['delete_forum'] && $_SESSION['is_admin']) {
	$_POST['fid'] = intval($_POST['fid']);

	$sql	= "SELECT post_id FROM forums_threads WHERE forum_id=$_POST[fid] AND course_id=$_SESSION[course_id]";
	$result = $db->query($sql);
	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql	 = "DELETE FROM forums_accessed WHERE post_id=$row[POST_ID]";
		$result2 = $db->query($sql);

		$sql	 = "DELETE FROM forums_subscriptions WHERE post_id=$row[POST_ID]";
		$result2 = $db->query($sql);
	}

	$sql = "DELETE FROM forums_threads WHERE forum_id=$_POST[fid] AND course_id=$_SESSION[course_id]";
	$result = $db->query($sql);

	$sql = "DELETE FROM forums WHERE forum_id=$_POST[fid] AND course_id=$_SESSION[course_id]";
	$result = $db->query($sql);

	$sql = "OPTIMIZE TABLE forums_threads";
	$result = $db->query($sql);

	Header('Location: ../discussions/?f='.urlencode_feedback(AT_FEEDBACK_FORUM_DELETED));
	exit;
}

$_section[0][0] = $_template['delete_forum'];

require($_include_path.'header.inc.php');
?>
<h2><?php echo $_template['delete_forum']; ?></h2>
<?php

	$_GET['fid'] = intval($_GET['fid']); 

	$sql = "SELECT * FROM forums WHERE forum_id=$_GET[fid] AND course_id=$_SESSION[course_id]";

	$result = $db->query($sql);
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	if ($count0[0] == 0) {
		$errors[]=AT_ERROR_FORUM_NOT_FOUND;
	} else {
		$row =$result->fetchRow(DB_FETCHMODE_ASSOC);
?>
	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="delete_forum" value="true">
	<input type="hidden" name="fid" value="<?php echo $_GET['fid']; ?>">
	<?php
	$warnings[]=array(AT_WARNING_DELETE_FORUM, $row['TITLE'].'?');
	print_warnings($warnings);

	?>

	
	<br />
	<input type="submit" name="submit" value="<?php echo $_template['yes_delete']?>" class="button"> -
	<input type="submit" name="cancel" value="<?php echo $_template['no_cancel']?>" class="button">
	</form>
	<?php
}
require($_include_path.'footer.inc.php');
?>
