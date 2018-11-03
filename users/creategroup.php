<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

require($_include_path.'cc_html/header.inc.php');

	echo '<h1 class="center">'.$_template['user_management'].' - '.$_template['create_group'].'</h1><br>';
		
	if ($_POST['submit']) {
		$sql = "SELECT name FROM member_groups";
		$res = $db->query($sql);
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		if ($row['NAME'] == $_POST['group_name']){
			$errors[] = AT_ERROR_GROUP_NAME_EXISTING;
			print_errors($errors);
		} else {
			$sql = "INSERT INTO member_groups (name) VALUES ('$_POST[group_name]')";
			$res = $db->query($sql);
		}
	}

	// Showing groups and members
	
	echo '<br><form id="report" method="post" action="'.$PHP_SELF.'" name="form_report">';
	?>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
	<tr>
		<th scope="col"><?php  echo $_template['existing_groups'];  ?></th>
	</tr>
<?php
	$member_count = 0;
	$group_count = 0;
	
	$sql	= "SELECT * FROM member_groups";
	$result	= $db->query($sql);
	if ($row_id =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			echo '<tr><td>'.$row_id['NAME'].'<td><tr>';
			$group_count++;
		} while ($row_id =$result->fetchRow(DB_FETCHMODE_ASSOC));
	}
	if ($group_count == 0) {
		echo '<tr><td class="row1" colspan="3"><i>'.$_template['no_groups'].'</i></td></tr>';
	}
	
	echo '</table>';

	echo '<br />';

	echo '<table cellspacing="1" cellpadding="0" border="0" width="90%" summary="" align="center">';
	echo '<tr><td>';
	
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="350" summary="">';
	echo '<tr><td width="100">';
	echo $_template['create_group'].': </td><td>';
	echo '<input type="text" name="group_name">';
	echo '<input type="submit" name="submit" value="'.$_template['create'].'" class="button2" /></span>&nbsp;';
	echo '</td></tr>';
	echo '</table>';
	echo '</form>';	
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
