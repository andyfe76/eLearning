<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$section = 'users';
$_include_path = '../../include/';
require($_include_path.'vitals.inc.php');
if (!$_SESSION['s_is_super_admin']) {
	exit;
}

require($_include_path.'admin_html/header.inc.php');

$member_id = intval($_GET['member_id']);

$sql	= "SELECT * FROM members WHERE member_id=$member_id";
$result	= $db->query($sql);

if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))) {
	echo $_template['no_user_found'];
	require($_include_path.'cc_html/footer.inc.php');
	exit;
}
?>
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="">
<tr>
	<th colspan="2" class="left"><?php 
		echo $_template['profile_for'].' '. $row['LOGIN'];
	?></th>
</tr>
<tr>
	<td class="row1"><?php echo $_template['username']; ?>:</td>
	<td class="row1"><?php echo $row['LOGIN']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['member_id']; ?>:</td>
	<td class="row1"><?php echo $row['MEMBER_ID']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['password']; ?>:</td>
	<td class="row1"><?php echo $row['PASSWORD']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['email_address']; ?>:</td>
	<td class="row1"><a href="mailto:<?php echo $row['EMAIL']; ?>"><?php echo $row['EMAIL']; ?></a></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php  echo $_template['role']; ?>:</td>
	<td class="row1"><a href="users/admin/admin_edit.php?id=<?php echo $row['MEMBER_ID']; ?>"><?php
		if ($row['STATUS']) {
			echo $_template['instructor'].'</a>,  <a href="users/admin/courses.php?member_id='.$row['MEMBER_ID'].'">View Courses</a>';
		} else {
			echo $_template['student1'].'</a>';
		}
	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php  echo $_template['created_date']; ?></td>
	<td class="row1"><?php echo $row['CREATION_DATE']; ?></td>
</tr>
</table>
</p>
<?php
	require($_include_path.'cc_html/footer.inc.php');
?>
