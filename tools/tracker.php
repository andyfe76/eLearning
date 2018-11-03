<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];
$member_id=$_SESSION['member_id'];
require($_include_path.'header.inc.php');
$warnings[]=AT_WARNING_EXPERIMENTAL11;
print_warnings($warnings);

//get names for member_ids
$sql14 = "select member_id, login from members";
$result14=$db->query($sql14);
while($row=$result14->fetchRow(DB_FETCHMODE_ASSOC)){
	$this_user[$row['MEMBER_ID']]= $row['LOGIN'];
}

/////////////////////////////
// Top of the page

?>
<h2><a href="tools/?g=11"><?php echo $_template['tools']; ?></a></h2>
<h3><a href="tools/?g=11"><?php echo $_template['my_tracker']; ?></a></h3>
<?php

//see if tracking is turned on
$sql="SELECT tracking FROM courses where course_id=$_SESSION[course_id]";
$result=$db->query($sql);
while($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
	if($row['TRACKING']== "off"){
		if($_SESSION['is_admin']){
			$infos[]=AT_INFOS_TRACKING_OFFIN;
		}else{
			$infos[]=AT_INFOS_TRACKING_OFFST;
		}
	print_infos(AT_INFOS_TRACKING_OFFIN);
	require($_include_path.'footer.inc.php');
	exit;
	}
}

if($_SESSION['is_admin']) {
	print_infos(AT_INFOS_TRACKING_NO_INST1);
} else {
	require($_include_path.'lib/tracker.inc.php');

}
//echo array_values($this_data);

	require($_include_path.'footer.inc.php');
?>
