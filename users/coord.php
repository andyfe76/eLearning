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
	} else {
		$errors = AT_ERROR_DB_NOT_UPDATED;
		print_errors($errors);
		exit;
	}
	
	if (isset($_POST['coordsel_courses'])) {
		$sql = "DELETE FROM coord_courses WHERE member_id=$_POST[member_id]";
		$res = $db->query($sql);
		$coordsel= explode(",", $_POST['coordsel_courses']);
		
		foreach ($coordsel as $cid) {
			if ($cid<>0) {
				$sql = "INSERT INTO coord_courses VALUES ($_POST[member_id], $cid)";
				$res = $db->query($sql);
			}
		}
	} else {
		$errors = AT_ERROR_DB_NOT_UPDATED;
		print_errors($errors);
		exit;
	}
	Header("Location: usermng.php?grp=".$group."&f=".AT_FEEDBACK_SUCCESS);
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

<!-- Begin -->
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


function CoordSelectAllGroups(f, fbox) {
	flen = fbox.options.length +0;
	for(var i=0; i<flen; i++) {
		f.coordsel.value += fbox.options[i].value + ",";
	}
	return true;
}
function CoordSelectAllCourses(f, fbox) {
	flen = fbox.options.length +0;
	for(var i=0; i<flen; i++) {
		f.coordsel_courses.value += fbox.options[i].value + ",";
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
<!-- End -->
</script>

<script>

function click_sel()
{
 document.all.val.value=document.all.sel.value;
}

function update(action)
{
 document.coordmng.action.value=action;
 document.coordmng.editing.value='no';
 // document.coordmng.submit();
}

function filllist()
{
 document.coordmng.val.value=document.coordmng.form_list.value;
}

function change_cat()
{
 document.coordmng.attr.value='';
 document.coordmng.submit();
}

function enableTest() {
	coordmng.tests.disabled = false;
}

function getEnrCourses(myForm, myArray, sliceLength) {
  var arrayLength = myArray.length;
  var selMakeIndex = myForm.enr_modules.selectedIndex;
  var selMake = myForm.enr_modules.options[selMakeIndex].text;
  myForm.enr_courses.options.length = 0;
  myForm.tests.options.length = 0;
  var modelIndex = 0;
  var testIndex = 0;

  myForm.enr_courses.options[modelIndex] =
  	new Option ("<?php echo $_template['any_course']; ?>", "-1");
  myForm.tests.options[modelIndex] = new Option ("<?php echo $_template['no_condition']; ?>", "-1");
  modelIndex++;
  testIndex++;

  for (var i=0;i<arrayLength;i++) {
    if (selMake == myArray[i][0]) {
      for (var j=1;j<myArray[i].length;j++) {
        var splitArray = myArray[i][j].split(":");
        var modelName = splitArray[0];
        var value = splitArray[1];
		
		var tid = 2;
		while ( splitArray[tid] ) {
			var tname = splitArray[tid++];
			var tvalue = splitArray[tid++];
			if (!tname.match(/.Discontinued./)) {
				myForm.tests.options[testIndex] = 
					new Option (tname.slice(0,sliceLength), tvalue);
				testIndex++;
			}
		}

        if (!modelName.match(/.Discontinued./)) {
          myForm.enr_courses.options[modelIndex] =
            new Option (modelName.slice(0,sliceLength), value);
          modelIndex++;
        }
      } // for j
    }
  } // for i
  
  myForm.tests.selectedIndex = 0;
  //myForm.test_op.disabled = false;
  //myForm.testmark.disabled = false;

  myForm.enr_courses.selectedIndex = 0;
  myForm.enr_courses.disabled = false;
  myForm.enr_courses.focus();
}

function getSGroups(myForm, myArray, sliceLength) {
  var arrayLength = myArray.length;
  var selMakeIndex = myForm.s_categories.selectedIndex;
  var selMake = myForm.s_categories.options[selMakeIndex].text;
  myForm.s_groups.options.length = 0;
  var modelIndex = 0;

  //myForm.s_groups.options[modelIndex] = new Option ("<?php echo $_template['all_groups']; ?>", "-1");
  //modelIndex++;

  for (var i=0;i<arrayLength;i++) {
    if (selMake == myArray[i][0]) {
      for (var j=1;j<myArray[i].length;j++) {
        var splitArray = myArray[i][j].split(":");
        var modelName = splitArray[0];
        var value = splitArray[1];

        if (!modelName.match(/.Discontinued./)) {
          myForm.s_groups.options[modelIndex] =
            new Option (modelName.slice(0,sliceLength), value);
          modelIndex++;
        }
      } // for j
    }
  } // for i
  
  myForm.s_groups.selectedIndex = 0;
  myForm.s_groups.disabled = false;
  myForm.s_groups.focus();
}

function getCGroups(myForm, myArray, sliceLength) {
  var arrayLength = myArray.length;
  var selMakeIndex = myForm.c_modules.selectedIndex;
  var selMake = myForm.c_modules.options[selMakeIndex].text;
  myForm.c_courses.options.length = 0;
  var modelIndex = 0;

  for (var i=0;i<arrayLength;i++) {
    if (selMake == myArray[i][0]) {
      for (var j=1;j<myArray[i].length;j++) {
        var splitArray = myArray[i][j].split(":");
        var modelName = splitArray[0];
        var value = splitArray[1];

        if (!modelName.match(/.Discontinued./)) {
          myForm.c_courses.options[modelIndex] =
            new Option (modelName.slice(0,sliceLength), value);
          modelIndex++;
        }
      } // for j
    }
  } // for i
  
  myForm.c_courses.selectedIndex = 0;
  myForm.c_courses.disabled = false;
  myForm.c_courses.focus();
}

function toggleFF(el, datafield, opfield) {
	if ( !el.checked ) {
		datafield.disabled = true;
		opfield.disabled = true;
	} else {
		datafield.disabled = false;
		opfield.disabled = false;
	}
}

function saveconfig() {
	CoordSelectAllGroups(document.coordmng, document.coordmng.coord_groups);
	CoordSelectAllCourses(document.coordmng, document.coordmng.coord_courses);
}

</script>

<?php
	echo '<script language="JavaScript">';
	$sql = "SELECT COUNT(*) FROM course_groups";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$modulesCount = $row[0];
	$sql = "SELECT COUNT(categ_id) FROM member_categ";
	$res = $db->query($sql);
	$row = $res->fetchRow();
	$categCount = $row[0];
	
	echo "\n".'var modules = new Array('.$modulesCount.');'."\n";
	echo "\n".'var categories = new Array('.$categCount.');'."\n";
	
	// Building Course Modules Array
	$sql = "SELECT * FROM course_groups";
	$res = $db->query($sql);
	$i = 0;
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT G.course_id, C.title FROM crel_groups G INNER JOIN courses C ON G.course_id=C.course_id WHERE G.group_id=$row[GROUP_ID]";
		$resm = $db->query($sql);
		echo 'modules['.$i++.'] = new Array("'.$row['NAME'].'"';
		while ($rowm = $resm->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo ', "'.$rowm['TITLE'].':'.$rowm['COURSE_ID'];
			$sql = "SELECT title, test_id FROM tests WHERE course_id=$rowm[COURSE_ID]";
			$rest = $db->query($sql);
			while ($rowt = $rest->fetchRow(DB_FETCHMODE_ASSOC)) {
				echo ':'.$rowt['TITLE'].':'.$rowt['TEST_ID'];
			}
			echo '"';
		}
		echo ');';
		echo "\n";
	}
	
	// Building Member Groups Array
	$sql = "SELECT * FROM member_categ";
	$res = $db->query($sql);
	$i = 0;
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT group_id, name FROM member_groups WHERE category='".$row[NAME]."'";
		$resm = $db->query($sql);
		echo 'categories['.$i++.'] = new Array("'.$row['NAME'].'"';
		while ($rowm = $resm->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo ', "'.$rowm['NAME'].':'.$rowm['GROUP_ID'];
			echo '"';
		}
		echo ');';
		echo "\n";
	}
	echo '</script>';
?>

<?php

	echo '<h1 class="left">'.$_template['coordinator_management'].': ';
	
	echo $_SESSION['login'].'</h1><br>';


	// Showing groups to assign to coordinator

	echo '<br><form id="coordmng" method="post" action="'.$PHP_SELF.'" name="coordmng">';
 	//echo '<b>'.$_template['existing_groups'].'</b><br>'; ?>
	<table cellspacing="1" cellpadding="0" class="bodyline" width="95%" summary="">
	<tr>
<?php
	$tcell_count = 0;
		// print category name:
	echo '<td width="20%" valign="top" align="center"><b>'.$_template['category'].': </b><br><br>';
	?>
	<select name="s_categories" onChange="getSGroups(coordmng, categories, 24)">
		<?php
			$sql = "SELECT * FROM member_categ";
			$res_tmp = $db->query($sql);
			while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($selcateg == '') $selcateg = $row_tmp['NAME'];
				$selected = '';
				echo '<option value="'.$row_tmp['NAME'].'" '.$selected.'>'.$row_tmp['NAME'].'</option>'."\n";
			}
		?>
	</select></td>
	
	<td valign="top"><b><?php echo $_template['group']; ?>:</b><br><br><select name="s_groups" size="12" style="width:200px;" multiple>>
		<?php
			$sql = "SELECT group_id, name FROM member_groups WHERE category='$selcateg' ORDER BY name";
			$res_tmp = $db->query($sql);
			while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
				$selected = '';
				echo '<option value="'.$row_tmp['GROUP_ID'].'" '.$selected.'>'.$row_tmp['NAME'].'</option>'."\n";
			}
		?>
	</select>
	<?php echo '<br><span class="small">'.$_template['multiple_select'].'</span>'; ?>
	</td>
	<?php
	echo "\n";
	echo '<td><input type="button" class="button2" value=">> '.$_template['assign'].' >>" onclick="move(this.form.s_groups, this.form.coord_groups)" name="assign">';
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

?>
	</table>
	<br><br>
	<table cellspacing="1" cellpadding="0" class="bodyline" width="95%" summary="">
	<tr>
<?php



	// ****************************
	// COURSE ASSIGNMENT
	// ****************************
	echo '<td width="20%" valign="top" align="center"><b>'.$_template['module'].': </b><br><br>';
	?>
	<select name="c_modules" onChange="getCGroups(coordmng, modules, 24)">
		<?php
			$selcateg = '';
			$sql = "SELECT * FROM course_groups";
			$res_tmp = $db->query($sql);
			while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($selcateg == '') $selcateg = $row_tmp['GROUP_ID'];
				$selected = '';
				echo '<option value="'.$row_tmp['GROUP_ID'].'" '.$selected.'>'.$row_tmp['NAME'].'</option>'."\n";
			}
		?>
	</select></td>
	<td valign="top"><b><?php echo $_template['course']; ?>:</b><br><br>
	<select name="c_courses" size="12" style="width:200px;" multiple>>
		<?php
			if ( $sel_categ== '' ) $sel_categ = 1;
			$sql = "SELECT C.course_id, C.title FROM courses C INNER JOIN crel_groups G ON C.course_id=G.course_id WHERE G.group_id=$selcateg ORDER BY C.title";
			$res_tmp = $db->query($sql);
			while ($row_tmp = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC)) {
				$selected = '';
				echo '<option value="'.$row_tmp['COURSE_ID'].'" '.$selected.'>'.$row_tmp['TITLE'].'</option>'."\n";
			}
		?>
	</select>
	<?php echo '<br><span class="small">'.$_template['multiple_select'].'</span>'; ?>
	</td>
	<?php
	echo "\n";
	echo '<td><input type="button" class="button2" value=">> '.$_template['assign'].' >>" onclick="move(this.form.c_courses, this.form.coord_courses)" name="assign">';
	echo "</td>\n";

	echo '<td width="30%" align="center">';
	echo '<b>'.$_template['coordinator_assigned_courses'].': </b><br><br>';
	echo "\n";
	echo '<select name="coord_courses" size="16" style="width:200px" multiple>';
	if ($mid == '') $mid = 0;
	$sql = "SELECT C.course_id, C.title FROM coord_courses K INNER JOIN courses C ON K.course_id=C.course_id WHERE K.member_id=$mid";
	$res_c = $db->query($sql);
	while ($row_c = $res_c->fetchRow(DB_FETCHMODE_ASSOC)) {
		echo '<option value="'.$row_c['COURSE_ID'].'">'.$row_c['TITLE'].'</option>';
	}
	//echo '<option value=""></option>';
	
	echo "\n";
	echo '</select>';
	echo '<br><br><center><input type="button" name="unassign" class="button2" value="<< '.$_template['unassign'].' <<" onclick="remove(this.form.coord_courses)"></center>';
	echo "\n";
	echo '</td>';
	echo '</tr>';

?>
	</table>
	
	
<?php
	echo '<input type="hidden" name="member_id" value="'.$member_id.'">';
	echo '<input type="hidden" name="group" value="'.$group.'">';
	echo '<input type="hidden" name="coordsel" value="">';
	echo '<input type="hidden" name="coordsel_courses" value="">';
?>
	<br><br>
	<table cellspacing="1" cellpadding="0" class="framework" width="95%" summary="">
	<tr>
	<td align="center"><input class="button" type="submit" onclick="saveconfig()" name="submit" value="<?php echo $_template['save_coordinator_configuration']?>">
	</td>
	</tr>
	</table>

	</form>
<?php	
	require ($_include_path.'cc_html/footer.inc.php');
?>
