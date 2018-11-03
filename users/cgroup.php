<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');
require($_include_path.'admin_check.inc.php');

require($_include_path.'cc_html/header.inc.php');



	echo '<h1 class="center">'.$_template['course_management'].' - '.$_template['course_modules'].'</h1><br>';
		
	if ($_POST['submit']) {
		$sql = "SELECT name FROM course_groups";
		$res = $db->query($sql);
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		if ($row['NAME'] == $_POST['group_name']){
			$errors[] = AT_ERROR_GROUP_NAME_EXISTING;
			print_errors($errors);
		} else {
			$gid = $db->nextId("AUTO_COURSE_GROUPS_SEQ");
			$sql = "INSERT INTO course_groups VALUES ($gid, '$_POST[group_name]', '')";
			$res = $db->query($sql);
		}
	}

	// Showing groups and members
	
	echo '<br><form id="form_group" method="post" action="'.$PHP_SELF.'" name="form_group">';
	?>
	<table cellspacing="3" cellpadding="0" border="0" class="bodyline" width="300" summary="">
	<tr>
		<th scope="col"><?php  echo $_template['existing_modules'];  ?></th>
	</tr>
<?php
	$group_count = 0;
	
	$sql	= "SELECT * FROM course_groups";
	$result	= $db->query($sql);
	if ($row_id =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$alternate = 1;
		do {
			echo '<tr><td class="rowa'.$alternate.'">'.$row_id['NAME'].'<td>'."\n";
			echo '<td class="rowa'.$alternate.'"><a href="users/delete_module.php?mod='.$row_id['GROUP_ID'].'">'.$_template['delete_module'].'</a></td>'."\n";
			echo '</tr>';
			$group_count++;
			$alternate++;
			if ($alternate >2) $alternate = 1;
		} while ($row_id =$result->fetchRow(DB_FETCHMODE_ASSOC));
	}
	if ($group_count == 0) {
		echo '<tr><td class="row1" colspan="3"><i>'.$_template['no_cgroups'].'</i></td></tr>';
	}
	
	echo '</table>';

	echo '<br />';

	echo '<table cellspacing="1" cellpadding="0" border="0" width="300" summary="">';
	echo '<tr><td>';
	
	echo '<table cellspacing="4" cellpadding="0" border="0" class="bodyline" width="300" summary="">';
	echo '<tr><td>';
	echo $_template['create_module'].': </td><td>';
	echo '<input type="text" name="group_name">';
	echo '&nbsp;&nbsp;<input type="submit" name="submit" value="'.$_template['create'].'" class="button2" /></span>&nbsp;';
	echo '</td></tr>';
	echo '</table>';
	echo '</form>';	
	echo '</td></tr></table>';
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
