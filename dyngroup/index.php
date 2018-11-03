<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	$group_id = $_POST['group_id'];
	if ($group_id=='') $group_id = $_GET['group_id'];

	if ($action == "Add Group") {
		$id = $db->nextId("AUTO_REPORT_REPORTS_ID");
		$sql = "INSERT INTO dyn_groups VALUES ($id, 'test','test')";
		$res = $db->query($sql);
		
		$static_id = $id; // (backward compatibility) now these two are as one :)
		
		Header("Location: ../reports/report_build2.php?report_id=".$id);
	}

	 if ($action == "Delete Group") {
	 	$sql = "SELECT * FROM dyn_groups WHERE id=$group_id";
	 	$res = $db->query($sql);
	 	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	 	$static_id = $row['STATIC_ID'];
	 	$sql = "DELETE FROM dyn_groups WHERE id=$group_id";
	 	$res = $db->query($sql);
	 	$sql = "DELETE FROM dyn_sql WHERE dyn_id=$group_id";
	 	$res = $db->query($sql);
	 }
	 require($_include_path.'cc_html/header.inc.php');
?>
	 
<BR>
<center><table border="0" width="50%" align="center" class="framework"><tr><td align="center"><A href="dyngroup/index.php?action=Add Group"><img border="0" src="images/menu/add_group.gif"> &nbsp;&nbsp;Add Group</a>
</td></tr></table></center>
<BR>
<BR>

<?php
	$sql = "SELECT * FROM dyn_groups";
	$res = $db->query($sql);
	if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$alternate = 1;
		?>
		<table cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline">
		<tr><th scope="col">Name</th><th scope="col" width="200">Description</th><th scope="col" colspan="2">Action</th></tr>
		<tr><td colspan="3"><hr></td></tr>
		<?php 
		do {
			?>
			<tr>
			<td class="rowa<?php echo $alternate; ?>"><A href="reports/report_build2.php?report_id=<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></a>&nbsp;</td>
			<td class="rowa<?php echo $alternate; ?>"><?php echo $row['DESCRIPTION']; ?>&nbsp;</td>
			<td class="rowa<?php echo $alternate; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<A href="dyngroup/index.php?action=Delete Group&group_id=<?php echo $row['ID'];?>"><img border="0" src="images/menu/delete.gif">Delete</a></td>
			</tr>
		<?php
			$alternate++;
			if ($alternate>2) $alternate = 1;
		} while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC))
		?>
		</table>
 	<?php
	}
	require ($_include_path.'cc_html/footer.inc.php');
?>