<?php


	$section = 'users';
	$_include_path = '../include/';
	require ($_include_path.'vitals.inc.php');

	if (isset($_POST['cancel'])) {
		Header('Location: usermng.php?grp='.$_POST['group']);
		exit;
	}
	
	if (isset($_POST['addcateg'])) {
		$sql = "INSERT INTO tmp_dyngroup VALUES(0, 'category=$_POST[category]', 'in category: $_POST[category]', 'group')";
		mysql_query($sql, $db);
	}
	
	if (isset($_POST['addgroup'])) {
		$grpost = 'group_'.$_POST['category'];
		$groupid = $_POST[$grpost];
		$sql = "SELECT name FROM member_groups WHERE group_id=$groupid";
		$res = mysql_query($sql, $db);
		$row = mysql_fetch_array($res);
		$sql = "INSERT INTO tmp_dyngroup VALUES (0, 'group_id=$groupid', 'in group: $row[name]', 'group')";
		mysql_query($sql, $db);
	}
	
	

	

require($_include_path.'cc_html/header.inc.php');

?>

<script language="JavaScript">
function select_categ(cname) {
	document.form1.category.value = cname;
	document.form1.submit();
}
</script>

<form method="post" action="<?php echo $PHP_SELF; ?>" name="form1">

<?php

print_errors($errors);
?>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['dynamic_group']; ?></h4></td>
</tr>
<tr>
	<td class="row1" align="left"><label for="from"><b><?php echo $_template['select_from']; ?>:</b></label></td>
	<td class="row1" align="left"><b><?php echo $_template['condition']; ?></b></td>
<tr>
	<td class="row1" align="left" valign="top">
<?php
	$sql = "SELECT name FROM member_categ";
	$res = mysql_query($sql, $db);
	
	echo '<input type="hidden" name="category" id="category">';
	while ($row = mysql_fetch_array($res)) {
		echo '<b>'.$_template['category'].': ';
		echo $row['name'].'</b>&nbsp;&nbsp;&nbsp;<input type="submit" class="button2" name="addcateg" onClick="select_categ(\''.$row['name'].'\');" value=">>"><br>';
		$sql	= "SELECT * FROM member_groups WHERE category='$row[name]'";
		$result	= mysql_query($sql, $db);
		echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group_'.$row['name'].'" size="4" class="dropdown" id="group'.$row['name'].'" title="Group">'."\n";
		while ($row_g = mysql_fetch_array($result)) {
			echo '<option value="'.$row_g['group_id'].'">'.$row_g['name'];
			echo '</option>'."\n";
		}
		echo '</select>&nbsp;'."\n";
		echo '<input type="submit" class="button2" name="addgroup" onClick="select_categ(\''.$row['name'].'\');" value="'.$_template['add_group'].'">';
		echo '<br><br>';
	}
	echo '</td>';
	echo '<td align="left" width="150">';
		echo '<b>'.$_template['users'].'</b><br>';
		$sql 	= "SELECT sql FROM tmp_dyngroup WHERE type='group'";
		$res 	= mysql_query($sql, $db);
		while( $row	= mysql_fetch_array($res)) {
			echo $row['sql'].'<br>';
		}
	echo '</td>';
?>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1">
		<?php echo '<b>'.$_template['skill'].'</b>'; 
		?>
	</td>
	
	<td>
	</td>
</tr>
</table>
</form>

<?php
	require($_include_path.'cc_html/footer.inc.php');
?>
