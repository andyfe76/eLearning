<?php
$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
$_SESSION['s_is_super_admin'] = false;

require($_include_path.'cc_html/header.inc.php');

print_errors($errors);
?>
<h1 class="center"><?php echo $_template['course_management'];  ?></h1><br>
<br>

<?php
	echo '<form name="coursemng" action="'.$PHP_SELF.'" method="post">';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="framework" width="350" summary="">';
	/*echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['actions'].':</h3>';
	echo '</th></tr>';
	echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	*/
	echo '<tr><td>';	
	echo '<a href="users/cgroup.php">'.$_template['new_module'].'</a><br><a href="users/create_course.php">'.$_template['new_course'].'</a></td>';
	echo '<td><a href=users/test_admin.php>'.$_template['course_administration_options'].'</a><br>';
	echo '<a href=users/courseattr.php?grp='.$group.'>'.$_template['define_regfields'].'</a>';
	echo '</td></tr>';
		
	echo '</table><br>';
	echo '</form>';

	//echo '<b>'.$_template['browse_courses'].'</b><br>';
?>	
<br>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<!-- tr>
		<th scope="col" width="150"><?php  //echo $_template['course_name'];  ?></th>
		<th scope="col"><?php  //echo $_template['description'];  ?></th>
		<th scope="col" width="150"><?php  //echo $_template['properties'];  ?></th>
	</tr -->
<?php
	$sql	= "SELECT * FROM course_groups";
	$res_id	= mysql_query($sql, $db);
	$course_count = 0;
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
		
			$sql	= "SELECT * FROM courses C WHERE course_id=$course_id ORDER BY title";
			$result = mysql_query($sql,$db);
		
			$num = mysql_num_rows($result);
			$count = 1;
			
			if ($row = mysql_fetch_array($result)) {
				do {
					if ($group_count == 0) { ?>
					</table>
					<br>
					<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
					<tr>
						<th width="150"><font color="Blue"><?php echo $_template['module'].': '.$rowg['name']; ?></font></th>
						<th><?php echo $rowg['comments']; ?></th>
						<th scope="col" width="150">&nbsp;</th>
					</tr>
					
					<?php 
					echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
					}
					echo '<tr><td class="row1" width="150" valign="top"><b>';
					echo '<a href="bounce.php?course='.$row['course_id'].'">'.$row['title'].'</a>';
					echo '</b></td><td class="row1" valign="top">';
					echo '<small>';
					echo $row['description'];
					echo '<br /><br />&middot; '.$_template['access'].': ';
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
							/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='n'";
							$c_result = mysql_query($sql, $db);
							$c_row	  = mysql_fetch_array($c_result);
							$num_rows_c = mysql_num_rows($c_result);*/
							break;
					}
					$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id]";
					$c_result = mysql_query($sql, $db);
					$c_row	  = mysql_fetch_array($c_result);
		
					echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]).' '.$pending.'<br />';
					echo '&middot; '.$_template['created'].': '.$row[created_date].'<br />';
		
					$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[course_id]";
					$c_result = mysql_query($sql, $db);
					$c_row	  = mysql_fetch_array($c_result);
		
					echo '&middot; '.$_template['logins'];
					if ($row['access'] != 'private') {
						echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
					}
					echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[course_id].SEP.'a='.$row['access'].'">'.$_template['details'].'</a><br />';
		
					echo '</small></td>';
		
					echo '<td class="row1" valign="top"><small>&middot; <a href="users/course_properties.php?course='.$row[course_id].'">'.$_template['properties'].'</a><br />';
		
					echo '&middot; <a href="users/enroll_admin.php?course='.$row[course_id].'">'.$_template['enrolments'].'</a><br />';
					echo '&middot; <a href="users/course_email.php?course='.$row[course_id].'">'.$_template['course_email'].'</a><br />';
					echo '&middot; <a href="users/export.php?course='.$row[course_id].'">'.$_template['import_export'].'</a><br />';
					echo '<br />&middot; <a href="users/delete_course.php?course='.$row[course_id].'">'.$_template['delete'].'</a></small></td>';
					echo '</tr>';
		
					if ($count < $num-1) {
						echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
					}
					$count++;
					$group_count++;
					$course_count++;
				} while ($row = mysql_fetch_array($result));
			}
		
			} while ($rowg = mysql_fetch_array($res));
		}
		} while ($row_id = mysql_fetch_array($res_id));
	}
	if ($course_count == 0) {
		echo '<tr><td class="row1" colspan="3"><i>'.$_template['no_enrolments'].'</i></td></tr>';
	}
	
	
	
	echo '</table>';
	
	if ($_SESSION['is_super_admin'] == 1){
		echo '<br><h4>'.$_template['deleted_courses'].'</h4>';
		?>
		<br>
		<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
		<tr>
			<th scope="col" width="150"><?php  echo $_template['course_name'];  ?></th>
			<th scope="col"><?php  echo $_template['description'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['properties'];  ?></th>
		</tr>
		<?php
		
		$sql	= "SELECT * FROM del_courses C ORDER BY title";
		$result = mysql_query($sql,$db);
		
		$num = mysql_num_rows($result);
		$count = 1;
		
		if ($row = mysql_fetch_array($result)) {
			do {
				echo '<tr><td class="row1" width="150" valign="top"><b>';
				echo $row['title'];
				echo '</b></td><td class="row1" valign="top">';
				echo '<small>';
				echo $row['description'];
				echo '<br /><br />&middot; '.$_template['access'].': ';
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
						/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='n'";
						$c_result = mysql_query($sql, $db);
						$c_row	  = mysql_fetch_array($c_result);
						$num_rows_c = mysql_num_rows($c_result);*/
						break;
				}
				/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id]";
				$c_result = mysql_query($sql, $db);
				$c_row	  = mysql_fetch_array($c_result);*/
		
				/* minus 1 because the instructor doesn't count */
				//echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]-1).' '.$pending.'<br />';
				echo '<br> &middot; '.$_template['created'].': '.$row[created_date].'<br />';
		
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[course_id]";
				$c_result = mysql_query($sql, $db);
				$c_row	  = mysql_fetch_array($c_result);
		
				/*echo '&middot; '.$_template['logins'];
				if ($row['access'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[course_id].SEP.'a='.$row['access'].'">'.$_template['details'].'</a><br />';
				*/
				echo '</small></td>';
		
				echo '<td class="row1" valign="top"><small>&middot; <a href="users/course_properties.php?course='.$row[course_id].'">'.$_template['properties'].'</a><br />';
		
				echo '<br />&middot; <a href="users/restore.php?course='.$row[course_id].'">'.$_template['restore'].'</a></small></td>';
				echo '</tr>';
		
				if ($count < $num-1) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
			} while ($row = mysql_fetch_array($result));
		}
	
		echo '</table><br />';
	}
	require ($_include_path.'cc_html/footer.inc.php');
?>