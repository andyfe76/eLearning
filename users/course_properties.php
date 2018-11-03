<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['cancel']) {
	Header ('Location: '.$_base_href.'users/index.php');
	exit;
}

if ($_POST['form_course'])
{
	if ((!$_SESSION['is_admin']) && (!$_SESSION['c_instructor'])) {
		Header ('Location: '.$_base_href.'users/index.php?f='.AT_FEEDBACK_ACCESS_DEDIED);
		exit;
	}
	$_POST['form_notify']	= intval($_POST['form_notify']);
	$_POST['form_hide']		= intval($_POST['form_hide']);
	$_POST['form_title']	= trim($_POST['form_title']);

	if ($_POST['form_title'] == '') {
		$errors[]=AT_ERROR_SUPPLY_TITLE;
	}
	
	/* check mandatory fields */
	$sql = "SELECT * FROM course_custom_fields";
	$res = $db->query($sql);
	$i =1;
	while ($rowm =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($rowm['MANDATORY'] >0) {	
			if ($_POST['custom'.$i] == '') {
				$errors[]=AT_ERROR_MANDATORY_FIELDS;
			}
		}
		$i++;
	}
	if (!isset($_GET['course'])) {
		$form_course_id = intval($_POST['form_course_id']);
		$_GET['course'] = $form_course_id;
		//echo 'COURSE ID: '.$form_course_id.'<br>';
	}
	
	if ($_POST['form_enrol_notif']) {
			$sql	= "UPDATE notifications SET	text='$_POST[form_enrol_notif]' WHERE name='ENROLL' AND course_id=".$_GET['course'];
			$result	= $db->query($sql);

}
	if (!$errors) {
	
		$_POST['form_notify'] = intval($_POST['form_notify']);
		if ($_POST['form_access'] == '') $_POST['form_access'] = 'private';
		$sql = "UPDATE courses SET accesstype='$_POST[form_access]', modif_date=SYSDATE, title='$_POST[form_title]', description='$_POST[form_description]', notify=$_POST[form_notify], tracking='$_POST[tracking]', max_quota=$MaxCourseSize, max_file_size=$MaxFileSize, hide=$_POST[form_hide]";
		for( $i=1; $i<=10; $i++ ) {
			$sql .= ", custom".$i."=";
			$cdata = 'custom'.$i;
			$sql .= "'$_POST[$cdata]'";
		}
		$sql .= " WHERE course_id=$form_course_id";
		$result = $db->query($sql);
		
		if (PEAR::isError($result)) {
			echo 'DB Error: '.$sql.'<br><br>';
			print_r($result);
			exit;
		}

		$sql 	= "UPDATE crel_groups SET group_id=$_POST[group] WHERE course_id=$form_course_id";
		$res 	= $db->query($sql);
		
		$sql	= "UPDATE course_type SET course_type=$_POST[form_type] WHERE course_id=$form_course_id";
		$res 	= $db->query($sql);
	
		$_POST['form_roi_coststud'] = intval($_POST['form_roi_coststud']);
		$_POST['form_roi_costinstr'] = intval($_POST['form_roi_costinstr']);
		
		$sql = "SELECT * from roi WHERE course_id=$form_course_id";
		$result = $db->query($sql);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		if ($count0[0] == 0) {
			$sql	= "INSERT INTO roi VALUES ($form_course_id, $_POST[form_roi_coststud], $_POST[form_roi_costinstr], 0)";
			$result = $db->query($sql);
		} else {		
			$sql	= "UPDATE roi SET cost_student=$_POST[form_roi_coststud], cost_instructor=$_POST[form_roi_costinstr] WHERE course_id=$form_course_id";
			$result = $db->query($sql);
		}
		
		if (PEAR::isError($result)) {
			echo 'DB Error: Could not insert ROI details';
			exit;
		}
		
		$sql = "SELECT COUNT(course_id) FROM skills WHERE course_id=$form_course_id";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		if ($_POST['min_grade'] == '') $_POST['min_grade'] = 0;
		if ($row[0] == 0) {
			$sk_id = $db->nextId("AUTO_SKILLS_SKILL_ID");
			$sql = "INSERT INTO skills VALUES ($sk_id, '$_POST[skill]', $form_course_id, $_POST[min_grade])";
		} else {
			$sql 	= "UPDATE skills SET skill_desc='$_POST[skill]', min_grade=$_POST[min_grade] WHERE course_id=$form_course_id";
		}
		$result = $db->query($sql);
		if (PEAR::isError($result)) {
			echo 'DB Error: ';
			echo $sql;
			echo '<br><br>';
			print_r($result);
		}
		
		$sql 	= "SELECT COUNT(course_id) FROM course_maxstud WHERE course_id=$form_course_id";
		$result = $db->query($sql);
		$row = $result->fetchRow();
		if ($_POST['max_stud']=='') $_POST['max_stud'] = 99999999;
		if ($row[0] >0) {
			$sql 	= "UPDATE course_maxstud SET max_stud=$_POST[max_stud] WHERE course_id=$form_course_id";
			$result = $db->query($sql);
		} else {
			$sql 	= "INSERT INTO course_maxstud VALUES ($form_course_id, $_POST[max_stud])";
			$result = $db->query($sql);
		}
		
		$day_start	= intval($_POST['day_start']);
		$month_start= intval($_POST['month_start']);
		$year_start	= intval($_POST['year_start']);
		$hour_start	= intval($_POST['hour_start']);
		$min_start	= intval($_POST['min_start']);

		$day_end	= intval($_POST['day_end']);
		$month_end	= intval($_POST['month_end']);
		$year_end	= intval($_POST['year_end']);
		$hour_end	= intval($_POST['hour_end']);
		$min_end	= intval($_POST['min_end']);

		$start_date = 1;
		$end_date = 1;
		if ($_POST['start_date'] == ''){
			$start_date = 0;
		}
		if ($_POST['end_date'] == '') {
			$end_date = 0;
		}
				
		if ($start_date>0) {
			if (!checkdate($month_start, $day_start, $year_start)) {
				$errors[]= AT_ERROR_START_DATE_INVALID;
			}
		}

		if ($end_date>0) {
			if (!checkdate($month_end, $day_end, $year_end)) {
				$errors[]=AT_ERROR_END_DATE_INVALID;
			}
		}
		
		if (!$errors) {
			if (strlen($month_start) == 1){
				$month_start = "0$month_start";
			}
			if (strlen($day_start) == 1){
				$day_start = "0$day_start";
			}
			if (strlen($hour_start) == 1){
				$hour_start = "0$hour_start";
			}
			if (strlen($min_start) == 1){
				$min_start = "0$min_start";
			}

			if (strlen($month_end) == 1){
				$month_end = "0$month_end";
			}
			if (strlen($day_end) == 1){
				$day_end = "0$day_end";
			}
			if (strlen($hour_end) == 1){
				$hour_end = "0$hour_end";
			}
			if (strlen($min_end) == 1){
				$min_end = "0$min_end";
			}

			if ($_POST['start_date'] == 1) {
				$start_date = "$day_start/$month_start/$year_start $hour_start:$min_start:00";
			} else {
				$start_date = 0;
			}
			
			if ($_POST['end_date'] == 1) {
				$end_date	= "$day_end/$month_end/$year_end $hour_end:$min_end:00";
			} else {
				$end_date = 0;
			}
			
			if ($_POST['period'] == 1) {
				$period	= intval($_POST['period_value']);
			} else {
				$period	= 0;
			}
			
			$sql = "SELECT COUNT(course_id) FROM course_availability WHERE course_id=$form_course_id";
			$res = $db->query($sql);
			$row = $res->fetchRow();
			if ($row[0] >0) {
				$sql 	= "UPDATE course_availability SET start_date=";
				if ($start_date==0) $sql .= "NULL, end_date=";
				else $sql .= "TO_DATE('$start_date', 'DD/MM/YYYY HH24:MI:SS'), end_date=";
				if ($end_date==0) $sql .= "NULL,";
				else $sql .= "end_date=TO_DATE('$end_date', 'DD/MM/YYYY HH24:MI:SS'), ";
				$sql .= "period=$period WHERE course_id=$form_course_id";
				$result	= $db->query($sql);
				if (PEAR::isError($result)){
					print_r($result);
					exit;
				}
			} else {
				$sql 	= "INSERT INTO course_availability VALUES($form_course_id, ";
				if ($start_date==0) $sql .= "NULL,";
				else $sql .= "TO_DATE('$start_date', 'DD/MM/YYYY HH24:MI:SS'), ";
				if ($end_date==0) $sql .= "NULL,";
				else $sql .= "end_date=TO_DATE('$end_date', 'DD/MM/YYYY HH24:MI:SS'), ";
				$sql .= "$period)";
				$result	= $db->query($sql);
				if (PEAR::isError($result)) {
					echo 'ERROR: '.$sql;
					echo '<br><br>';
					print_r($result);
					exit;
				}
			}
		}
		
		cache_purge('system_courses','system_courses');
		Header ('Location: '.$_base_href.'users/index.php?f='.urlencode_feedback(AT_FEEDBACK_COURSE_PROPERTIES));
		exit;
	}
}

require($_include_path.'cc_html/header.inc.php');

?>
<form method="post" action="<?php echo $PHP_SELF; ?>" name="course_form">
<?php
	$sql	= "SELECT * FROM courses WHERE course_id=$_GET[course]";// AND member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	$row	= $result->fetchRow(DB_FETCHMODE_ASSOC);
	
	$sql	= "SELECT course_id, TO_CHAR(start_date, 'DD/MM/YYYY HH24:MI:SS') as start_date, TO_CHAR(end_date, 'DD/MM/YYYY HH24:MI:SS') as end_date, period FROM course_availability WHERE course_id=$_GET[course]";
	$res	= $db->query($sql);
	$row_av	=$res->fetchRow(DB_FETCHMODE_ASSOC);
	
	$sql		= "SELECT * FROM roi WHERE course_id=$_GET[course]";
	$roi_result = $db->query($sql);
	$roi_row	=$roi_result->fetchRow(DB_FETCHMODE_ASSOC);
	
	$sql	= "SELECT S.*, C.* FROM skills S, course_maxstud C WHERE S.course_id=$_GET[course] AND S.course_id=C.course_id";
	$s_res	= $db->query($sql);
	$row_s	= $s_res->fetchRow(DB_FETCHMODE_ASSOC);
?>

<input type="hidden" name="form_course" value="true">
<input type="hidden" name="form_course_id" value="<?php echo $course; ?>">
<input type="hidden" name="old_access" value="<?php echo $row['ACCESSTYPE']; ?>">

<h2><?php echo  $_template['course_properties']; ?></h2>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td colspan="2" class="cat"><h4><?php echo  $_template['course_information']; ?></h4></td>
</tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['course_group']; ?>:</b></td>
	<td class="row1">
		<?php
			if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
				?>
				<span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">
				<?php
					$sql = "SELECT * FROM crel_groups WHERE course_id=$_GET[course]";
					$res = $db->query($sql);
					$rowg =$res->fetchRow(DB_FETCHMODE_ASSOC);
					$group_id = $rowg['GROUP_ID'];
					
					$sql = "SELECT * FROM course_groups";
					$res = $db->query($sql);
					$no_groups = 0;
					if ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
						do {
							echo '<option value="'.$rowg['GROUP_ID'];
							$no_groups++;
							if ($group_id == $rowg['GROUP_ID']) {
								echo '" selected="selected">';
							} else {
								echo '">';
							}
							echo $rowg['NAME'];
						} while ($rowg =$res->fetchRow(DB_FETCHMODE_ASSOC));
					} else {
						if ($no_groups == 0) {
							$errors[] = AT_ERROR_NO_COURSE_GROUPS;
							// please define a group first
						}
					}
				?>
				</select></span>
			<?php
			} else {
				$sql = "SELECT * FROM crel_groups WHERE course_id=$_GET[course]";
				$res = $db->query($sql);
				$rowg = $res->fetchRow(DB_FETCHMODE_ASSOC);
				$group_id = $rowg['GROUP_ID'];
				
				$sql = "SELECT * FROM course_groups";
				$res = $db->query($sql);
				$row_g = $res->fetchRow(DB_FETCHMODE_ASSOC);
				
				echo $row_g['NAME'];
				
			}
			?>
	</td>
</tr>
<tr>
	<td class=row1 align=right nowrap="nowrap"><b><?php echo  $_template['course_name']; ?>:</b></td>
	<td class=row1>
	<?PHP
		if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
	?>
	<input type="text" id="title" name="form_title" class="formfield" size="40" value="<?php echo $row['TITLE']; ?>">
	<?PHP
		} else {
			echo $row['TITLE'];	
		}
	?>
	</td>
</tr>

	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr><td class="row1" valign="top" align="right">
	<b><?php echo $_template['min_grade']; ?>:</b>
	</td><td class="row1" valign="top">
	<?php
	if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
	?>
	<input type="text" size="3" class="formfield" name="min_grade" id="min_grade" value="<?php echo $row_s['MIN_GRADE']; ?>">
	<?php
	} else {
		echo $row_s['MIN_GRADE'];
	}
	?>
	</td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><?php echo $_template['max_number_of_students']; ?>:</b></td>
	<td class="row1">
	<?php
	if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
	?>
		<input type="text" size="3" class="formfield" name="max_stud" id="max_stud" value="<?php echo $row_s['MAX_STUD']; ?>">
	<?php
	} else {
		echo $row_s['MAX_STUD'];
	}
	?>
	</td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td valign="top" class="row1" align="right"><b><?php  echo $_template['course_availability']; ?>:</b></td>
	<td class="row1" align="left">
	<table cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_START_DATE);  ?>
			<label for="start_date"><input type="checkbox" name="start_date" id="start_date" value="1"<?php 
			if ($row_av['START_DATE'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['start_date']; ?>
			</label>&nbsp;</td>
		<td class="row1">
		<?php
				if ($row_av['START_DATE'] == 0) {
					$today_day  = date('d');
					$today_mon  = date('m');
					$today_year = date('Y');
					$today_hour = date('H');
					$today_min  = 0;
				} else {
					$today_day   = substr($row_av['START_DATE'], 0, 2);
					$today_mon   = substr($row_av['START_DATE'], 3, 2);
					$today_year  = substr($row_av['START_DATE'], 6, 4);
					$today_hour  = substr($row_av['START_DATE'], 11, 2);
					$today_min   = substr($row_av['START_DATE'], 14, 2);
				}
	
				$name = '_start';
				require($_include_path.'lib/release_date.inc.php');
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_END_DATE);  ?>
			<label for="end_date"><input type="checkbox" name="end_date" id="end_date" value="1" <?php 
			if ($row_av['END_DATE'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['end_date']; ?>
			</label>&nbsp;</td>
		<td class="row1">
		<?php
				if ($row_av['END_DATE'] == 0) {
					$today_day  = date('d');
					$today_mon  = date('m');
					$today_year = date('Y');
					$today_hour = date('H');
					$today_min  = 0;
				} else {
					$today_day   = substr($row_av['END_DATE'], 0, 2);
					$today_mon   = substr($row_av['END_DATE'], 3, 2);
					$today_year  = substr($row_av['END_DATE'], 6, 4);
					$today_hour  = substr($row_av['END_DATE'], 11, 2);
					$today_min   = substr($row_av['END_DATE'], 14, 2);
				}
	
				$name = '_end';
				require($_include_path.'lib/release_date.inc.php');
	
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_PERIOD);  ?>
			<label for="period"><input type="checkbox" name="period" id="period" value="1"<?php 
			if ($row_av['PERIOD'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['allowed_course_period']; ?>
			</label></td>
		<td class="row1">
		<input type="text" size="4" name="period_value" id="period_value" value="<?php echo $row_av['PERIOD']; ?>">
		</td>
	</tr>
	</table>
</td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class=row1 align=right nowrap="nowrap"><b><?php echo  $_template['tracking']; ?>:</b></td>
	<td class=row1 align=left>
	<?php
		if (($row['TRACKING']=="on ") || ($row['TRACKING']=='on')) {
			$on = ' checked="checked" ';
		} else {
			$off = ' checked="checked" ';
		}
		
		if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
	?>
			<input type="radio" name="tracking" value="off" id="toff" <?php echo $off; ?>><label for="toff"><?php  echo $_template['off']; ?></label> <input type="radio" name="tracking" value="on" id="ton"<?php echo $on; ?>><label for="ton"><?php  echo $_template['on']; ?></label>	
	<?php
		} else {
			if (isset($on)) {
				echo "ON";
			} else if (isset($off)) {
				echo "OFF";
			}
		}
	?>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>

<?php
	/* print mandatory fields */
	$sql = "SELECT * FROM course_custom_fields";
	$res = $db->query($sql);
	$i =1;
	while ($rowm =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($rowm['MANDATORY'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$rowm['NAME'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$row['CUSTOM'.$i].'"></td>';
			echo '</tr>';
		}
		$i++;
	}
?>
</table>
<br><br>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">

<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['optional']; ?> </h4></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<?
$sql	= "SELECT text FROM notifications WHERE name='ENROLL' AND course_id=".$_GET['course'];
$result2	= $db->query($sql);
$row2	=$result2->fetchRow(DB_FETCHMODE_ASSOC);


?>
<tr>
	<td class=row1 valign="top" align="right"><b><?php echo  $_template['enrol_notif']; ?>:</b></td>
	<td class=row1><textarea id="description" cols="45" rows="4" class="formfield" name="form_enrol_notif"><?php echo $row2['TEXT']; ?></textarea></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class=row1 valign="top" align="right"><b><?php echo  $_template['description']; ?>:</b></td>
	<td class=row1><textarea id="description" cols="45" rows="4" class="formfield" name="form_description"><?php echo $row['DESCRIPTION']; ?></textarea></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>

<?php
	$sql = "SELECT * FROM course_custom_fields";
	$res = $db->query($sql);
	$i =1;
	while($rowm =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (($rowm['MANDATORY'] ==0) && ($rowm['NAME'] <>'')) {
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$rowm['NAME'].' :</b></td>';
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" size="30" value="'.$row['CUSTOM'.$i].'" /></td>';
			echo '</tr>';
		}
		$i++;
	}
?>

<tr>
	<td class=row1 valign="top" align="right"><b><?php echo  $_template['ROI']; ?>:</b></td>
	<td class=row1>
		<table>
		<tr><td valign="middle" width="30%">
				<label for="roi_coststud"><b> <?php echo  $_template['roi_coststud']; ?>: </b></label>
			</td><td valign="top">	
				<input type="text" id="roi_coststud" name="form_roi_coststud" class="formfield" size="13" value="<?php echo $roi_row['COST_STUDENT']; ?>"> EURO
			</td>
		</tr><tr>
			<td valign="middle" width="30%">
				<label for="roi_costinstr"><b> <?php echo  $_template['roi_costinstr']; ?>: </b></label>
			</td><td valign="top">
				<input type="text" id="roi_costinstr" name="form_roi_costinstr" class="formfield" size="13" value="<?php echo $roi_row['COST_INSTRUCTOR']; ?>"> EURO
			</td>
		</tr>	
		</table>
		<br /><br />
	</td>
</tr>
</table>
<br><br>
<?php
	if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
?>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td  class=row1 colspan=2 align="center"><input type="submit" name="submit" class="button" value="<?php echo  $_template['update_properties']; ?>" accesskey="s"> - <input type="submit" name="cancel" value="<?php echo $_template['cancel'];?>" class="button"></td>
</tr>
</table>
<?php
	}
?>

</form>

<SCRIPT language=JavaScript>
<!--
function enableNotify()
{
	document.course_form.form_notify.disabled = false;
	document.course_form.form_hide.disabled = false;
}

function disableNotify()
{
	document.course_form.form_notify.disabled = true;
	document.course_form.form_hide.disabled = true;
}

// -->
</script>
<?php
require ($_include_path.'cc_html/footer.inc.php'); 
?>