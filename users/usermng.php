<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

if ($_GET['grp']) {
	$group = $_GET['grp'];
	$sql = "SELECT category FROM member_groups WHERE group_id=$group";
	$res = mysql_query($sql, $db);
	$row = mysql_fetch_array($res);
	$category = $row['name'];
}

if ($_POST['category']) {
	$category = $_POST['category'];
	$group = '';
}

if (($_POST['group']) && (!$_POST['form_categ_change'])) {
	$group = $_POST['group'];
}

if ($_POST['c_group']) {
	// create new group
	if ($_POST['grp_name'] == "" ) {
		$errors[] = AT_ERROR_BAD_GROUP_NAME;
	} else {
		$sql = "SELECT name FROM member_groups WHERE name='$grp_name'";
		$res = mysql_query($sql, $db);
		$row = mysql_fetch_array($res);
		if (mysql_num_rows($res) >= 1) {
			$errors[] = AT_ERROR_GROUP_EXISTING;
		} else {
			$sql = "INSERT INTO member_groups VALUES ('$category', 0, '$grp_name', '')"; // no group comments so far
			$res = mysql_query($sql, $db);
			$feedback[] = AT_FEEDBACK_SUCCESS;
		}
	}
}

if ($_POST['policy'] || $_POST['group_change'] || $_POST['enroll'] || $_POST['delete'] || $_POST['mark']){
	if (!$_POST['group_id']) {
		$_POST['group_id'] = 0;
	}
	$sql 	= "SELECT M.*, G.* FROM members M, mrel_groups G WHERE M.member_id=G.member_id AND G.group_id=$_POST[group_id]";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_array($result)) {
		$mid = $row['member_id'];
		if ($_POST['policy']) {
			// action: Policy change
			if ($_POST['m'.$mid]){
				if ($_POST['pol'] == '1') $s = 0;
				else if ($_POST['pol'] == '2') $s = 1;
				else if ($_POST['pol'] == '3') $s = 2;
				$sql = "UPDATE members SET status=$s WHERE member_id=$mid";
				$res = mysql_query($sql, $db);
			}
		} else if ($_POST['group_change']) {
			// action: group change
			if ($_POST['m'.$mid]){
				$sql = "UPDATE mrel_groups SET group_id=$_POST[grp] WHERE member_id=$mid";
				$res = mysql_query($sql, $db);
			}
			
		} else if ($_POST['enroll']) {
			// action: enroll to course
			if ($_POST['m'.$mid]){
				$sql = "INSERT into course_enrollment VALUES ($mid, $_POST[crs], 'y', NOW(), NOW())";
				$res = mysql_query($sql, $db);
			}
			
		} else if ($_POST['delete']) {
			// action: delete users
			if ($_POST['m'.$mid]){
				$sql = "SELECT * FROM members WHERE member_id=$mid";
				$res = mysql_query($sql, $db);
				$row_d = mysql_fetch_array($res);
				$sql = "INSERT INTO del_members VALUES ($row_d[member_id], '$row_d[login]', '$row_d[password]', '$row_d[email]', $row_d[status], '$row_d[preferences]', '$row_d[creation_date]', '$row_d[modif_date]', '$row_d[custom1]', '$row_d[custom2]', '$row_d[custom3]', '$row_d[custom4]', '$row_d[custom5]', '$row_d[custom6]', '$row_d[custom7]', '$row_d[custom8]', '$row_d[custom9]', '$row_d[custom10]')";
				$res = mysql_query($sql, $db);
				
				$sql = "DELETE FROM members WHERE member_id=$mid";
				$res = mysql_query($sql, $db);
				
			}
		} else if ($_POST['mark']) {
			// action: mark course as complete
			if ($_POST['m'.$mid]) {
				$sql = "SELECT * FROM mcourse_completion WHERE member_id=$mid AND course_id=$_POST[crs_c]";
				$res = mysql_query($sql, $db);
				$row_m = mysql_fetch_array($res);
				$sql = "SELECT * FROM course_enrollment WHERE member_id=$mid AND course_id=$_POST[crs_c]";
				$res = mysql_query($sql, $db);
				$row_e =mysql_fetch_array($res);
				if ($row_e['member_id'] == 0) {
					$errors[] = AT_ERROR_NOT_ENROLLED;
				} else {
					if ($row_m['member_id'] == 0) {
						// TBC: update also the grades
						$sql = "INSERT INTO mcourse_completion VALUES ($mid, $_POST[crs_c], 'yes', 0, 0)";
						$res = mysql_query($sql, $db);
					} else {
						// UPDATE the existing values
						$sql = "UPDATE mcourse_completion SET completed='yes' WHERE member_id=$mid AND course_id=$_POST[crs_c]";
						$res = mysql_query($sql, $db);
					}
					$sql = "DELETE FROM course_enrollment WHERE member_id=$mid AND course_id=$_POST[crs_c]";
					$res = mysql_query($sql, $db);
					$sql = "SELECT skill_id FROM skills WHERE course_id=$_POST[crs_c]";
					$res = mysql_query($sql, $db);
					$row_s = mysql_fetch_array($res);
					$sql = "INSERT INTO m_skills VALUES ($mid, $row_s[skill_id])";
					$res = mysql_query($sql, $db);
				}
			}
		}
		
	}
	$feedback[] = AT_FEEDBACK_SUCCESS;
}

require($_include_path.'cc_html/header.inc.php');
?>
<script language="JavaScript">
function change_categ() {
	// allows refreshing the userlist according to the selected category
	document.form_report.form_categ_change.value = "1";
	document.form_report.submit();
}

function change_group() {
	// allows refreshing the user list according to the selected group
	document.form_report.form_group_change.value = "1";
	document.form_report.submit();
}

function CheckAll()
{
  with (document.form_report) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox')
           elements[i].checked = true;
    }
  }
}

function UncheckAll()
{
  with (document.form_report) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox')
           elements[i].checked = false;
    }
  }
}

function confirmDel() {
	alert("<?php echo $_warning[AT_WARNING_DELETE_USER]; ?>");
}
</script>
<?php

echo '<h1 class="left">'.$_template['user_management'].'</h1><br>';

// Showing groups and members

echo '<br><form id="report" method="post" action="'.$PHP_SELF.'" name="form_report">';
	?>
	<table cellspacing="1" cellpadding="0" class="framework" width="95%" summary="">
	<tr>
		<td width="150"><b><?php  echo $_template['existing_users'];  ?>:</b></td>
		<td width="200">
	<?php
	echo '<b>'.$_template['category'].'</b>';
	$sql = "SELECT name FROM member_categ";
	$res = mysql_query($sql, $db);
	
	echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
	while ($row = mysql_fetch_array($res)) {
		echo '<option value="'.$row['name'].'"';
		if ($category == '') {
			$category = $row['name'];
			echo 'selected="selected">'.$row['name'];
		} else if ($category == $row['name']) {
			echo 'selected="selected">'.$row['name'];
		} else {
			echo '>'.$row['name'];
		}
		echo '</option>'."\n";
	}
	echo '</select>&nbsp;'."\n";
	?>
	</td>
	<td width="300">
	<?php 
	echo '<b>'.$_template['group'].'</b>';
	$sql	= "SELECT * FROM member_groups WHERE category='$category'";
	$res	= mysql_query($sql, $db);
	echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group" onChange="change_group();" class="dropdown" id="group" title="Group">'."\n";
	while ($row = mysql_fetch_array($res)) {
		echo '<option value="'.$row['group_id'].'"';
		if ($group == '') {
			$group = $row['group_id'];
			$group_name = $row['name'];
			echo 'selected="selected">'.$row['name'];
		} else if ($group == $row['group_id']) {
			echo 'selected="selected">'.$row['name'];
			$group_name = $row['name'];
		} else {
			echo '>'.$row['name'];
		}
		echo '</option>'."\n";
	}
	echo '</select>&nbsp;'."\n";
	echo '<input type="hidden" name="group_id" value="'.$group.'">';
	$group_id = $group;
	?>
	</td>
	<td>&nbsp;</td>
	</tr>
	</table>
	<br>
	
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
		<tr>
			<th scope="col" width="150"><?php  echo $_template['user_login'];  ?></th>
			<th scope="col" width="100"><?php  echo $_template['policy'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['enrolled_to'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['skills'];  ?></th>
			<th scope="col" colspan="2" align="right"></th>
		</tr>
		
<?php
	echo '<tr><td colspan="5" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	$member_count = 0;
	$sql 	= "SELECT * FROM policy";
	$result = mysql_query($sql, $db);
	$policy = "";
	while ($row=mysql_fetch_array($result)){
		$policy[$row['id']] = $row['name'];
	}
	
	$sql	= "SELECT M.*, G.*, R.* FROM members M, member_groups G, mrel_groups R WHERE M.member_id=R.member_id AND G.group_id=$group_id AND R.group_id=$group_id ORDER BY M.login";
	$res	= mysql_query($sql, $db);
	$member_count = 0;
	while ($row = mysql_fetch_array($res)) {
		$group_id = $row_id['group_id'];
		$mid = $row['member_id'];
		$member_count++;
		echo '<tr><td class="row1" width="15%" valign="top">';
		echo '<input type="checkbox" name="m'.$row['member_id'].'">';
		echo '<small>';
		echo $row['login'];
		echo '</small></td>';
		
		echo '<td class="row1" valign="top">'.$policy[$row['status']+1].'</td>';
		
		echo '<td class="row1" width="25%" valign="top">';
		$sql = "SELECT E.member_id, C.title FROM course_enrollment E, courses C WHERE E.course_id=C.course_id AND E.member_id=$mid";
		$res_e = mysql_query($sql, $db);
		while( $row_e = mysql_fetch_array($res_e) ) {
			echo '&middot;&nbsp;'.$row_e['title'].'<br>';
		}
		echo '</td>';
		
		echo '<td class="row1" width="25%" align="left" valign="top">';
		$sql = "SELECT * FROM m_skills WHERE member_id=$mid";
		$res_s = mysql_query($sql, $db);
		while( $row_s = mysql_fetch_array($res_s) ) {
			if ($row_s[skill_id]) {
				$sql = "SELECT skill_desc FROM skills WHERE skill_id=$row_s[skill_id]";
				$res_2 = mysql_query($sql, $db);
				while ($row_2 = mysql_fetch_array($res_2)) {
					echo '&middot;&nbsp;'.$row_2[skill_desc].'<br>';
				}
			}
		}
		echo '</small></td>';
		
		echo '<td class="row1" align="right" valign="top">';
		echo '<a href="users/member_rep.php?member='.$row['login'].'" class="breadcrumbs">'.$_template['report'].'</a>&nbsp;&nbsp;&nbsp;';
		echo '<a href="users/remove_user.php?mid='.$row['member_id'].'" class="del">'.$_template['remove'].'</a>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
	if ($member_count == 0) {
		echo '<tr><td class="row1" colspan="6"><i>'.$_template['no_users'].'</i></td></tr>';
	} else {
		echo '<tr><td class="row1" colspan="6">';
		echo '<input type="button" class="button2" onClick="CheckAll();" value="'.$_template['select_all_simple'].'">&nbsp;';
		echo ' <input type="button" class="button2" onClick="UncheckAll();" value="'.$_template['unselect_all'].'">';
		echo '</td></tr>';
	}
	
	echo '</table>';
	
	echo '<br />';
	
	echo '<table cellspacing="1" cellpadding="0" border="0" width="90%" summary="" align="center">';
	echo '<tr><td>';
	
	$sql = "SELECT * FROM policy";
	$result = mysql_query($sql, $db);
	
	echo '<table cellspacing="1" cellpadding="0" border="0" class="framework" width="350" summary="">';
	echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['with_selected'].':</h3>';
	echo '</th></tr>';
	echo '<tr><td width="100">';
	echo $_template['assign_policy'].': </td><td>';
	echo '<select name="pol"'.$tip_jump.' class="dropdown" id="pol" title="Jump: '.$_template['accesskey'].' ALT-d">'."\n";
	while ($row=mysql_fetch_array($result)) {
		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="policy" value="'.$_template['apply'].'" class="button2" /></span>&nbsp;';
	echo '</td></tr>';
	
	echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	
	echo '<tr><td width="100">';
	echo $_template['change_group'].': </td><td>';
	$sql = "SELECT * FROM member_groups WHERE category='$category'";
	$result = mysql_query($sql, $db);
	echo '<select name="grp" class="dropdown" id="grp" title="'.$_template['change_group'].'>\n';
	while ($row=mysql_fetch_array($result)){
		echo '<option value="'.$row['group_id'].'">'.$row['name'].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="group_change" value="'.$_template['change'].'" class="button2" />';
	echo '</td></tr>';
	
	echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	
	echo '<tr><td width="100">';
	echo $_template['enroll'].': ';
	echo '</td><td>';
	$sql = "SELECT * FROM courses";
	$result = mysql_query($sql, $db);
	echo '<select name="crs" class="dropdown" id="crs" title="'.$_template['enroll_to'].'">\n';
	while ($row=mysql_fetch_array($result)){
		echo '<option value="'.$row['course_id'].'">'.$row['title'].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="enroll" value="'.$_template['enroll'].'" class="button2" />';
	echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	
	echo '<tr><td width="100">';
	echo $_template['mark_complete'].': ';
	echo '</td><td>';
	$sql = "SELECT * FROM courses";
	$result = mysql_query($sql, $db);
	echo '<select name="crs_c" class="dropdown" id="crs_c" title="'.$_template['mark_complete'].'">\n';
	while ($row=mysql_fetch_array($result)){
		echo '<option value="'.$row['course_id'].'">'.$row['title'].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="mark" value="'.$_template['mark'].'" class="button2" />';
	
	echo '</td></tr>';
	echo '<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	echo '<tr><td colspan="2" align="left" valign="middle">';
	echo '<input type="submit" name="delete" value="'.$_template['delete'].'" class="button_red" /><font color="990000"> delete selected users</font></span>&nbsp;';
	echo '</td></tr></table>';
	echo '<input type="hidden" name="form_group_change">';
	echo '<input type="hidden" name="form_categ_change">';
	
	// ACTIONS: 
	
	echo '</td><td valign="top">';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="framework" width="350" summary="">';
	/*echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['actions'].':</h3>';
	echo '</th></tr>';*/
	echo '<tr><td>';
	echo $_template['create_group'].': <input type="text" size="20" name="grp_name">&nbsp;<input type="submit" class="button2" value="'.$_template['create'].'"name="c_group" id="c_group">';
	echo '</td></tr>';
	echo '<tr><td><a href="users/dyn_group.php?group='.$group.'" class="breadcrumbs">'.$_template['assign_users_to_group'].': '.$group_name.'</a></td></tr>';
	//echo '<tr><td colspan="2" class="row3" height="1"><hr><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	echo '<tr><td><hr></td></tr>';
	echo '<tr><td>';
	echo '<a href=users/adduser.php?grp='.$group.' class="breadcrumbs">'.$_template['add_user'].'</a> ';
	echo '</td></tr><tr><td>';
	echo '<a href=users/userattr.php?grp='.$group.' class="breadcrumbs">'.$_template['define_regfields'].'</a>';
	echo '</td></tr><tr><td>';
	echo '<a href=users/password_policy.php?grp='.$group.' class="breadcrumbs">'.$_template['password_policy'].'</a>';
	echo '</td></tr>';
	
	echo '</table></td></tr></table>';
	echo '</form>';
	
	echo '<br><br><br><br>';
	if ($_SESSION['is_super_admin']) {
		echo '<h4>'.$_template['deleted_users'].'</h4>';
		
	?>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
		<tr>
			<th scope="col" width="150"><?php  echo $_template['user_name'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['group'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['policy'];  ?></th>
			<th scope="col" width="150"><?php  //echo $_template['policy'];  ?></th>
			<th scope="col" colspan="2" align="right"></th>
		</tr>

	<?php
	$sql	= "SELECT * FROM del_members ORDER BY login";
	$res	= mysql_query($sql, $db);
	$member_count = 0;
	while ($row = mysql_fetch_array($res)) {
		$mid = $row['member_id'];
		$sql 	= "SELECT group_id FROM mrel_groups WHERE member_id=$mid";
		
		$res1	= mysql_query($sql, $db);
		$row_g	= mysql_fetch_array($res1);
		$sql 	= "SELECT name FROM member_groups WHERE group_id='$row_g[group_id]'";
		
		$res2	= mysql_query($sql, $db);
		$row2	= mysql_fetch_array($res2);
		$member_count++;
		echo '<tr><td class="row1" width="15%" valign="top">';
		echo '<input type="checkbox" name="md'.$row['member_id'].'">';
		echo '<small>';
		echo $row['login'];
		echo '</small></td>';
		echo '<td class="row1" width="15%" valign="top"><b>'.$row2['name'].'</b></td>';
		echo '<td class="row1" width="15%" valign="top">'.$policy[$row['status']+1].'</td>';
		
		echo '<td class="row1" align="left" valign="top">';
		//echo '<a href="users/member_rep.php?member='.$row['login'].'">'.$_template['report'].'</a> ';//.$pipe;
		// echo ' <a href="users/enroll.php?mid='.$row['member_id'].'">'.$_template['enroll'].'... </a>';
		echo '</small></td>';
		
		echo '<td class="row1" align="right" valign="top">';
		echo '<a href="users/restore_user.php?mid='.$row['member_id'].'">'.$_template['restore'].'</a>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
	if ($member_count == 0) {
		echo '<tr><td class="row1" colspan="6"><i>'.$_template['no_users'].'</i></td></tr>';
	} else {
		/*echo '<tr><td class="row1" colspan="6">';
		echo '<input type="button" class="button2" onClick="CheckAll();" value="'.$_template['select_all_simple'].'">&nbsp;';
		echo ' <input type="button" class="button2" onClick="UncheckAll();" value="'.$_template['unselect_all'].'">';
		echo '</td></tr>';*/
	}
	
	echo '</table>';
	}
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
