<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

	if ($_GET['grp']) {
		$group = $_GET['grp'];
	}
	
	if ($_POST['save']) {
		$sql = "SELECT * FROM policy";
		$res = mysql_query($sql, $db);
		$i=1;
		while ($row = mysql_fetch_array($res)) {
			$exp = $_POST['exp'.$i];
			$status = $row['id'];
			$sql = "UPDATE mpass SET pass_expiry=$exp WHERE status=$status";
			$result = mysql_query($sql, $db);
			$i++;
		}
			
		$feedback[] = AT_FEEDBACK_SUCCESS;
		Header('Location: usermng.php?grp='.$group.SEP.'f='.AT_FEEDBACK_SUCCESS);
	}


require($_include_path.'cc_html/header.inc.php');

	echo '<h1 class="center">'.$_template['user_management'].'</h1><br>';
		
	// Showing existing fields
	
	echo '<br><form id="passwdp" method="post" action="'.$PHP_SELF.'" name="form_passwdp">';
	echo '<input type="hidden" name="grp" value='.$group.'>';
	?>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="250" summary="">
	<tr>
		<th colspan="2" scope="col"><?php  echo $_template['password_policy'];  ?></th>
	</tr><tr>
		<th><?php echo $_template['status']; ?></th>
		<th><?php echo $_template['expiry']; ?></th>
	</tr>
	<?php
		$sql = "SELECT * FROM policy";
		$res = mysql_query($sql, $db);
		while ($row = mysql_fetch_array($res)) {
			$policy[ intval($row['id']) ] = $row['name'];
		}
		
		$sql = "SELECT * FROM mpass";
		$res = mysql_query($sql, $db);
		$i = 1;
		while ($row = mysql_fetch_array($res)) {
			echo '<tr><td class="row1">';
			echo $policy[ intval($row['status']) ].'</td>'."\n";
			echo '<td class="row1" align="center"><input id="exp'.$i.'" name="exp'.$i.'" type="text" size="5" value="'.$row['pass_expiry'].'"> '.$_template['days'];
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
