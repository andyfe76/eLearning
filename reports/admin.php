
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>KLore Reports</TITLE>
</HEAD>
<BODY>
<?php

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];

	if ($action == 'Add Report') {
		$sql = "INSERT INTO report_reports (name, description) VALUES ('test', 'test')";
		$res = mysql_query($sql);
		$id = mysql_insert_id();
		Header("Location: report_build.php?report_id=$id");
	}
	
	$report_id = $_POST['report_id'];
	if ($report_id=='') $report_id = $_GET['report_id'];
	
	if ($action == "Delete Report") {
		$sql = "DELETE FROM report_reports WHERE ID=$report_id";
		$res = mysql_query($sql);
	}
?>
 
<A href="fields_edit.php">Fields Editor</a>
<BR>
<A href="link_edit.php">Links Editor</a>
<BR>
<A href="index.php?action=Add Report">Add Report</a>
<BR>
<BR>


<?php

	$sql = "SELECT * FROM report_reports";
	$res = mysql_query($sql);
	echo '<table border="1"><tr><td>Name</td><td>Desription</td><td>&nbsp</td></tr>';
	while ($row = mysql_fetch_array($res)) {
		?>
		<tr>
		<td><A href="report_build.php?report_id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
		<td><A href="report_build.php?report_id=<?php echo $row['id']; ?>"><?php echo $row['description']; ?></a></td>
		<td><A href="index.php?action=Delete Report&report_id=<?php echo $row['id']; ?>">Delete</a></td>
		<td><A href="report_view.php?report_id=<?php echo $row['id']; ?>">View</a></td>
		</tr>
		<?php
	}
?>

</table>
</BODY>
</HTML>
