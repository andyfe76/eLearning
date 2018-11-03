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
$_section[2][0] = $_template['edit_category'];

if ($_POST['submit']) {
	$_POST['CatID'] = intval($_POST['CatID']);
	$sql	= "UPDATE resource_categories SET CatName='$_POST[cat_name]' WHERE CatID=$_POST[CatID] AND course_id=$_SESSION[course_id]";

	$result	= $db->query($sql);

	//$feedback[] = AT_FEEDBACK_LINK_CAT_EDITED;
	//print_feedback($feedback);
	
	Header('Location: index.php?f='.urlencode_feedback(AT_FEEDBACK_LINK_CAT_EDITED));
	exit;
	//require($_include_path.'footer.inc.php');
	//exit;
}

require ($_include_path.'header.inc.php');

$_GET['CatID'] = intval($_GET['CatID']);

?>
<h2><a href="resources/?g=11"><?php echo $_template['resources']; ?></a></h2>
<h3><a href="resources/links/?g=11"><?php echo $_template['links_database']; ?></a></h3>
<h4><?php echo $_template['edit_category']; ?></h4>

<?php
	
	require('mysql.php'); /* Access to all the database functions */
	$db2 = new MySQL;
	if(!$db2->init()) {
		$errors[]=AT_ERROR_NO_DB_CONNECT;
		print_errors($errors);
		exit;
	}

	if (!$_SESSION['is_admin']) {
		$error[] = AT_ERROR_ACCESS_DENIED;
		print_errors($error);
		require($_include_path.'footer.inc.php');
		exit;
	} 




	$catName = $db2->get_CatNames($_GET['CatID']);

?>

	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="CatID" value="<?php echo $CatID; ?>" />
	<p>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
	<tr>
		<td class="cat" colspan="2"><h4><?php echo $_template['edit_category']; ?></h4></td>
	</tr>
	<tr>
		<td class="row1" align="right"><label for="cat"><b><?php echo $_template['category_name']; ?>:</b></label></td>
		<td class="row1"><input name="cat_name" class="formfield" size="40" value="<?php echo $catName; ?>" id="cat" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $_template['edit_category']; ?>" class="button" accesskey="s" /> <input type="reset" value=" <?php echo $_template['reset']; ?> " class="button" /></td>
	</tr>
	</table>
	</p>
	</form>



<?php
	require($_include_path.'footer.inc.php');
?>
