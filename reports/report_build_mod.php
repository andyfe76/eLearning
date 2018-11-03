<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Report Builder</TITLE>
</HEAD>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style type="text/css">
	* {font-size: 8pt}
</style>

<script>
function click_sel()
{
 document.all.val.value=document.all.sel.value;
}

function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].editing.value='no';
 document.forms[0].submit();
}

function filllist()
{
 document.report_form.val.value=document.report_form.form_list.value;
}

function change_cat()
{
 document.report_form.attr.value='';
 document.forms[0].submit();
}

</script>
<BODY>
<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	
	$action = $_POST['action'];
	if ($action == '') $action = $_GET['action'];
	
	$report_id = $_POST['report_id'];
	if ($report_id == '') $report_id = $_GET['report_id'];
	
	$column_id = $_POST['column_id'];
	if ($column_id == '') $column_id = $_GET['column_id'];
	
	$query_id = $_POST['query_id'];
	if ($query_id == '') $query_id = $_GET['query_id'];	
	
	$cat = $_POST['cat'];
	if ($cat == '') $cat = $_GET['cat'];	
	
	$attr = $_POST['attr'];
	if ($attr == '') $attr = $_GET['attr'];	
	
	$op = $_POST['op'];
	if ($op == '') $op = $_GET['op'];
	
	$val = $_POST['val'];
	if ($val == '') $val = $_GET['val'];	
	
	$func = $_POST['func'];
	if ($func == '') $func = $_GET['func'];	
	
	$editing = $_POST['editing'];
	if ($editing == '') $editing = $_GET['editing'];	
	
	$column_cat = $_POST['column_cat'];
	if ($column_cat == '') $column_cat = $_GET['column_cat'];	
	
	$column_attr = $_POST['column_attr'];
	if ($column_attr == '') $column_attr = $_GET['column_attr'];	
	
	$report_name = $_POST['report_name'];
	if ($report_name == '') $report_name = $_GET['report_name'];
	
	$report_desc= $_POST['report_desc'];
	if ($report_desc == '') $report_desc = $_GET['report_desc'];

	// OK. Now get to business
	
	if ($action == 'Report Update') {
		$sql = "UPDATE report_reports SET name=$report_name, description=$report_desc WHERE id=$report_id";
		$res = mysql_query($sql);
		$action = '';
	}
	
	if (($report_name == '') || ($report_desc=='')) {
		$sql = "SELECT * FROM report_reports WHERE id=$report_id";
		$res = mysql_query($sql);
		if ($row = mysql_fetch_array($res)) {
			$report_name = $row['name'];
			$report_desc = $row['description'];
		}
	}
	
	if ($action == 'Query Add') {
		$sql = "INSERT INTO report_query (cat, attr, op, val, report, function) VALUES ('$cat', '$attr', '$op', '$val', '$report_id', '$func')";
		$res = mysql_query($sql);
		$action = '';
	}
	
	if (($action == 'Query Update' ) && ($editing=='no')) {
		$sql = "UPDATE report_query SET cat='$cat', attr='$attr', op='$op', val='$val', function='$func' WHERE id='$query_id'";
		$res = mysql_query($sql);
		$action = '';
		$editing = 'no';
	}
	
	if ($action == 'Query Edit') {
		$editing = $_POST['editing'];
		if ($editing == '') $edition = $_GET['editing'];
		if ($editing<>'yes') {
			$sql = "SELECT * FROM report_query WHERE id='$query_id'";
			$res = mysql_query($sql);
			if ($row=mysql_fetch_array($res)) {
				$cat = $row['cat'];
				$attr = $row['attr'];
				$op = $row['op'];
				$val = $row['val'];
				$func = $row['func'];
			}
		}
		$action = 'Query Update';
		$editing = 'yes';
	}

	if ($action == 'Query Delete') {
		$sql = "DELETE FROM report_query WHERE id=$query_id";
		$res = mysql_query($res);
		$action = '';
	}

	if ($action == 'Column Add') {
		$sql = "INSERT INTO report_columns (cat, attr, report) VALUES ('$column_cat', '$column_attr', '$report_id')";
		$res = mysql_query($sql);
		$action = '';
	}

	if ($action == 'Column Delete') {
		$sql = "DELETE FROM report_columns WHERE id=$column_id";
		$res = mysql_query($sql);
		$action = '';
	}
		
	if ($action == 'Column Edit') {
		$editing = $_POST['editing'];
		if ($editing=='') $editing=$_GET['editing'];
		$sql = "SELECT * FROM report_columns WHERE id=$column_id";
		$res = mysql_query($sql);
		if ($row = mysql_fetch_array($res)) {
			$column_cat = $row['cat'];
			$column_attr = $row['attr'];
			$column_id = $row['id'];
		}
		$action = 'Column Update';
		$editing = 'yes';
	}

	if (($action == 'Column Update') && ($editing == 'no')) {
		$sql = "UPDATE report_columns SET cat='$column_cat', attr='$column_attr' WHERE id=$column_id";
		$res = mysql_query($sql);
		$action = '';
		$editing = 'no';
	}
	
?>
<br>

<form action="report_build_mod.php" name="report_form">
<?/* modif
<table cellspacing="0" cellpadding="0" border="0" align="center" width="75%"><tr><td>
<b>Report Name: </b>
<INPUT type="text" name="report_name" value="<?php echo $report_name ?>" size="20"></td>
<td><b>Description: </b>
<INPUT type="text" name="report_desc" value="<?php echo $report_desc ?>" size="20"></td>
<td><input type="submit" name="update" class="button" onClick="javascript:void(update('Report Update'))" value="Update"></td>
</tr>
</table>
 */?>
<br>
<TABLE align="center" cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline" width="75%">
<tr><th scope="col" colspan="7">Query Editor</th></tr>
<tr>
	<th scope="col">Catogory</th>
	<th scope="col">Attribute</th>
	<th scope="col">Op.</th>
	<th scope="col">Value</th>
	<th scope="col">List</th>
	<th scope="col">Function</th>
	<th scope="col">Action</th></tr>
<tr>
<tr>
	<td><img src="images/spacer.gif" width="130" height="1"></td>
	<td><img src="images/spacer.gif" width="130" height="1"></td>
	<td><img src="images/spacer.gif" width="20" height="1"></td>
	<td><img src="images/spacer.gif" width="100" height="1"></td>
	<td><img src="images/spacer.gif" width="200" height="1"></td>
	<td><img src="images/spacer.gif" width="80" height="1"></td>
	<td><img src="images/spacer.gif" width="90" height="1"></td>
</tr>
<td align="center" valign="bottom"><SELECT name="cat" onchange="change_cat();">
<?php 

	$sql = "SELECT * FROM report_definitions ORDER BY cat";
	$res = mysql_query($sql);
	$cat_old = '';
	while ($row = mysql_fetch_array($res)) {
		$txt = $row['cat'];
		if ($cat=='') $cat = $txt;
		if ($cat_old <> $txt) {
			$cat_old = $txt;
			$selected = '';
			if ($txt==$cat) $selected = "SELECTED ";
			echo '<OPTION '.$selected.'name= "'.$txt.'"> '.$txt.' </option>';
		}
	}
?>

</select></td>
<td align="center" valign="bottom"><SELECT name="attr" onchange="document.report_form.submit();">

<?php

	$sql = "SELECT DISTINCT * FROM report_definitions WHERE cat='$cat'";
	$res = mysql_query($sql);
	while ( $row = mysql_fetch_array($res) ) {
		if ($attr == '') $attr = $row['attr'];		
		$txt = $row['attr'];
		echo $txt.'!!'.$attr;
		$selected = '';
		if ($txt==$attr) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
	}
?>

</select></td>
<td align="center" valign="bottom"><SELECT name="op" onchange="document.forms[0].submit()">
<?php 

	$sql = "SELECT DISTINCT * FROM report_operators";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		$txt = $row['text'];
		$selected = '';
		if ($txt==$op) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</OPTION>';
	}
?>

</SELECT></td>
<td align="center" valign="bottom"><INPUT type="text" name="val" value="<?php echo $val ?>" size="20"></td>
<td align="center" valign="bottom"><SELECT name="form_list" id="form_list" cols="10" onchange="filllist();">


<?php 
	
	$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
	$res = mysql_query($sql);
	$t = '';
	$f = '';
	
	if ($row = mysql_fetch_array($res)) {
		$t = $row['tbl'];
		$f = $row['field'];
	}
	
	if ($t <> '') {
		$sql = "SELECT $f FROM $t";
		$res = mysql_query($sql);
		while ($row = mysql_fetch_array($res)) {
			$selected = '';
			$v = $row[$f];
			if ($v==$val) $selected = 'SELECTED ';
			echo '<OPTION '.$selected.' value="'.$v.'">'.$v.'</option>';
		}
	}
?>

</select>
<td align="center" valign="bottom"><SELECT name="func" onchange="document.forms[0].submit()">

<?php 

	$selected = '';
	if ($func=='AND') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="AND">AND</option>';
	$selected = '';
	if ($func=='OR') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="OR">OR</option>'."\n";
	echo '</select>';
?>
	
</td>
<td>
<INPUT type="hidden" name="action" value="<?php echo $action; ?>">
<INPUT type="hidden" name="query_id" value="<?php echo $query_id ?>">
<INPUT type="hidden" name="report_id" value="<?php echo $report_id ?>">
<INPUT type="hidden" name="column_id" value="<?php echo $column_id ?>">
<INPUT type="hidden" name="editing" value="<?php echo $editing ?>">

<?php

	$txt_action=$action;
	if ($action == '') $txt_action = 'Query Add';
	if ($action == 'Query Edit') $txt_action = 'Update Query';
	if ( strpos($txt_action, 'Column', 1) || strpos($txt_action, 'Report', 1) ) $txt_action='Query Add';
	echo '<a href="javascript:void(update(\''.$txt_action.'\'))">'.$txt_action.'</a> &nbsp; </td></tr>';
	
	$sql = "SELECT DISTINCT * FROM report_query WHERE report= $report_id";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)) {
		?>
		<tr><td colspan="7"><hr></td></tr>
		<tr>
		<td><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&action=Query Edit&editing=no"><?php echo $row['cat']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&action=Query Edit&editing=no"><?php echo $row['attr']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&action=Query Edit&editing=no"><?php echo $row['op']; ?></a>&nbsp;</td>
		<td colspan="2"><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&action=Query Edit&editing=no"><?php echo $row['val']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&action=Query Edit&editing=no"><?php echo $row['function']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="report_build_mod.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['id']; ?>&report_name=<?php echo $report_name; ?>&report_desc=<?php echo $report_desc; ?>&action=Query Delete">Delete</a></td>
		</tr>
		
		<?php
	}

?>

</table></br>


<br>
<center>
	<A href="index.php">Ok. Return to Reports Page</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A href="index.php">Cancel</a></center>
</form>
</BODY>
</HTML>