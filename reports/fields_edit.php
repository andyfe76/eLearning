
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Fields Editor</TITLE>
</HEAD>
<script>
function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].submit();
}
</script>
<BODY>
<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$cat = $_GET['cat'];
	$attr = $_GET['attr'];
	$desc = $_GET['desc'];
	$table = $_GET['table'];
	$field = $_GET['field'];
	$action = $_GET['action'];
	$editing = $_GET['editing'];
	$id = $_GET['id'];
	
	if (($action == 'edit') && ($editing=='yes')) {
		$sql = "SELECT * FROM report_definitions WHERE id=$id";
		$res = mysql_query($sql);
		if ($row = mysql_fetch_array($res)) {
			$cat = $row['cat'];
			$attr = $row['attr'];
			$table = $row['table'];
			$desc = $row['desc'];
			$field = $row['field'];
		}
		$editing = 'yes';
	}

	if ($action == 'Add') {
		$sql = "INSERT INTO report_definitions (cat, attr, description, tbl, field) VALUES ('$cat', '$attr', '$desc', '$table', '$field')";
		$res = mysql_query($sql);
		$action = '';
	}
	
	if ($action == 'Update') {
		$sql = "UPDATE report_definitions SET cat='$cat', attr='$attr', description='$desc', tbl='$table', field='$field' WHERE id=$id";
		$res = mysql_query($sql);
		$action = 'Add';
	}

 	if ($action == 'delete') {
 		$sql = "DELETE FROM report_definitions WHERE id=$id";
 		$action = 'Add';
 	}
?>

<table border="1" align="center">
<FORM action="fields_edit.php">
<tr>
<td align="center" bgcolor="#E0E0E0">Category</td><td align="center" bgcolor="#E0E0E0">Attribute</td><td align="center" bgcolor="#E0E0E0">Description</td><td align="center" bgcolor="#E0E0E0">Table</td><td align="center" bgcolor="#E0E0E0">Field</td>
</td>
<tr>
<td><INPUT type="text" name="cat" value="<?php echo $cat ?>" size="20"></td>
<td><INPUT type="text" name="attr" value="<?php echo $attr ?>" size="20"></td>
<td><INPUT type="text" name="desc" value="<?php echo $desc ?>" size="20"></td>
<td><SELECT name="table" onchange="document.forms[0].submit()">

<?php

	$sql = "SHOW TABLES";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		$txt = $row['tables_in_klore'];
		if ($table=='') $table = $txt;
		$selected = '';
		if ($txt==$table) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
	}
?>

</select></td>
<td><SELECT name="field" onchange="document.forms[0].submit()">

<?php
	if ($table <> '') {
		$sql = "SHOW FIELDS FROM $table";
		$res = mysql_query($sql);
		while ($row = mysql_fetch_array($res)) {
			$txt = $row['field'];
			$selected = '';
			if ($txt == $field) $selected = 'SELECTED ';
			echo '<option '.$selected.'name="'.$txt.'">'.$txt.'</option>';
		}
	}
?>

</select></td>

<?php
	$txt_action = $action;
	if ($action == '') $txt_action = 'Add';
	if ($action == 'edit') $txt_action = 'Update';
?>

<td>
<A HREF="javascript:void(update('<?php echo $txt_action; ?>'))"><?php echo $txt_action; ?></A> &nbsp;</td>
</tr>

<?php
	$sql = "SELECT * FROM report_definitions";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
	?>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>&action=edit&editing=no"><?php echo $row['cat']; ?></a>&nbsp;</td>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>&action=edit&editing=no"><?php echo $row['attr']; ?></a>&nbsp;</td>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>&action=edit&editing=no"><?php echo $row['description']; ?></a>&nbsp;</td>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>>&action=edit&editing=no"><?php echo $row['tbl']; ?></a>&nbsp;</td>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>&action=edit&editing=no"><?php echo $row['field']; ?></a>&nbsp;</td>
		<td><A HREF="fields_edit.php?id=<?php echo $row['id']; ?>&action=delete">Delete</a></td>
		</tr>
	<?php
	}
?>

 <BR>
 <input type="hidden" name="action" value="<?php echo $action ?>">
 <input type="hidden" name="id" value="<?php echo $id ?>">
 <input type="hidden" name="editing" value="<?php echo $editing ?>">
</form>
</table>
<br>
<center><A href="admin.php">Return to Reports Home</a></center>
</BODY>
</HTML>