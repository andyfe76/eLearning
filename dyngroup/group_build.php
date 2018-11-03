<?php
	// TO DO:
	// Add: student mark on test
	// Add: start period
	// Add: end period

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	
	$action = $_GET['action'];
	if ($action == '') $action = $_POST['action'];
	
	$group_id = $_POST['group_id'];
	if ($group_id == '') $group_id = $_GET['group_id'];
		
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
	
	$group_name = $_POST['group_name'];
	if ($group_name == '') $group_name = $_GET['group_name'];
	
	$group_desc= $_POST['group_desc'];
	if ($group_desc == '') $group_desc = $_GET['group_desc'];

	// OK. Now get to business

	//if ($_SESSION['debug']) echo '<br>'.$action;
	
	if ($action == 'saveGroup') {
		require ('group_view.php');
		Header("Location: index.php");
	}
	
	
	if (($action == 'GroupUpdate') || ($action=='Column Update') || ($action=='Query Update') || (($action=='') && ($group_name<>''))){
		$sql = "UPDATE dyn_groups SET name='$group_name', description='$group_desc' WHERE id=$group_id";
		if ($_SESSION['debug']) echo '<br>Update : '.$sql.'<br>';
		$res = $db->query($sql);
		$sql = "SELECT * FROM dyn_sql WHERE dyn_id=$group_id";
		$res = $db->query($sql);
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		$static_id = $row['STATIC_ID'];
		//$sql = "UPDATE mdyn_groups SET name='$group_name', comments='$group_desc' WHERE group_id=$static_id";
		//$res = $db->query($sql);
	}
	
	if (($group_name == '') || ($group_desc=='')) {
		$sql = "SELECT * FROM dyn_groups WHERE id=$group_id";
		$res = $db->query($sql);
		if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$group_name = $row['NAME'];
			$group_desc = $row['DESCRIPTION'];
		}
	}
	
	if ($action == 'Query Add') {
		$dynid = $db->nextId("AUTO_DYN_QUERY_ID_SEQ");
		$sql = "INSERT INTO dyn_query VALUES ('$cat', '$attr', '$op', '$val', $group_id, $dynid, '$func')";
		echo $sql;
		$res = $db->query($sql);
		$action = '';
	}
	
	if (($action == 'Query Update' ) && ($editing=='no')) {
		$sql = "UPDATE dyn_query SET cat='$cat', attr='$attr', op='$op', val='$val', function='$func' WHERE id='$query_id'";
		$res = $db->query($sql);
		$action = '';
		$editing = 'no';
		echo 'DEBUG: '.$action;
	}
	
	if ($action == 'Query Edit') {
		$editing = $_POST['editing'];
		if ($editing == '') $edition = $_GET['editing'];
		if ($editing<>'yes') {
			$sql = "SELECT * FROM dyn_query WHERE id='$query_id'";
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
		$sql = "DELETE FROM dyn_query WHERE id=$query_id";
		$res = $db->query($sql);
		$action = '';
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
 document.group_form.action.value=action;
 document.group_form.editing.value='no';
 document.group_form.submit();
}

function filllist()
{
 document.group_form.val.value=document.group_form.form_list.value;
}

function change_cat()
{
 document.group_form.attr.value='';
 document.group_form.submit();
}

</script>

<br>

<form action="<?php echo $PHP_SELF; ?>" name="group_form">
<table cellspacing="0" cellpadding="0" border="0" align="center" width="75%" class="framework"><tr><td align="center">
<b>Group Name: </b>

<INPUT type="text" name="group_name" value="<?php echo $group_name ?>" size="20"></td>
<td><b>Description: </b>
<INPUT type="text" name="group_desc" value="<?php echo $group_desc ?>" size="20"></td>
<td><input type="submit" name="update" class="button" onClick="javascript:void(update('GroupUpdate'))" value="Update"></td>
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

	$sql = "SELECT * FROM dyn_definitions ORDER BY cat";
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
<td align="center" valign="bottom"><SELECT name="attr" onchange="document.group_form.submit();">

<?php

	$sql = "SELECT DISTINCT * FROM dyn_definitions WHERE cat='$cat'";
	$res = $db->query($sql);
	while ( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		if ($attr == '') $attr = $row['ATTR'];		
		$txt = $row['ATTR'];
		if ($_SESSION['debug']) echo $txt.'!!'.$attr;
		$selected = '';
		if ($txt==$attr) $selected = 'SELECTED ';
		echo '<OPTION '.$selected.'name="'.$txt.'">'.$txt.'</option>';
	}
?>

</select></td>
<td align="center" valign="bottom"><SELECT name="op" onchange="document.group_form.submit()">
<?php 

	$sql = "SELECT DISTINCT * FROM dyn_operators";
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
<td align="center" valign="bottom"><SELECT name="form_list" id="form_list" cols="10" onchange="filllist();">


<?php 
	
	$sql = "SELECT * FROM dyn_definitions WHERE cat='$cat' AND attr='$attr'";
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
<td align="center" valign="bottom"><SELECT name="func" onchange="document.group_form.submit()">

<?php 

	$selected = '';
	if ($func=='AND') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="AND">AND</option>';
	$selected = '';
	if ($func=='OR') $selected = 'SELECTED ';
	echo '<OPTION '.$selected.'name="OR">OR</option>'."\n";
	echo '</select>';

	//if ($action == '') $action = 'GroupUpdate';
?>
	
</td>
<td>
<INPUT type="hidden" name="action" value="<?php echo $action; ?>">
<INPUT type="hidden" name="query_id" value="<?php echo $query_id ?>">
<INPUT type="hidden" name="group_id" value="<?php echo $group_id ?>">
<INPUT type="hidden" name="column_id" value="<?php echo $column_id ?>">
<INPUT type="hidden" name="editing" value="<?php echo $editing ?>">

<?php

	$txt_action=$action;
	if ($action == '') $txt_action = 'Query Add';
	if ($action == 'Query Edit') $txt_action = 'Update Query';
	if ( strpos($txt_action, 'Column', 1) || strpos($txt_action, 'Group', 1) ) $txt_action='Query Add';
	echo '<a href="javascript:void(update(\''.$txt_action.'\'))">';
	
	if ($txt_action=='Query Add') {
		echo '<img border="0" src="images/menu/query_add.gif"> ';
	} else if (($action == 'Query Edit') || ($action == 'Query Update')) {
		echo '<img border="0" src="images/menu/query_update.gif"> ';
	}
	echo '&nbsp;'.$txt_action.'</a> &nbsp; </td></tr>';
	
	$sql = "SELECT DISTINCT * FROM dyn_query WHERE report= $group_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<tr><td colspan="7"><hr></td></tr>
		<tr>
		<td><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['CAT']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['ATTR']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['OP']; ?></a>&nbsp;</td>
		<td colspan="2"><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['VAL']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&action=Query Edit&editing=no"><?php echo $row['FUNCTION']; ?></a>&nbsp;</td>
		<td><A class="breadcrumbs" HREF="dyngroup/group_build.php?group_id=<?php echo $group_id ?>&query_id=<?php echo $row['ID']; ?>&group_name=<?php echo $group_name; ?>&group_desc=<?php echo $group_desc; ?>&action=Query Delete"><img border="0" src="images/menu/delete.gif">Delete</a></td>
		</tr>
		
		<?php
	}
?>

</table></br>

<br>
<table cellpadding="0" cellspacing="0" border="0" class="framework" align="center" width="300px">
<tr><td align="center">
	<A href="dyngroup/group_build.php?action=saveGroup&group_id=<?php echo $group_id ?>"><img border="0" src="images/menu/ok.gif">Return to Dynamic Group Control</a>
</td></tr>
</table>
</form>
<?php 
	require ($_include_path.'cc_html/footer.inc.php');
?>