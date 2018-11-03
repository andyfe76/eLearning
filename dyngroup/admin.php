<?php

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	if ($action == 'Add Group') {
		$id = $db->nextId("AUTO_DYN_GROUPS_ID");
		$sql = "INSERT INTO dyn_groups (name, description) VALUES ('test', 'test')";
		$res = $db->query($sql);
		Header("Location: group_build.php?group_id=$id");
	}
	
	$group_id = $_POST['group_id'];
	if ($group_id=='') $group_id = $_GET['group_id'];
	
	if ($action == "Delete Group") {
		$sql = "DELETE FROM dyn_groups WHERE ID=$group_id";
		$res = $db->query($sql);
	}
?>
 
<A href="fields_edit.php">Fields Editor</a>
<BR>
<A href="link_edit.php">Links Editor</a>
<BR>
<A href="index.php?action=Add Group">Add Group</a>
<BR>
<BR>


<?php

	$sql = "SELECT * FROM dyn_groups";
	$res = $db->query($sql);
	echo '<table border="1"><tr><td>Name</td><td>Desription</td><td>&nbsp</td></tr>';
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<tr>
		<td><A href="group_build.php?group_id=<?php echo $row['ID']; ?>"><?php echo $row['NAME']; ?></a></td>
		<td><A href="group_build.php?group_id=<?php echo $row['ID']; ?>"><?php echo $row['DESCRIPTION']; ?></a></td>
		<td><A href="index.php?action=Delete Group&group_id=<?php echo $row['ID']; ?>">Delete</a></td>
		</tr>
		<?php
	}
?>

</table>
</BODY>
</HTML>
