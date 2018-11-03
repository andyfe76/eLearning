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
	$_POST['form_notify']	= intval($_POST['form_notify']);
	$_POST['form_hide']		= intval($_POST['form_hide']);
	$_POST['form_title']	= trim($_POST['form_title']);

	if ($_POST['form_title'] == '') {
		$errors[]=AT_ERROR_SUPPLY_TITLE;
	}
	
	/* check mandatory fields */
	$sql = "SELECT * FROM course_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while ($rowm = mysql_fetch_array($res)) {
		if ($rowm['mandatory'] >0) {	
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
	
	if (!$errors) {
	
		$_POST['form_notify'] = intval($_POST['form_notify']);
		$sql = "UPDATE courses SET access='$_POST[form_access]', modif_date=NOW(), title='$_POST[form_title]', description='$_POST[form_description]', notify=$_POST[form_notify], tracking='$_POST[tracking]', max_quota=$MaxCourseSize, max_file_size=$MaxFileSize, hide=$_POST[form_hide]";
		for( $i=1; $i<=10; $i++ ) {
			$sql = $sql.", custom".$i."=";
			$cdata = 'custom'.$i;
			$sql = $sql."'$_POST[$cdata]'";
		}
		$sql = $sql." WHERE course_id=$form_course_id AND member_id=$_SESSION[member_id]";
		$result = mysql_query($sql, $db);
		
		if (!$result) {
			echo 'DB Error: '.$sql;
			exit;
		}

		$course_id = mysql_insert_id();

		$sql 	= "UPDATE crel_groups SET group_id=$_POST[group] WHERE course_id=$form_course_id";
		$res 	= mysql_query($sql, $db);
		
		$sql	= "UPDATE course_type SET course_type=$_POST[form_type] WHERE course_id=$form_course_id";
		$res 	= mysql_query($sql, $db);
	
		$_POST['form_roi_coststud'] = intval($_POST['form_roi_coststud']);
		$_POST['form_roi_costinstr'] = intval($_POST['form_roi_costinstr']);
		
		$sql	= "UPDATE roi SET cost_student=$_POST[form_roi_coststud], cost_instructor=$_POST[form_roi_costinstr] WHERE course_id=$form_course_id";
		$result = mysql_query($sql, $db);
		
		if (!$result) {
			echo 'DB Error: Could not insert ROI details';
			exit;
		}
		
		$sql 	= "UPDATE skills SET skill_desc='$_POST[skill]', min_grade=$_POST[min_grade] WHERE course_id=$form_course_id";
		$result = mysql_query($sql, $db);
		
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
				$start_date = "$year_start-$month_start-$day_start $hour_start:$min_start:00";
			} else {
				$start_date = 0;
			}
			if ($_POST['end_date'] == 1) {
				$end_date	= "$year_end-$month_end-$day_end $hour_end:$min_end:00";
			} else {
				$end_date = 0;
			}
			if ($_POST['period'] == 1) {
				$period	= intval($_POST['_period']);
			} else {
				$period	= 0;
			}
			
			$sql 	= "UPDATE course_availability SET start_date='$start_date', end_date='$end_date', period=$_POST[period_value] WHERE course_id=$form_course_id";
			$result	= mysql_query($sql, $db);

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
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	
	$sql	= "SELECT * FROM course_availability WHERE course_id=$_GET[course]";
	$res	= mysql_query($sql, $db);
	$row_av	= mysql_fetch_array($res);
	
	$sql		= "SELECT * FROM roi WHERE course_id=$_GET[course]";
	$roi_result = mysql_query($sql, $db);
	$roi_row	= mysql_fetch_array($roi_result);
	
	$sql	= "SELECT * FROM skills WHERE course_id=$_GET[course]";
	$s_res	= mysql_query($sql, $db);
	$row_s	= mysql_fetch_array($s_res);
?>

<input type="hidden" name="form_course" value="true">
<input type="hidden" name="form_course_id" value="<?php echo $course; ?>">
<input type="hidden" name="old_access" value="<?php echo $row['access']; ?>">

<h2><?php echo  $_template['course_properties']; ?></h2>

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td colspan="2" class="cat"><h4><?php echo  $_template['course_information']; ?></h4></td>
</tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['course_group']; ?>:</b></td>
	<td class="row1">
		<span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">
		<?php
			$sql = "SELECT * FROM crel_groups WHERE course_id=$_GET[course]";
			$res = mysql_query($sql, $db);
			$rowg = mysql_fetch_array($res);
			$group_id = $rowg['group_id'];
			
			$sql = "SELECT * FROM course_groups";
			$res = mysql_query($sql, $db);
			$no_groups = 0;
			if ($rowg = mysql_fetch_array($res)) {
				do {
					echo '<option value="'.$rowg['group_id'];
					$no_groups++;
					if ($group_id == $rowg['group_id']) {
						echo '" selected="selected">';
					} else {
						echo '">';
					}
					echo $rowg['name'];
				} while ($rowg = mysql_fetch_array($res));
			} else {
				if ($no_groups == 0) {
					$errors[] = AT_ERROR_NO_COURSE_GROUPS;
					// please define a group first
				}
			}
		?>
		</select></span>
	</td>
</tr>
<tr>
	<td class=row1 align=right nowrap="nowrap"><b><?php echo  $_template['course_name']; ?>:</b></td>
	<td class=row1><input type="text" id="title" name="form_title" class="formfield" size="40" value="<?php echo $row['title']; ?>"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><?php echo $_template['skill']; ?>:</b></td>
	<td class="row1" valign="top"><textarea id="skill" cols="45" rows="4" class="formfield" name="skill"><?php echo $row_s['skill_desc'] ?></textarea>
	&nbsp;&nbsp; <b><?php echo $_template['min_grade']; ?>:</b>
	<input type="text" size="3" class="formfield" name="min_grade" value="<?php echo $row_s['min_grade']; ?>">
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td  class=row1 valign="top" align="right"><b><?php echo  $_template['access']; ?>:</b></td>
<?php
		switch ($row['access'])
		{

			case 'public':
					$pub = ' checked="checked"';
					$disable = 'disabled="disabled"'; // disable the nofity box
					break;

			case 'protected':
					$prot	 = ' checked="checked"';
					$disable = 'disabled="disabled"'; // disable the nofity box
					break;

			case 'private':
					$priv	= ' checked="checked"';
					break;
		}

		if ($row['notify']) {
			$notify = ' checked="checked"';
		}

		if ($row['hide']) {
			$hide = ' checked="checked"';
		}
?>
	<td class=row1><input type="radio" name="form_access" value="protected" id="prot" onclick="disableNotify();" <?php echo $prot; ?>><label for="prot"><b><?php echo  $_template['protected']; ?>:</b></label> <?php echo  $_template['about_protected']; ?>

		<br /><br />
		<input type="radio" name="form_access" value="private" id="priv" <?php echo $priv; ?>><label for="priv"><b><?php echo  $_template['private']; ?>:</b></label> <?php echo  $_template['about_private']; ?>
		<br />
		<br /></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td valign="top" class="row1" align="right"><b><?php  echo $_template['course_availability']; ?>:</b></td>
	<td class="row1" align="left">
	<table cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_START_DATE);  ?>
			<label for="start_date"><input type="checkbox" name="start_date" id="start_date" value="1"<?php 
			if ($row_av['start_date'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['start_date']; ?>
			</label>&nbsp;</td>
		<td class="row1">
		<?php
				if ($row_av['start_date'] == 0) {
					$row_av['start_date'] = AT_date();
				}
					
				$today_day   = substr($row_av['start_date'], 8, 2);
				$today_mon   = substr($row_av['start_date'], 5, 2);
				$today_year  = substr($row_av['start_date'], 0, 4);
	
				$today_hour  = substr($row_av['start_date'], 11, 2);
				$today_min   = substr($row_av['start_date'], 14, 2);
	
				$name = '_start';
				require($_include_path.'lib/release_date.inc.php');
	
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_END_DATE);  ?>
			<label for="end_date"><input type="checkbox" name="end_date" id="end_date" value="1" <?php 
			if ($row_av['end_date'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['end_date']; ?>
			</label>&nbsp;</td>
		<td class="row1">
		<?php
				if ($row_av['end_date'] == 0) {
					$row_av['end_date'] = AT_date();
				}
					
				$today_day   = substr($row_av['end_date'], 8, 2);
				$today_mon   = substr($row_av['end_date'], 5, 2);
				$today_year  = substr($row_av['end_date'], 0, 4);
	
				$today_hour  = substr($row_av['end_date'], 11, 2);
				$today_min   = substr($row_av['end_date'], 14, 2);
	
				$name = '_end';
				require($_include_path.'lib/release_date.inc.php');
	
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_PERIOD);  ?>
			<label for="period"><input type="checkbox" name="period" id="period" value="1"<?php 
			if ($row_av['period'] <> 0) echo 'checked="checked"';
			echo '>'.$_template['allowed_course_period']; ?>
			</label></td>
		<td class="row1">
		<input type="text" size="4" name="period_value" id="period_value" value="<?php echo $row_av['period']; ?>">
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
		if($row['tracking'] == 'on'){
			$on = ' checked="checked" ';
		} else {
			$off = ' checked="checked" ';
		}
		?>
		<input type="radio" name="tracking" value="off" id="toff" <?php echo $off; ?>><label for="toff"><?php  echo $_template['off']; ?></label> <input type="radio" name="tracking" value="on" id="ton"<?php echo $on; ?>><label for="ton"><?php  echo $_template['on']; ?></label>	
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>

<?php
	/* print mandatory fields */
	$sql = "SELECT * FROM course_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while ($rowm = mysql_fetch_array($res)) {
		if ($rowm['mandatory'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$rowm['name'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$row['custom'.$i].'"></td>';
			echo '</tr>';
		}
		$i++;
	}
?>
<tr><td height="1" class="row2" colspan="2"></td></tr>

<tr>
	<td class="cat" colspan="2"><h4><?php echo $_template['optional']; ?> </h4></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class=row1 valign="top" align="right"><b><?php echo  $_template['description']; ?>:</b></td>
	<td class=row1><textarea id="description" cols="45" rows="4" class="formfield" name="form_description"><?php echo $row['description']; ?></textarea></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>
<?php
	$sql = "SELECT * FROM course_custom_fields";
	$res = mysql_query($sql, $db);
	$i =1;
	while($rowm = mysql_fetch_array($res)) {
		if (($rowm['mandatory'] ==0) && ($rowm['name'] <>'')) {
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$rowm['name'].' :</b></td>';
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" size="30" value="'.$row['custom'.$i].'" /></td>';
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
				<input type="text" id="roi_coststud" name="form_roi_coststud" class="formfield" size="13" value="<?php echo $roi_row['cost_student']; ?>"> EURO
			</td>
		</tr><tr>
			<td valign="middle" width="30%">
				<label for="roi_costinstr"><b> <?php echo  $_template['roi_costinstr']; ?>: </b></label>
			</td><td valign="top">
				<input type="text" id="roi_costinstr" name="form_roi_costinstr" class="formfield" size="13" value="<?php echo $roi_row['cost_instructor']; ?>"> EURO
			</td>
		</tr>	
		</table>
		<br /><br />
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td  class=row1 colspan=2 align="center"><input type="submit" name="submit" class="button" value="<?php echo  $_template['update_properties']; ?>" accesskey="s"> - <input type="submit" name="cancel" value="<?php echo $_template['cancel'];?>" class="button"></td>
</tr>
</table>
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
