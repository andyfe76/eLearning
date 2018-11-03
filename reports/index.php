<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	$report_id = $_POST['report_id'];
	if ($report_id=='') $report_id = $_GET['report_id'];

	if ($action == "Add Report") {
		$id = $db->nextId("AUTO_REPORT_REPORTS_ID");
		$sql = "INSERT INTO report_reports VALUES ($id, '','new report')";
		$res = $db->query($sql);
		Header("Location: report_build.php?report_id=".$id);
	}

	 if ($action == "Delete Report") {
	 	$sql = "DELETE FROM report_reports WHERE id=$report_id";
	 	$res = $db->query($sql);
	 }
	 
	 require($_include_path.'cc_html/header.inc.php');
?>
	 

<BR>
<center><table border="0" width="50%" align="center" class="framework"><tr><td align="center">&nbsp;</td>
<td><a class="framewk" href="reports/report_build2.php"><img src="images/menu/add_report.gif" border="0">&nbsp;&nbsp<?php echo $_template['create_report']; ?></a></td>
</tr></table></center>
<BR>
<BR>

<?php
	$sql = "SELECT * FROM report_reports";
	$res = $db->query($sql);
	if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<table cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline">
		<tr><th scope="col">Name</th><th scope="col" width="200">Description</th><th scope="col" colspan="2">Action</th></tr>
		<?php 
		$alternate = 1;
		do {
			?>
			<tr>
			<td class="rowa<?php echo $alternate; ?>"><A href="reports/report_view2.php?rid=<?php echo $row['ID'];?>"><img src="images/menu/view_report.gif" border="0" alt="<?php echo $_template['view']; ?>"></a>&nbsp;</td>
			<td class="rowa<?php echo $alternate; ?>"><A href="reports/report_build2.php?report_id=<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></a>&nbsp;</td>
			<td class="rowa<?php echo $alternate; ?>"><?php echo $row['DESCRIPTION']; ?>&nbsp;</td>
			<td class="rowa<?php echo $alternate; ?>"><A href="reports/report_view2.php?rid=<?php echo $row['ID'];?>"><img src="images/menu/view_report.gif" alt="<?php echo $_template['view']; ?>" border="0"></a></td>
			<td class="rowa<?php echo $alternate; ?>">&nbsp;&nbsp;<A href="reports/index.php?action=Delete Report&report_id=<?php echo $row['ID'];?>"><img src="images/menu/delete.gif" border="0" alt="<?php echo $_template['delete']; ?>"></a></td>
			</tr>
		<?php
			$alternate++;
			if ($alternate>2) $alternate = 1;
		} while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC))
		?>
		</table>
 	<?php
	}
	
	require($_include_path.'cc_html/footer.inc.php');

?>