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

if ($_POST['submit']) {
	$quota  = intval($_POST['quota']);
	$max	= intval($_POST['max_file_size']);
	if (intval($_POST['tracking'])){
		$tracking = $_template['on'];
	} else {
		$tracking = $_template['off'];
	}

	$course	= intval($_POST['course']);
	$sql	= "UPDATE courses SET max_quota=$quota, max_file_size=$max, tracking='$_POST[tracking]' WHERE course_id=$course";
	$result = mysql_query($sql, $db);

	Header('Location: courses.php?f='.urlencode_feedback(AT_FEEDBACK_COURSE_UPDATED));
	exit;
}

require($_include_path.'admin_html/header.inc.php');

$course_id = intval($_GET['course_id']);

$sql	= "SELECT * FROM courses WHERE course_id=$course_id";
$result	= mysql_query($sql, $db);

if (!($row = mysql_fetch_array($result))) {
	echo 'Course not found.';
	require($_include_path.'cc_html/footer.inc.php'); 
	exit;
}
?>
<h2><?php  echo $_template['course_properties']; ?></h2>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<input type="hidden" name="course" value="<?php echo $course_id; ?>" />
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" width="90%">
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['title']; ?>:</b></td>
	<td class="row1"><?php echo $row['title']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['course_id']; ?></b></td>
	<td class="row1"><?php echo $row['course_id']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['instructor']; ?>:</b></td>
	<td class="row1"><?php 
		echo '<a href="users/admin/profile.php?member_id='.$row['member_id'].'">'.get_login($row['member_id']).'</a>';
	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['access']; ?>:</b></td>
	<td class="row1"><?php echo ucwords($row['access']); ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" nowrap="nowrap" align="right"><b><?php  echo $_template['created_date']; ?>:</b></td>
	<td class="row1"><?php echo $row['created_date']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><?php  echo $_template['description']; ?>:</b></td>
	<td class="row1"><?php echo $row['description']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['notify']; ?>:</b></td>
	<td class="row1"><?php echo ($row['notify'] ? $_template['yes'] : $_template['no']); ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><b><?php  echo $_template['enrolled']; ?>:</b></td>
	<td class="row1"><?php 

		$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='y'";
		$c_result = mysql_query($sql, $db);
		$c_row	  = mysql_fetch_array($c_result);

		echo ($c_row[0]-1);

	?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right"><label for="quota"><b><?php  echo $_template['course_quota']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="quota" name="quota" class="formfieldR" value="<?php echo intval($row['max_quota']); ?>" size="6" /> <?php echo $_template['bytes']; ?> <small class="spacer">(<?php
	if ($row['max_quota'] != -1) {
		echo '~'.round($row['max_quota']/1024/1024).' MB. '; 
	}?><?php echo $_template['default']; ?>: <?php echo $MaxCourseSize; ?>*. <?php echo $_template['unlimited']; ?>.)</small></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><label for="max"><b><?php  echo $_template['max_file_size']; ?>:</b></label></td>
	<td class="row1"><input type="text" id="max" name="max_file_size" class="formfieldR" value="<?php echo intval($row['max_file_size']); ?>" size="6" /> <?php echo $_template['bytes']; ?> <small class="spacer">(<?php

	echo '~'.round($row['max_file_size']/1024).' KB'; 
	
	?>. <?php echo $_template['default']; ?>: <?php
	echo $MaxFileSize; 
	echo '* '.$_template['max'].': ';
	echo (substr(ini_get('upload_max_filesize'), 0, -1) * 1024 * 1024);

	?> B.)</small><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="right" valign="top"><b><?php  echo $_template['tracking']; ?></b></td>
	<td class="row1">		<?php
		if($row['tracking'] == 'on'){
			$on = ' checked="checked" ';
		} else {
			$off = ' checked="checked" ';
		}
		?>
		<input type="radio" name="tracking" value="off" id="toff" <?php echo $off; ?>><label for="toff"><?php  echo $_template['off']; ?></label> <input type="radio" name="tracking" value="on" id="ton"<?php echo $on; ?>><label for="ton"><?php  echo $_template['on']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td colspan="2" class="row1" align="center"><input type="submit" name="submit" value="<?php  echo $_template['update_course_properties']; ?>" class="button" /></td>
</tr>

</table>
</p>
<p style="width: 95%"><small class="spacer">* <?php echo $_template['default_max']; ?></small>
</p>
</form>
<?php
	require($_include_path.'cc_html/footer.inc.php'); 
?>
