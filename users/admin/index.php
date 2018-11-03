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

if ($_GET['remove']) {
	$sql = 'DELETE FROM instructor_approvals WHERE member_id='.intval($_GET['remove']);
	$result = $db->query($sql);
}

require($_include_path.'admin_html/header.inc.php');

$sql	= "SELECT COUNT(*) FROM members WHERE status=1";
$result = $db->query($sql);
$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
$total_instructors = $row[0] ? $row[0] : 0;
unset($row);

$sql	= "SELECT COUNT(*) FROM members WHERE status=0";
$result = $db->query($sql);
$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
$total_students = $row[0] ? $row[0] : 0;
unset($row);

$sql	= "SELECT COUNT(*) FROM courses";
$result = $db->query($sql);
$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);
$total_courses = $row[0] ? $row[0] : 0;

?>
<h2><?php echo SITE_NAME; ?> <?php echo $_template['administration']; ?></h2>

<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="300">
<tr>
	<th class="left" colspan="2"><small><?php echo $_template['general_statistics']; ?></small></th>
</tr>
<tr>
	<td class="row1" align="right" width="10%"><small><?php echo $_template['instructors']; ?>:</small></td>
	<td class="row1"><small><?php echo $total_instructors; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><small><?php echo $_template['students']; ?>:</small></td>
	<td class="row1"><small><?php echo $total_students; ?></small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><small><?php echo $_template['courses']; ?>:</small></td>
	<td class="row1"><small><?php echo $total_courses; ?></small></td>
</tr>
</table>
</p>
<?php


$sql	= "SELECT M.login, M.member_id, A.* FROM members M, instructor_approvals A WHERE A.member_id=M.member_id ORDER BY M.login";
$result = $db->query($sql);
$countsql = "SELECT COUNT(*) FROM (".$sql.")";
$countres = $db->query($countsql);
$count0 = $countres->fetchRow();
$num_pending = $count0[0];
?>
<h2><?php echo $_template['instructor_requests']; ?></h2>
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="">
<tr>
	<th scope="cols"><small><?php echo $_template['username']; ?></small></th>
	<th scope="cols"><small><?php echo $_template['notes']; ?></small></th>
	<th scope="cols"><small><?php echo $_template['request_date']; ?></small></th>
	<th scope="cols"><small><?php echo $_template['remove']; ?></small></th>
	<th scope="cols"><small><?php echo $_template['approve']; ?></small></th>
</tr>
<?php
	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			$counter++;
			echo '<tr>';
			echo '<td class="row1"><small><a href="users/admin/profile.php?member_id='.$row['MEMBER_ID'].'">'.$row['LOGIN'].'</a></small></td>';
			
			echo '<td class="row1"><small>'.$row['NOTES'].'</small></td>';
			echo '<td class="row1"><small>'.substr($row['REQUEST_DATE'], 0, -3).'</small></td>';
			echo '<td class="row1"><small><a href="users/admin/?remove='.$row['MEMBER_ID'].'">'.$_template['remove'].'</a></small></td>';
			echo '<td class="row1"><small><a href="users/admin/admin_edit.php?id='.$row['MEMBER_ID'].'">'.$_template['approve'].'</a></small></td>';

			echo '</tr>';
			if ($counter < $num_pending) {
				echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
			}
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {
		echo '<tr>
			<td class="row1" colspan="5"><small><i>'.$_template['none'].'</i></small></td>
		</tr>';
	}
?>

</table>
</p>
<?php
require($_include_path.'cc_html/footer.inc.php'); 
?>
