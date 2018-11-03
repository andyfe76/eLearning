<?php
	// TO DO:
	// Add: student mark on test T
	// Add: start period
	// Add: end period

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	
	$action = $_GET['action'];
	if ($action == '') $action = $_POST['action'];
	
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

	if (($action == 'ReportUpdate') || ($action=='Column Update') || ($action=='Query Update') || (($action=='') && ($report_name<>''))){
		$sql = "UPDATE report_reports SET name='$report_name', description='$report_desc' WHERE id=$report_id";
		if ($_SESSION['debug']) echo '<br>Update : '.$sql.'<br>';
		$res = $db->query($sql);
	}
	
	if (($report_name == '') || ($report_desc=='')) {
		$sql = "SELECT * FROM report_reports WHERE id=$report_id";
		$res = $db->query($sql);
		if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$report_name = $row['NAME'];
			$report_desc = $row['DESCRIPTION'];
		}
	}
	
	if ($action == 'Query Add') {
		$repid = $db->nextId("AUTO_REPORT_QUERY_ID_SEQ");
		$sql = "INSERT INTO report_query VALUES ($report_id, $repid, '$cat', '$attr', '$val', '$op', '$func')";
		echo $sql;
		$res = $db->query($sql);
		$action = '';
	}
	
	if (($action == 'Query Update' ) && ($editing=='no')) {
		$sql = "UPDATE report_query SET cat='$cat', attr='$attr', op='$op', val='$val', function='$func' WHERE id='$query_id'";
		$res = $db->query($sql);
		$action = '';
		$editing = 'no';
	}
	
	if ($action == 'Query Edit') {
		$editing = $_POST['editing'];
		if ($editing == '') $edition = $_GET['editing'];
		if ($editing<>'yes') {
			$sql = "SELECT * FROM report_query WHERE id='$query_id'";
			$res = $db->query($sql);
			if ($row=$res->fetchRow(DB_FETCHMODE_ASSOC)) {
				$cat = $row['CAT'];
				$attr = $row['ATTR'];
				$op = $row['OP'];
				$val = $row['VAL'];
				$func = $row['FUNCTION'];
			}
		}
		$action = 'Query Update';
		$editing = 'yes';
	}

	if ($action == 'Query Delete') {
		$sql = "DELETE FROM report_query WHERE id=$query_id";
		$res = $db->query($sql);
		$action = '';
	}

	if ($action == 'Column Add') {
		$colid = $db->nextId("AUTO_REPORT_COLUMNS_ID");
		$sql = "INSERT INTO report_columns VALUES ($colid, $report_id, '$column_cat', '$column_attr')";
		$res = $db->query($sql);
		$action = '';
	}

	if ($action == 'Column Delete') {
		$sql = "DELETE FROM report_columns WHERE id=$column_id";
		$res = $db->query($sql);
		$action = '';
	}
		
	if ($action == 'Column Edit') {
		$editing = $_POST['editing'];
		if ($editing=='') $editing=$_GET['editing'];
		$sql = "SELECT * FROM report_columns WHERE id=$column_id";
		$res = $db->query($sql);
		if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$column_cat = $row['CAT'];
			$column_attr = $row['ATTR'];
			$column_id = $row['ID'];
		}
		$action = 'Column Update';
		$editing = 'yes';
	}

	if (($action == 'Column Update') && ($editing == 'no')) {
		$sql = "UPDATE report_columns SET cat='$column_cat', attr='$column_attr' WHERE id=$column_id";
		$res = $db->query($sql);
		$action = '';
		$editing = 'no';
	}
	require($_include_path.'cc_html/header.inc.php');
	
?>

<script>
function click_sel()
{
 document.all.val.value=document.all.sel.value;
}

function update(action)
{
 document.report_form.action.value=action;
 document.report_form.editing.value='no';
 document.report_form.submit();
}

function filllist()
{
 document.report_form.val.value=document.report_form.form_list.value;
}

function change_cat()
{
 document.report_form.attr.value='';
 document.report_form.submit();
}

</script>
<br>
<h1>K-Lore Report Builder</h1><br>
<form action="<?php echo $PHP_SELF; ?>" name="report_form">
<table cellspacing="0" cellpadding="0" border="0" align="center" width="75%"><tr><td>
<b>Report Name: </b>

<INPUT type="text" name="report_name" value="<?php echo $report_name ?>" size="20"></td>
<td><b>Description: </b>
<INPUT type="text" name="report_desc" value="<?php echo $report_desc ?>" size="20"></td>
<td><input type="submit" name="update" class="button" onClick="javascript:void(update('ReportUpdate'))" value="Update"></td>
</tr>
</table>

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
	<td><img src="images/spacer.gif" width="130" height="1"></td>
</tr>
<td align="center" valign="bottom"><SELECT name="cat" onchange="change_cat();">
<?php 

	$sql = "SELECT * FROM report_definitions ORDER BY cat";
	$res = $db->query($sql);
	$cat_old = '';
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['CAT'];
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
	$res = $db->query($sql);
	while ( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		if ($attr == '') $attr = $row['ATTR'];		
		$txt = $row['ATTR'];
		$selected = '';
		if ($txt==$attr) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
	}
?>

</select></td>
<td align="center" valign="bottom"><SELECT name="op" onchange="document.report_form.submit()">
<?php 

	$sql = "SELECT DISTINCT * FROM report_operators";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['TEXT'];
		$selected = '';
		if ($txt==$op) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</OPTION>';
	}
?>

</SELECT></td>
<td align="center" valign="bottom"><INPUT type="text" name="val" value="<?php echo $val ?>" size="20"></td>
<td align="left" valign="bottom"><SELECT name="form_list" id="form_list" cols="10" onchange="filllist();">


<?php 
	
	$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
	$res = $db->query($sql);
	$t = '';
	$f = '';
	
	if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$t = $row['TBL'];
		$f = $row['FIELD'];
	}
	
	if ($t <> '') {
		$sql = "SELECT $f FROM $t";
		$res = $db->query($sql);
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$selected = '';
			$v = $row[$f];
			if ($v==$val) $selected = 'SELECTED ';
			echo '<OPTION '.$selected.' value="'.$v.'">'.$v.'</option>';
		}
	}
?>

</select>
<td align="center" valign="bottom"><SELECT name="func" onchange="document.report_form.submit()">

<?php 

	$selected = '';
	if ($func=='AND') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="AND">AND</option>';
	$selected = '';
	if ($func=='OR') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="OR">OR</option>'."\n";
	echo '</select>';

	//if ($action == '') $action = 'ReportUpdate';
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
	echo '<a href="javascript:void(update(\''.$txt_action.'\'))">';
	if ($txt_action=='Query Add') {
		echo '<img border="0" src="images/menu/query_add.gif">';
	} else if (($action == 'Query Update') || ($action=='Query Edit')){
		echo '<img border="0" src="images/menu/query_update.gif">';
	}
	echo ' &nbsp;'.$txt_action.'</a> &nbsp; </td></tr>';
	
	$sql = "SELECT DISTINCT * FROM report_query WHERE report= $report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<tr><td colspan="7"><hr></td></tr>
		<tr>
		<td><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['CAT']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['ATTR']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['OP']; ?></a>&nbsp;</td>
		<td colspan="2"><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['VAL']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['FUNCTION']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="reports/report_build.php?report_id=<?php echo $report_id ?>&query_id=<?php echo $row['ID']; ?>&report_name=<?php echo $report_name; ?>&report_desc=<?php echo $report_desc; ?>&action=Query Delete"><img border="0" src="images/menu/delete.gif">Delete</a></td>
		</tr>
		
		<?php
	}
?>

</table></br>
<table cellpadding="0" cellspacing="1" border="0" class="bodyline" align="center">
<tr>
<th scope="col" colspan="7">Column Editor</th>
</tr>
<tr><th scope="col">Category</th>
<th scope="col">Attribute</th>
<th scope="col">Action</th>
</tr>

<tr>
<td><img src="images/spacer.gif" width="150" height="1"></td>
<td><img src="images/spacer.gif" width="150" height="1"></td>
<td><img src="images/spacer.gif" width="100" height="1"></td>
</tr>

<tr>
<td align="center" valign="bottom"><SELECT name="column_cat" onchange="document.report_form.submit();">
<?php

	$sql = "SELECT * FROM report_definitions ORDER BY cat";
	$res = $db->query($sql);
	$cat_old = '';
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['CAT'];
		if ($column_cat == '') $column_cat = $txt;
		if ($cat_old <> $txt) {
			$cat_old = $txt;
			$selected = '';
			if ($txt == $column_cat) $selected = 'SELECTED ';
			echo '<option '.$selected.'name="'.$txt.'">'.$txt.'</option>';
		}		
	}
?>
 
</select></td>
<td align="center" valign="bottom"><SELECT name="column_attr" onchange="document.report_form.submit();">
<?php 

	$sql = "SELECT DISTINCT * FROM report_definitions WHERE cat='$column_cat'";
	$res = $db->query($sql);
	
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$txt = $row['ATTR'];
		$selected = '';
		if ($txt == $column_attr) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</OPTION>';
	}
	
	echo '</select></td>';
	
	$txt_action = $action;
	if ($txt_action <> 'Column Update') $txt_action = 'Column Add';
	echo '<td><a href="javascript:void(update(\''.$txt_action.'\'))">';
	if ($txt_action == 'Column Update') {
		echo '<img border="0" src="images/menu/column_update.gif">';
	} else if ($txt_action=='Column Add'){
		echo '<img border="0" src="images/menu/column_add.gif">';
	}
	echo ' &nbsp;'.$txt_action.'</a> &nbsp;</td>';
	echo '</tr>';
	echo '<tr><td colspan="3"><hr></td></tr>';
	
	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<tr>
		<td><A href="reports/report_build.php?action=Column Edit&column_id=<?php echo $row['ID']; ?>&report_id=<?php echo $report_id; ?>"><?php echo $row['CAT']; ?></a>&nbsp;</td>
		<td><A href="reports/report_build.php?action=Column Edit&column_id=<?php echo $row['ID']; ?>&report_id=<?php echo $report_id; ?>"><?php echo $row['ATTR']; ?></a>&nbsp;</td>
		<td><A href="reports/report_build.php?action=Column Delete&report_name=<?php echo $report_name; ?>&report_desc=<?php echo $report_desc; ?>&column_id=<?php echo $row['ID']; ?>&report_id=<?php echo $report_id; ?>"><img border="0" src="images/menu/delete.gif">Delete</a></td>
		</tr>
		<?php	
	}
?>

</TABLE>

<br>
<table cellpadding="0" cellspacing="0" border="0" class="framework" align="center" width="300px">
<tr><td align="center">
	<A href="reports/index.php"><img border="0" src="images/menu/ok.gif">Return to Reports Page</a>
</td></tr>
</table>
</form>
<?php 
	require ($_include_path.'cc_html/footer.inc.php');
?>