<?php

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	$link_id = $_POST['link_id'];
	if ($link_id == '') $link_id = $_GET['link_id'];
	
	$cat1 = $_POST['cat1'];
	if ($cat1 == '') $cat1 = $_GET['cat1'];
	
	$cat2 = $_POST['cat2'];
	if ($cat2 == '') $cat2 = $_GET['cat2'];
	
	$attr1= $_POST['attr1'];
	if ($attr1 == '') $attr1 = $_GET['attr1'];
	
	$attr2 = $_POST['attr2'];
	if ($attr2 == '') $attr2 = $_GET['attr2'];

	if ($action == 'Link Add') {
		$sql = "INSERT INTO report_links (cat1, attr1, cat2, attr2) VALUES ('$cat1', '$attr1', '$cat2', '$attr2')";
		$res = $db->query($sql);
		$action = '';
	}

	if (($action == 'Link Update') && ($editing == 'no')) {
		$sql = "UPDATE report_links SET cat1='$cat1', attr1='$attr1', cat2='$cat2', attr2='$attr2' WHERE id=$link_id";
		$res = $db->query($sql);
		$action = '';
		$editing = 'no';
	}
	
	if ($action == 'Link Edit') {
		$editing = $_POST['editing'];
		if ($editing=='') $editing = $_GET['editing'];
		if ($editing <> 'yes') {
			$sql = "SELECT * FROM report_links WHERE id=$link_id";
			$res = $db->query($sql);
			if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
				$cat1 = $row['CAT1'];
				$cat2 = $row['CAT2'];
				$attr1 = $row['ATTR1'];
				$attr2 = $row['ATTR2'];
			}
		}
		$action = '';
		$editing = 'yes';
	}

	if ($action == 'Link Delete') {
		$sql = "DELETE FROM report_links WHERE id=$link_id";
		$res = $db->query($sql);
		$action = '';
	}
	
?>
<script>
function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].editing.value='no';
 document.forms[0].submit();
}

</script>
<TABLE border="1" align="center">
<form action="link_edit.php">
<tr><td bgcolor="#E0E0E0">Catogory1</td><td bgcolor="#E0E0E0">Attribute1</td><td>&nbsp;</td><td bgcolor="#E0E0E0">Category2</td><td bgcolor="#E0E0E0">Attribute2</td></tr>
<tr>
<td><SELECT name="cat1" onchange="document.forms[0].submit()">

<?php
	$sql = "SHOW TABLES";
	$res = $db->query($sql);
	$cat_old = '';
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['TABLES_IN_KLORE'];
		if ($cat1=='') $cat1=$txt;
		if ($cat_old <> $txt) {
			$cat_old = $txt;
			$selected = '';
			if ($txt == $cat1) $selected = 'SELECTED ';
			echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
		}
	}
?>

</select>
</td>
<td><SELECT name="attr1" onchange="document.forms[0].submit()">

<?php

	$sql = "SHOW FIELDS FROM $cat1";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['FIELD'];
		$selected = '';
		if ($txt == $attr1) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
	}
?>

</select></td>
<td><=></td>
<td><SELECT name="cat2" onchange="document.forms[0].submit()">

<?php
	$sql = "SHOW TABLES";
	$res = $db->query($sql);
	$cat_old = '';
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['TABLES_IN_KLORE'];
		if ($cat2 == '') $cat2 = $txt;
		if ($cat_old <> $txt) {
			$cat_old = $txt;
			$selected = '';
			if ($txt == $cat2) $selected = 'SELECTED ';
			echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
		}
	}

 ?>
 
</select></td>
<td><SELECT name="attr2" onchange="document.forms[0].submit()">

<?php
	
	 $sql = "SHOW FIELDS FROM $cat2";
	 $res = $db->query($sql);
	 while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
	 	$txt = $row['FIELD'];
	 	$selected = '';
	 	if ($txt == $attr2) $selected = 'SELECTED ';
	 	echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
 	}
 
?>

</select></td>


<?php
	
	$txt_action = $action;
	if ($txt_action == '') $txt_action = 'Link Add';
?>

<td><A HREF="javascript:void(update('<?php echo $txt_action; ?>'))"><?php echo $txt_action; ?></A>&nbsp;</td>

<?php

	$sql = "SELECT * FROM report_links";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>	
		<tr>
		<td><A href="link_edit.php?action=Link Edit&link_id=<?php echo $row['ID']; ?>"><?php echo $row['CAT1']; ?></a>&nbsp;</td>
		<td><A href="link_edit.php?action=Link Edit&link_id=<?php echo $row['ID']; ?>"><?php echo $row['ATTR1']; ?></a>&nbsp;</td>
		<td><=></td>
		<td><A href="link_edit.php?action=Link Edit&link_id=<?php echo $row['ID']; ?>"><?php echo $row['CAT2']; ?></a>&nbsp;</td>
		<td><A href="link_edit.php?action=Link Edit&link_id=<?php echo $row['ID']; ?>"><?php echo $row['ATTR2']; ?></a>&nbsp;</td>
		<td><A href="link_edit.php?action=Link Delete&link_id=<?php echo $row['ID']; ?>">Delete</a></td>
		</tr>
		<?php
	} 
?>

<INPUT type="hidden" name="action" value="<?php echo $action; ?>">
<INPUT type="hidden" name="editing" value="<?php echo $editing; ?>">
</form>
</table>
<br>
<center><A href="admin.php">Return to Reports Home</a></center>
</BODY>
</HTML>
