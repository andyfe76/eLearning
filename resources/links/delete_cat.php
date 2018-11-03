<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$_include_path = '../../include/';
require ($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['resources'];
$_section[0][1] = 'resources/';
$_section[1][0] = $_template['links_database'];
$_section[1][1] = 'resources/links/';
$_section[2][0] = $_template['delete_category'];
if ($_GET['d']){
if ($_SESSION['is_admin']) {
			$sql	= "DELETE FROM resource_categories WHERE CatID=$_GET[CatID] AND course_id=$_SESSION[course_id]";
			$result	= $db->query($sql);

			$num_deleted = mysql_affected_rows($db);

			if ($num_deleted > 0) {
				$sql	= "DELETE FROM resource_links WHERE CatID=$_GET[CatID]";
				$result	= $db->query($sql);
			}

			//$feedback[] = AT_FEEDBACK_LINK_CAT_DELETED;

			//print_feedback($feedback);
		}
		Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_LINK_CAT_DELETED));
		exit;

}
require ($_include_path.'header.inc.php');

$_GET['CatID'] = intval($_GET['CatID']);

?>
<h2><a href="resources/?g=11"><?php echo $_template['resources']; ?></a></h2>
<h3><a href="resources/links/?g=11"><?php echo $_template['links_database']; ?></a></h3>
<h4><?php echo $_template['delete_category']; ?></h4>

<?php 
	$sql	= "SELECT CatID FROM resource_categories WHERE CatParent=$_GET[CatID] LIMIT 1";
	$result	= $db->query($sql);
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$error[] = AT_ERROR_LINK_CAT_NOT_EMPTY;
		print_errors($error);
		require ($_include_path.'footer.inc.php');
		exit;
	}

	
	if (!$_GET['d']) {
	$warning[] =  AT_WARNING_DELETE_CATEGORY;
	print_warnings($warning)
?>
	<p align="center"><a href="resources/links/delete_cat.php?CatID=<?php echo $_GET['CatID'].SEP.'d=1'; ?>"><?php echo $_template['yes_delete']; ?></a>, <a href="resources/links/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></p>
<?php } ?>

<?php
	require($_include_path.'footer.inc.php');
?>
