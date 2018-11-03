<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

	if ($_GET['grp']) {
		$group = $_GET['grp'];
	}
	
	if ($_POST['save']) {
		for ($i=1; $i<=10; $i++) {
			$name = $_POST['custom'.$i];
			if ($_POST['mandatory'.$i] <> "") {
				$mandatory = 1;
			} else {
				$mandatory = 0;
			}
			$sql = "UPDATE user_custom_fields SET name='$name', mandatory=$mandatory WHERE id=$i";
			$res = $db->query($sql);
		}
		$feedback[] = AT_FEEDBACK_SUCCESS;
		Header('Location: usermng.php?grp='.$group);
	}


require($_include_path.'cc_html/header.inc.php');

	echo '<h1 class="center">'.$_template['user_management'].'</h1><br>';
		
	// Showing existing fields
	
	echo '<br><form id="regfields" method="post" action="'.$PHP_SELF.'" name="form_regfields">';
	echo '<input type="hidden" name="grp" value='.$group.'>';
	?>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="250" summary="">
	<tr>
		<th colspan="2" scope="col"><?php  echo $_template['custom_regfields'];  ?></th>
	</tr><tr>
		<th><?php echo $_template['field_name']; ?></th>
		<th><?php echo $_template['mandatory']; ?></th>
	</tr>
	<?php
		$sql = "SELECT * FROM user_custom_fields ORDER BY id";
		$res = $db->query($sql);
		$i = 1;
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo '<tr><td class="row1">';
			echo '<input id="custom'.$i.'" class="formfield" name="custom'.$i.'" type="text" size="20" value="'.$row['NAME'].'"></td>'."\n";
			echo '<td class="row1" align="center"><input id="mandatory'.$i.'" name="mandatory'.$i.'" type="checkbox" ';
				if ($row['MANDATORY'] >0) {
					echo 'checked="checked">';
				} else {
					echo '>';
				}
			echo "\n".'</td></tr>';
			$i++;
		}	
		
	?>
	</table>
	<br>
	<input type="submit" name="save" id="save" class="button" value="<?php echo $_template['save'] ?>">
<?php
	echo '</form>';	

	require ($_include_path.'cc_html/footer.inc.php');
?>
