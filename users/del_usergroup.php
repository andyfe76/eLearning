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

<h2><?php echo $_template['delete_user_group']; ?><br></h2>

<?php


if (!$_GET['d']) {
	$group = $_GET['group'];
	if ($group == 0) {
		print_errors('Inexisting user group. Click <BACK> in your browser to go back to user management.');
		exit;
	}
	$sql = "SELECT name from member_groups WHERE group_id=$group";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$group_name = $row[0];
	echo '<h3><<< '.$group_name.' >>></h3>';
	$warnings[]= array(AT_WARNING_DELETE_USER_GROUP1, $group_name);
	print_warnings($warnings);
	//phpinfo();
	if(ereg("admin" , $_SERVER[HTTP_REFERER])){
		if($_GET['member_id']){
			echo '<center><a href="'.$PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=1'.SEP.'ad=1'.SEP.'member_id='.$_GET['member_id'].'">'.$_template['yes_delete'].'</a> | <a href="users/usermng.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'member_id='.$_GET['member_id'].'">'.$_template['no_cancel'].'</a></center>';
		}else{
			echo '<center><a href="'.$PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=1'.SEP.'ad=1">'.$_template['yes_delete'].'</a> | <a href="users/usermng.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></center>';
		}
	}else{
		echo	'<center><a href="'.$PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=1'.'">'.$_template['yes_delete'].'</a> | <a href="users/usermng.php?group='.$group.'&f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></center>';
	}
?>
	<!--center><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=1'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center-->
<br />
<?php
	} else if ($_GET['d'] == 1){
		$warnings[]=array(AT_WARNING_DELETE_USER_GROUP2, $system_courses[$course][title]);
		print_warnings($warnings);
?>
	<?php if($_GET['ad'] == 1){?>
		<?php if($_GET['member_id']){ ?>
			<center><br /><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=2'.SEP.'member_id='.$_GET['member_id'].'"'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/usermng.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED).SEP.'member_id='.$_GET['member_id']; ?>"><?php echo $_template['no_cancel']; ?></a></center>
		<?php }else{ ?>
			<center><br /><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/usermng.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center>
		<?php } ?>
		<!--center><br /><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/usermng.php?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center -->
	<?php }else{ ?>
		<center><br /><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/usermng.php?group=<?php echo $group; ?>&f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center>
	<?php } ?>


	<!--center><br /><a href="<?php echo $PHP_SELF.'?group='.$group.'&mod='.$mod.SEP.'d=2'; ?>"><?php echo $_template['yes_delete']; ?></a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>"><?php echo $_template['no_cancel']; ?></a></center> -->

	<?php
	} else if ($_GET['d'] == 2){
		//modif	
		$msql="SELECT member_id FROM mrel_groups WHERE group_id=$group";
		$mresult=$db->query($msql);
		
		while($mline=$mresult->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sql = "SELECT * from members WHERE member_id=$mline[MEMBER_ID]";
			$res = $db->query($sql);
			$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
			$mid=$row['MEMBER_ID'];		
			
			$new_mid = $db->nextId("AUTO_DEL_MEMBERS_MID");
			$sql = "INSERT INTO del_members VALUES ($new_mid, '$row[LOGIN]', '$row[PASSWORD]', '$row[EMAIL]', $row[STATUS], '$row[PREFERENCES]', '$row[CREATION_DATE]', '$row[MODIF_DATE]', '$row[CUSTOM1]', '$row[CUSTOM2]', '$row[CUSTOM3]', '$row[CUSTOM4]', '$row[CUSTOM5]', '$row[CUSTOM6]', '$row[CUSTOM7]', '$row[CUSTOM8]', '$row[CUSTOM9]', '$row[CUSTOM10]')";
			$res = $db->query($sql);
			$sql = "DELETE FROM members WHERE member_id=$mid";
			$res = $db->query($sql);	
		}
		
		$sql = "DELETE FROM member_groups WHERE group_id=$group";
		$res = $db->query($sql);
		
		$feedback[]=AT_FEEDBACK_USER_GROUP_DELETED;
		print_feedback($feedback);
	}
require ($_include_path.'cc_html/footer.inc.php');

?>