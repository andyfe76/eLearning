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
	if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
		echo '<form name="coursemng" action="'.$PHP_SELF.'" method="post">';
		echo '<table cellspacing="0" cellpadding="0" border="0" class="framework" summary="">';
		/*echo '<tr><th colspan="2">';
		echo '<h3>'.$_template['actions'].':</h3>';
		echo '</th></tr>';
		echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
		*/
		echo '<tr><td class="rowa1" width="150">';	
		echo '<a href="users/cgroup.php" class="framewk"><img border="0" src="images/menu/new_module.gif"> '.$_template['new_module'].'</a><br><a class="framewk" href="users/create_course.php"><img border="0" src="images/menu/new_course.gif"> '.$_template['new_course'].'</a></td>';
		echo '<td class="rowa1"><a href=users/test_admin.php class="framewk"><img border="0" src="images/menu/options.gif"> '.$_template['course_administration_options'].'</a><br>';
		echo '<a href=users/courseattr.php?grp='.$group.' class="framewk"><img border="0" src="images/menu/reg_fields.gif"> '.$_template['define_regfields'].'</a>';
		echo '</td></tr>';
			
		echo '</table><br>';
		echo '</form>';
	}

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
	$res_id	= $db->query($sql);
	$course_count = 0;
	while ($row_id =$res_id->fetchRow(DB_FETCHMODE_ASSOC)) {
		$group_id = $row_id['GROUP_ID'];
	
		$sql	= "SELECT C.*, R.* FROM course_groups C, crel_groups R WHERE C.group_id=$group_id AND R.group_id=$group_id ORDER BY C.name";
		$res	= $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		$numg	= $count0[0];
		$group_count = 0;
		$alternate = 1;
		
		while ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$course_id = $rowg['COURSE_ID'];
			$sql	= "SELECT * FROM courses WHERE course_id=$course_id";
			$result = $db->query($sql);
			$countsql = "SELECT COUNT(*) FROM (".$sql.")";
			$countres = $db->query($countsql);
			$count0 = $countres->fetchRow();
	
			$num = $count0[0];
			$count = 1;
			
			while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($group_count == 0) { ?>
				</table>
				<br>
				<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
				<tr>
					<th width="30"><font color="Blue"><?php echo $_template['module'].': '.$rowg['NAME']; ?></font></th>
					<th width="60%"><?php echo $rowg['COMMENTS']; ?></th>
					<th scope="col" align="right">
						<?php
						if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
						?>
							<table align="right" border="0"><tr><td><a href="users/delete_module.php?mod=<?php echo $group_id; ?>"><img src="images/menu/delete_module.gif" border="0"></a></td><td><a style="font-size:7pt;" href="users/delete_module.php?mod=<?php echo $group_id; ?>"><?php echo $_template['delete_module']; ?></a></td></tr></table>
						<?php
						}
						?>
					</th>
				</tr>
				
				<?php 
				echo '<tr><td colspan="3" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
				}
				echo '<tr><td class="rowa'.$alternate.'" width="150" valign="top"><b>';
				echo '<a href="bounce.php?course='.$row['COURSE_ID'].'">'.$row['TITLE'].' </a>';
				echo '</b></td><td class="rowa'.$alternate.'" valign="top">';
				echo '<small>';
				echo $row['DESCRIPTION'];
				echo '<br /><br />&middot; '.$_template['access'].': ';
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
						/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID] AND approved='n'";
						$c_result = $db->query($sql);
						$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
						$num_rows_c = mysql_num_rows($c_result);*/
						break;
				}
				$sql	  = "SELECT COUNT(*) as enrolled FROM course_enrollment WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  = $c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				echo '<br />&middot; '.$_template['enrolled'].': '.($c_row['ENROLLED']).' '.$pending.'<br />';
				echo '&middot; '.$_template['created'].': '.$row[CREATED_DATE].'<br />';
	
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
				echo '&middot; '.$_template['logins'];
				if ($row['ACCESSTYPE'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[COURSE_ID].SEP.'a='.$row['ACCESSTYPE'].'">'.$_template['details'].'</a><br />';
	
				echo '</small></td>';
	
				echo '<td class="rowa'.$alternate.'" valign="top">';
				
					echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
					echo '<td class="row1" align="center"><small><a href="users/course_properties.php?course='.$row[COURSE_ID].'"><img src="images/menu/properties.gif" border="0" alt="'.$_template['properties'].'"></a></td>';
					echo '<td class="row1" align="center"><a href="users/enroll_admin.php?course='.$row[COURSE_ID].'"><img src="images/menu/enrollment.gif" border="0" alt="'.$_template['enrolments'].'"></a></td>';
					echo '<td class="row1" align="center"><a href="users/export.php?course='.$row[COURSE_ID].'"><img src="images/export.gif" border="0" alt="'.$_template['import_export'].'"</a></td>';
					echo '<td class="row1" align="center"><a href="users/course_email.php?course='.$row[COURSE_ID].'"><img src="images/menu/email.gif" border="0" alt="'.$_template['course_email'].'"</a></td>';
					//echo '<td class="row1" align="center"><a href="users/export_pdf.php?course='.$row[COURSE_ID].'"><img src="images/menu/ad-pdf.gif" border="0"><br>'.$_template['pdf_export'].'</a></td>';					
					if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
						echo '<td class="row1" align="center"><a href="users/delete_course.php?course='.$row[COURSE_ID].'"><img src="images/menu/delete.gif" border="0" alt="'.$_template['delete'].'"</a></td>';
					}
					echo '</tr></table>';
				
				echo '</td></tr>';
	
				if ($count < $num-1) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
				$group_count++;
				$course_count++;
			}
			$alternate++;
		if ($alternate>2) $alternate = 1;
		}
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
		$result = $db->query($sql);
		
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		$num = $count0[0];
		$count = 1;
		
		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			do {
				echo '<tr><td class="row1" width="150" valign="top"><b>';
				echo $row['TITLE'];
				echo '</b></td><td class="row1" valign="top">';
				echo '<small>';
				echo $row['DESCRIPTION'];
				echo '<br /><br />&middot; '.$_template['access'].': ';
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
						/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID] AND approved='n'";
						$c_result = $db->query($sql);
						$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
						$num_rows_c = mysql_num_rows($c_result);*/
						break;
				}
				/*$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);*/
		
				/* minus 1 because the instructor doesn't count */
				//echo '<br />&middot; '.$_template['enrolled'].': '.($c_row[0]-1).' '.$pending.'<br />';
				echo '<br> &middot; '.$_template['created'].': '.$row[CREATED_DATE].'<br />';
		
				$sql	  = "SELECT SUM(guests) AS guests, SUM(members) AS members FROM course_stats WHERE course_id=$row[COURSE_ID]";
				$c_result = $db->query($sql);
				$c_row	  =$c_result->fetchRow(DB_FETCHMODE_ASSOC);
		
				/*echo '&middot; '.$_template['logins'];
				if ($row['ACCESSTYPE'] != 'private') {
					echo ' G: '.($c_row[guests] ? $c_row[guests] : 0).', ';
				}
				echo ' M: '.($c_row[members] ? $c_row[members] : 0).'. <a href="users/course_stats.php?course='.$row[COURSE_ID].SEP.'a='.$row['ACCESSTYPE'].'">'.$_template['details'].'</a><br />';
				*/
				echo '</small></td>';
		
				echo '<td class="row1" valign="top"><small>&middot; <a href="users/course_properties.php?course='.$row[COURSE_ID].'">'.$_template['properties'].'</a><br />';
		
				echo '<br />&middot; <a href="users/restore.php?course='.$row[COURSE_ID].'">'.$_template['restore'].'</a></small></td>';
				echo '</tr>';
		
				if ($count < $num-1) {
					echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
				}
				$count++;
			} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
		}
	
		echo '</table><br />';
	}
	require ($_include_path.'cc_html/footer.inc.php');
?>
