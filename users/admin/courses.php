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


if ($_GET['col']) {
	$col = addslashes($_GET['col']);
} else {
	$col = 'title';
}

if ($_GET['order']) {
	$order = addslashes($_GET['order']);
} else {
	$order = 'asc';
}

if ($_GET['member_id']) {
	$and = ' AND C.member_id='.intval($_GET['member_id']);
}

${'highlight_'.$col} = ' style="text-decoration: underline;"';

$sql	= "SELECT C.*, M.login FROM courses C, members M WHERE C.member_id=M.member_id $and ORDER BY $col $order";
$result = mysql_query($sql);

if (!($row = mysql_fetch_array($result))) {
	echo '<h2>'.$_template['courses'].'</h2>';
	echo '<p>'.$_template['no_courses_found'].'</p>';
} else {
	if ($_GET['member_id']) {
		echo '<h2>'.$_template['courses'].' for instructor '.$row['login'].'</h2>';
	} else {
		echo '<h2>'.$_template['courses'].'</h2>';
	}

	$num_rows = mysql_num_rows($result);
?>
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="">
<tr>
	<th scope="col"><small<?php echo $highlight_course_id; ?>><?php echo $_template['id']; ?> <a href="<?php echo $PHP_SELF; ?>?col=course_id<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['id_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=course_id<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['id_descending']; ?>">D</a></small></th>

	<th scope="col"><small<?php echo $highlight_title; ?>><?php echo $_template['title']; ?> <a href="<?php echo $PHP_SELF; ?>?col=title<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['title_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=title<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['title_descending']; ?>">D</a></small></th>

	<th scope="col"><small<?php echo $highlight_login; ?>><?php echo $_template['instructor']; ?> <a href="<?php echo $PHP_SELF; ?>?col=login<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['instructor_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=login<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['instructor_descending']; ?>">D</a></small></th>

	<th scope="col"><small<?php echo $highlight_access; ?>><?php echo $_template['access']; ?>  <a href="<?php echo $PHP_SELF; ?>?col=access<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['access_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=access<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['access_descending']; ?>">D</a></small></th>

	<th scope="col"><small<?php echo $highlight_created_date; ?>><?php echo $_template['created_date']; ?>  <a href="<?php echo $PHP_SELF; ?>?col=created_date<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['created_date_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=created_date<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['created_date_descending']; ?>">D</a></small></th>

	<th scope="col"><small<?php echo $highlight_tracking; ?>><?php echo $_template['tracking']; ?> <a href="<?php echo $PHP_SELF; ?>?col=tracking<?php echo SEP; ?>order=asc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['tracking_ascending']; ?>">A</a>/<a href="<?php echo $PHP_SELF; ?>?col=tracking<?php echo SEP; ?>order=desc<?php echo SEP; ?>member_id=<?php echo $_GET['member_id']; ?>" title="<?php echo $_template['tracking_descending']; ?>">D</a></small></th>

	<th><small>&nbsp;</small></th>
</tr>
<?php
	do {
		echo '<tr>';
		echo '<td class="row1"><small>'.$row['course_id'].'</small></td>';
		echo '<td class="row1"><small><a href="users/admin/course.php?course_id='.$row['course_id'].'"><b>'.$row['title'].'</b></a></small>';

		echo ' <small class="spacer">( <a href="bounce.php?course='.$row['course_id'].'">'.$_template['view'].'</a> )</small>';
		
		echo '</td>';

		echo '<td class="row1"><small><a href="users/admin/profile.php?member_id='.$row['member_id'].'"><b>'.$row['login'].'</b></a></small></td>';
		echo '<td class="row1"><small>'.$_template[$row['access']].'&nbsp;</small></td>';
		echo '<td class="row1"><small>'.$row['created_date'].'&nbsp;</small></td>';
		echo '<td class="row1"><small>'.$_template[$row['tracking']].'&nbsp;</small></td>';
		echo '<td class="row1"><a href="users/delete_course.php?course='.$row['course_id'].SEP.'member_id='.$_GET['member_id'].'"><img src="images/icon_delete.gif" border="0" alt="'.$_template['delete'].'" title="'.$_template['delete'].'"/></a></td>';
		echo '</tr>';
		if ($count < $num_rows-1) {
			echo '<tr><td height="1" class="row2" colspan="7"></td></tr>';
		}
		$count++;
	} while ($row = mysql_fetch_array($result));
	echo '</table></p>';
}

	require($_include_path.'cc_html/footer.inc.php'); 
?>
