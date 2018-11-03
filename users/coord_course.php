<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');

if ($_GET['grp']) {
	$group = $_GET['grp'];
	$sql = "SELECT category FROM member_groups WHERE group_id=$group";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$category = $row['NAME'];
}

if ($_POST['category']) {
	$category = $_POST['category'];
	$group = '';
}

if (($_POST['group']) && (!$_POST['form_categ_change'])) {
	$group = $_POST['group'];
}

if ($_POST['submit']) {
	if (isset($_POST['coordsel'])) {
		$sql = "DELETE FROM coord_groups WHERE member_id=$_POST[member_id]";
		$res = $db->query($sql);
		$coordsel= explode(",", $_POST['coordsel']);
		
		foreach ($coordsel as $gid) {
			if ($gid<>0) {
				$sql = "INSERT INTO coord_groups VALUES ($_POST[member_id], $gid)";
				$res = $db->query($sql);
			}
		}
		Header("Location: usermng.php?grp=".$group."&f=".AT_FEEDBACK_SUCCESS);
	}
	else {
		$errors = AT_ERROR_DB_NOT_UPDATED;
		print_errors($errors);
	}
}


require($_include_path.'cc_html/header.inc.php');

if (isset($_GET['mid'])) {
	$mid = $_GET['mid'];
} else if (isset($_POST['mid'])) {
	$mid = $_POST['mid'];
} else {
	$errors[] = AT_ERROR_ACCESS_DENIED;
	print_errors($errors);
	require($_include_path.'cc_html/footer.inc.php');
	exit;
}
$member_id  = $mid;

?>
<SCRIPT LANGUAGE="JavaScript">

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
sortitems = 1;  // Automatically sort items within lists? (1 or 0)


function move(fbox,tbox) {
	var duplicate;
	for(var i=0; i<fbox.options.length; i++) {
		if(fbox.options[i].selected && fbox.options[i].value != "") {
			duplicate = false;
			for(var j=0; j<tbox.options.length; j++) {
				if (fbox.options[i].value == tbox.options[j].value) {
					duplicate = true;
				}
			}
			if (duplicate==false) {
				var no = new Option();
				no.value = fbox.options[i].value;
				no.text = fbox.options[i].text;
				tbox.options[tbox.options.length] = no;
				// modified: keep old values in the source list
				//fbox.options[i].value = "";
				//fbox.options[i].text = "";
			}	
		}
	}

	BumpUp(fbox);
	if (sortitems) SortD(tbox);
}


function CoordSelectAll(f, fbox) {
	flen = fbox.options.length +0;
	for(var i=0; i<flen; i++) {
		f.coordsel.value += fbox.options[i].value + ",";
	}
	return true;
}

function remove(fbox) {
	for(var i=0; i<fbox.options.length; i++) {
	if(fbox.options[i].selected && fbox.options[i].value != "") {
		fbox.options[i].value = "";
		fbox.options[i].text = "";
	   }
	}
	BumpUp(fbox);
}

function BumpUp(box)  {
	for(var i=0; i<box.options.length; i++) {
		if(box.options[i].value == "")  {
			for(var j=i; j<box.options.length-1; j++)  {
				box.options[j].value = box.options[j+1].value;
				box.options[j].text = box.options[j+1].text;
			}
			var ln = i;
			break;
   		}
	}
	if(ln < box.options.length)  {
		box.options.length -= 1;
		BumpUp(box);
	}
}

function SortD(box)  {
	var temp_opts = new Array();
	var temp = new Object();
	for(var i=0; i<box.options.length; i++)  {
		temp_opts[i] = box.options[i];
	}
	for(var x=0; x<temp_opts.length-1; x++)  {
		for(var y=(x+1); y<temp_opts.length; y++)  {
			if(temp_opts[x].text > temp_opts[y].text)  {
				temp = temp_opts[x].text;
				temp_opts[x].text = temp_opts[y].text;
				temp_opts[y].text = temp;
				temp = temp_opts[x].value;
				temp_opts[x].value = temp_opts[y].value;
				temp_opts[y].value = temp;
      		}
   		}
	}
	for(var i=0; i<box.options.length; i++)  {
		box.options[i].value = temp_opts[i].value;
		box.options[i].text = temp_opts[i].text;
	}
}
// End -->
</script>

<?php

	echo '<h1 class="left">'.$_template['coordinator_management'].': ';
	
	echo $_SESSION['login'].'</h1><br>';


	// Showing groups to assign to coordinator

	echo '<br><form id="coordmng" method="post" action="'.$PHP_SELF.'" name="coordmng">';
 	//echo '<b>'.$_template['existing_groups'].'</b><br>'; ?>
	<table cellspacing="1" cellpadding="0" class="bodyline" width="95%" summary="">
	
<?php
	
 	$sql = "SELECT * FROM course_groups ORDER BY name";
 	$res = $db->query($sql);
 	
 	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		// print module name:
		echo '<tr>
		<td width="20%" valign="top" align="center"><b>'.$_template['module'].': </b>';
		echo strtoupper($row['NAME']).'</td></tr>';
		
		$sql = "SELECT course_id,title FROM courses WHERE course_id IN (SELECT course_id FROM crel_groups WHERE group_id=$row[GROUP_ID])"; // works in oracle console but not here. ? 
		$resr_g = $db->query($sql);
		print_r($resr_g);
		echo $sql;

		echo '<tr><td><select name="groups_'.$row['NAME'].'" size="12" style="width:200px;" multiple>'."\n";
		while ($row_g = $res_g->fetchRow(DB_FETCHMODE_ASSOC)){
		print_r($row_g)	;
			echo '<option value="'.$row_g['COURSE'].'">'.$row_g['TITLE'].'</option>'."\n";
			
		}echo '</select></td></tr>';
 	}
 	
 	
	/*$sql = "SELECT * FROM member_categ ORDER BY name";
	$res = $db->query($sql);
	$tcell_count = 0;
	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		// print category name:
		echo '<td width="20%" valign="top" align="center"><b>'.$_template['category'].': </b>';
		echo strtoupper($row['NAME']).'</td>';
		
		// select groups in category
		$sql = "SELECT group_id, name FROM member_groups WHERE category='$row[NAME]' ORDER BY name";
		$res_g = $db->query($sql);
		echo '<td><select name="groups_'.$row['NAME'].'" size="12" style="width:200px;" multiple>'."\n";
		while ($row_g = $res_g->fetchRow(DB_FETCHMODE_ASSOC)){
			echo '<option value="'.$row_g['GROUP_ID'].'">'.$row_g['NAME'].'</option>'."\n";
		}
		echo '</select></td>';
		echo "\n";
		echo '<td><input type="button" class="button2" value=">> '.$_template['assign'].' >>" onclick="move(this.form.groups_'.$row['NAME'].', this.form.coord_groups)" name="assign">';
		echo "</td>\n";
		if (!$tcell_count) {
			echo '<td rowspan="4" width="30%" align="center">';
			echo '<b>'.$_template['coordinator_assigned_groups'].': </b><br><br>';
			echo "\n";
			echo '<select name="coord_groups" size="16" style="width:200px" multiple>';
			$sql = "SELECT C.group_id, G.name FROM coord_groups C INNER JOIN member_groups G on C.group_id=G.group_id WHERE C.member_id=$mid";
			$res_c = $db->query($sql);
			while ($row_c = $res_c->fetchRow(DB_FETCHMODE_ASSOC)) {
				echo '<option value="'.$row_c['GROUP_ID'].'">'.$row_c['NAME'].'</option>';
			}
			//echo '<option value=""></option>';
			
			echo "\n";
			echo '</select>';
			echo '<br><br><center><input type="button" name="unassign" class="button2" value="<< '.$_template['unassign'].' <<" onclick="remove(this.form.coord_groups)"></center>';
			echo "\n";
			echo '</td>';
		}
		$tcell_count++;
		//echo '<td width="5%">&nbsp;</td>';
		echo '</tr>';
		if ($tcell_count == 2) {
			echo '<tr><td colspan="4"><br><span class="small">'.$_template['multiple_select'].'</span></td></tr>';
		} else {
			echo '<tr><td colspan="3"><hr></td></tr>';
		}
	}*/
?>
	</table>
<?php
	echo '<input type="hidden" name="member_id" value="'.$member_id.'">';
	echo '<input type="hidden" name="group" value="'.$group.'">';
	echo '<input type="hidden" name="coordsel" value="">';
?>
	<br><br>
	<table cellspacing="1" cellpadding="0" class="framework" width="95%" summary="">
	<tr>
	<td align="center"><input class="button" type="submit" onclick="CoordSelectAll(this.form, this.form.coord_groups);" name="submit" value="<?php echo $_template['save_coordinator_configuration']?>"></td>
	</tr>
	</table>

	</form>
<?php	
	require ($_include_path.'cc_html/footer.inc.php');
?>
