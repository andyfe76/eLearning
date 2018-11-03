<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>K-Lore Reports</TITLE>
</HEAD>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />

<BODY>
<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	$report_id = $_POST['report_id'];
	if ($report_id=='') $report_id = $_GET['report_id'];

	if ($action == "Add Report") {
		$sql = "INSERT INTO report_reports (name,description) VALUES ('test','test')";
		$res = mysql_query($sql);
		$id = mysql_insert_id();
		Header("Location: report_build.php?report_id=".$id);
	}

	 if ($action == "Delete Report") {
	 	$sql = "DELETE FROM report_reports WHERE id=$report_id";
	 	$res = mysql_query($sql);
	 }
?>
	 
<BR>
<center><A href="index.php?action=Add Report">Add Report</a></center>
<BR>
<BR>

<?php
	$sql = "SELECT * FROM report_reports";
	$res = mysql_query($sql);
	if ($row = mysql_fetch_array($res)) {
		?>
		<table cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline">
		<tr><th scope="col">Name</th><th scope="col" width="200">Description</th><th scope="col" colspan="2">Action</th></tr>
		<?php 
		do {
			?>
			<tr>
			<td class="row1"><A href="report_build.php?report_id=<?php echo $row['id'];?>"><?php echo $row['name'];?></a>&nbsp;</td>
			<td class="row1"><?php echo $row['description']; ?>&nbsp;</td>
			<td class="row1"><A href="report_view.php?report_id=<?php echo $row['id'];?>">View</a></td>
			<td class="row1">&nbsp;&nbsp;&nbsp;&nbsp;<A href="index.php?action=Delete Report&report_id=<?php echo $row['id'];?>">Delete</a></td>
			</tr>
		<?php
		} while ($row = mysql_fetch_array($res))
		?>
		</table>
 	<?php
	}
?>
</BODY>
</HTML>