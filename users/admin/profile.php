<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
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
$result	= mysql_query($sql, $db);

if (!($row = mysql_fetch_array($result))) {
	echo $_template['no_user_found'];
	require($_include_path.'cc_html/footer.inc.php');
	exit;
}
?>
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="">
<tr>
	<th colspan="2" class="left"><?php 
		echo $_template['profile_for'].' '. $row['login'];
	?></th>
</tr>
<tr>
	<td class="row1"><?php echo $_template['username']; ?>:</td>
	<td class="row1"><?php echo $row['login']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['member_id']; ?>:</td>
	<td class="row1"><?php echo $row['member_id']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['password']; ?>:</td>
	<td class="row1"><?php echo $row['password']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php echo $_template['email_address']; ?>:</td>
	<td class="row1"><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php  echo $_template['status']; ?>:</td>
	<td class="row1"><a href="users/admin/admin_edit.php?id=<?php echo $row['member_id']; ?>"><?php
		if ($row['status']) {
			echo $_template['instructor'].'</a>,  <a href="users/admin/courses.php?member_id='.$row['member_id'].'">View Courses</a>';
		} else {
			echo $_template['student1'].'</a>';
		}
	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1"><?php  echo $_template['created_date']; ?></td>
	<td class="row1"><?php echo $row['creation_date']; ?></td>
</tr>
</table>
</p>
<?php
	require($_include_path.'cc_html/footer.inc.php');
?>
