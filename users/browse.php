<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');


bif ((!$_SESSION['c_instructor'])||(!$_SESSION['is_admin'])) {
	
	require ($_include_path.'header.inc.php');	
	print_errors(AT_ERROR_ACCESS_DENIED);
	require ($_include_path.'footer.inc.php');
	exit;
	}

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
	$res_id	= $db->query($sql);
	if ($row_id =$res_id->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
		$group_id = $row_id['GROUP_ID'];
	
		$sql	= "SELECT C.*, R.* FROM course_groups C, crel_groups R WHERE C.group_id=$group_id AND R.group_id=$group_id ORDER BY C.name";
		$res	= $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		$numg	= $count0[0];
		$group_count = 0;
		
		if ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			do {
			$course_id = $rowg['COURSE_ID'];
	
			$sql	= "SELECT * FROM courses WHERE hide=0 AND course_id=$course_id ORDER BY title";
			$result = $db->query($sql);
		
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
			$num = $count0[0];
			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				do {
					if ($group_count == 0) { ?>
					</table>
					<br>
					<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
					<tr>
						<th width="150"><?php echo $rowg['NAME']; ?></th>
						<th><?php echo $rowg['COMMENTS']; ?></th>
					</tr>
					<?php 
					}
					echo '<tr><td class="row1" width="150" valign="top"><b>';
					echo '<a href="bounce.php?course='.$row[COURSE_ID].'">'.$system_courses[$row[COURSE_ID]][title].'</a>';
		
					echo '</b></td><td class="row1" valign="top">';
					echo '<small>';
					echo $row[DESCRIPTION];
	
						echo '<br /><br />&middot; '. $_template['access'].': ';
					$pending = '';
					switch ($row['ACCESSTYPE']){
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
					$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID] AND approved='y'";
					$c_result = $db->query($sql);
					$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
		
					/* minus 1 because the instructor doesn't count */
					echo '<br />&middot; '.$_template['enrolled'].': '.max(($c_row[0]-1), 0).'<br />';
					echo '&middot; '. $_template['created'].': '.$row[CREATED_DATE].'<br />';
					echo '&middot; <a href="users/contact_instructor.php?course='.$row[COURSE_ID].'">'.$_template['contact_instructor_form'].'</a>';
		
					echo '</small></td>';
					echo '</tr>';
					if ($count < $num-1) {
						echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
					}
					$count++;
					$group_count++;
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
			} else {
				echo '<tr><td class=row1 colspan=3><i>'.$_template['no_courses'].'</i></td></tr>';
			}
		
			} while ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC));
		}
		} while ($row_id =$res_id->fetchRow(DB_FETCHMODE_ASSOC));
	}
	
	echo '</table>';

	require($_include_path.'cc_html/footer.inc.php');
?>
