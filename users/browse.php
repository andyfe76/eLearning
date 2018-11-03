<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

require($_include_path.'cc_html/header.inc.php');

?>
<h2><?php //echo $_template['browse_courses']; ?></h2>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr>
		<th width="150"><?php echo $_template['course_name']; ?></th>
		<th><?php echo $_template['description']; ?></th>
	</tr>
<?php
	$sql	= "SELECT * FROM course_groups";
	$res_id	= mysql_query($sql, $db);
	if ($row_id = mysql_fetch_array($res_id)) {
		do {
		$group_id = $row_id['group_id'];
	
		$sql	= "SELECT C.*, R.* FROM course_groups C, crel_groups R WHERE C.group_id=$group_id AND R.group_id=$group_id ORDER BY C.name";
		$res	= mysql_query($sql, $db);
		$numg	= mysql_num_rows($res);
		$group_count = 0;
		
		if ($rowg = mysql_fetch_array($res)) {
			do {
			$course_id = $rowg['course_id'];
	
			$sql	= "SELECT * FROM courses WHERE hide=0 AND course_id=$course_id ORDER BY title";
			$result = mysql_query($sql,$db);
		
			$num = mysql_num_rows($result);
			if ($row = mysql_fetch_array($result)) {
				do {
					if ($group_count == 0) { ?>
					</table>
					<br>
					<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
					<tr>
						<th width="150"><?php echo $rowg['name']; ?></th>
						<th><?php echo $rowg['comments']; ?></th>
					</tr>
					<?php 
					}
					echo '<tr><td class="row1" width="150" valign="top"><b>';
					echo '<a href="bounce.php?course='.$row[course_id].'">'.$system_courses[$row[course_id]][title].'</a>';
		
					echo '</b></td><td class="row1" valign="top">';
					echo '<small>';
					echo $row[description];
	
						echo '<br /><br />&middot; '. $_template['access'].': ';
					$pending = '';
					switch ($row['access']){
						case 'public':
							echo $_template['public'];
							break;
						case 'protected':
							echo $_template['protected'];
							break;
						case 'private':
							echo $_template['private'];
							break;
					}
					$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='y'";
					$c_result = mysql_query($sql, $db);
					$c_row	  = mysql_fetch_array($c_result);
		
					/* minus 1 because the instructor doesn't count */
					echo '<br />&middot; '.$_template['enrolled'].': '.max(($c_row[0]-1), 0).'<br />';
					echo '&middot; '. $_template['created'].': '.$row[created_date].'<br />';
					echo '&middot; <a href="users/contact_instructor.php?course='.$row[course_id].'">'.$_template['contact_instructor_form'].'</a>';
		
					echo '</small></td>';
					echo '</tr>';
					if ($count < $num-1) {
						echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
					}
					$count++;
					$group_count++;
				} while ($row = mysql_fetch_array($result));
			} else {
				echo '<tr><td class=row1 colspan=3><i>'.$_template['no_courses'].'</i></td></tr>';
			}
		
			} while ($rowg = mysql_fetch_array($res));
		}
		} while ($row_id = mysql_fetch_array($res_id));
	}
	
	echo '</table>';

	require($_include_path.'cc_html/footer.inc.php');
?>
