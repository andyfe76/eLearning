<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

if ($_POST['form_course']) {
	$_POST['form_notify']	= intval($_POST['form_notify']);
	$_POST['form_hide']		= intval($_POST['form_hide']);
	$_POST['form_title']	= trim($_POST['form_title']);

	if ($_POST['form_title'] == '') {
		$errors[]=AT_ERROR_SUPPLY_TITLE;
	} else {
	
		$_POST['form_notify'] = intval($_POST['form_notify']);

		$course_id = $db->nextId("AUTO_COURSES_COURSE_ID");
		if ($_POST['form_access'] == '') $_POST['form_access'] = 'private';
		$sql = "INSERT INTO courses VALUES ($course_id, $_SESSION[member_id], '$_POST[form_access]', SYSDATE, '$_POST[form_title]', '$_POST[form_description]', $_POST[form_notify], $MaxCourseSize, $MaxFileSize, $_POST[form_hide], '', '', '', '', '$_POST[tracking]', '$_POST[custom1]', '$_POST[custom2]', '$_POST[custom3]', '$_POST[custom4]', '$_POST[custom5]', '$_POST[custom6]', '$_POST[custom7]', '$_POST[custom8]', '$_POST[custom9]', '$_POST[custom10]', SYSDATE )";
		$result = $db->query($sql);

		if (PEAR::isError($result)) {
			echo 'DB Error<br>';
			print_r($result);
			exit;
		}

		if ($_POST['max_stud']=='') $_POST['max_stud'] = 99999999;
		$sql = "INSERT INTO course_maxstud VALUES ($course_id, $_POST[max_stud])";
		$res = $db->query($sql);

		//$sql	= "INSERT INTO course_enrollment VALUES($_SESSION[member_id], $course_id, 'y', SYSDATE, SYSDATE)";
		//$result	= $db->query($sql);

		// create the ./contents/COURSE_ID directory
		$path = '../content/'.$course_id.'/';
		$result = @mkdir($path, 0700);

		/* insert some default content: */
		$_SESSION['is_admin'] = 1;
		//$cid = $contentManager->addContent($course_id, 0, 0, 'Welcome To K-Lore Learning Management System.', 'Enjoy', '', 1, date('d/m/Y H:00:00'));
		$announcement = $_template['default_announcement'];
		
		$sql 	= "INSERT INTO crel_groups VALUES ($course_id, 0, $_POST[group])";
		$res 	= $db->query($sql);
		
		$sql	= "INSERT INTO course_type VALUES ($course_id, $_POST[form_type])";
		$res 	= $db->query($sql);
	
		$n_id 	= $db->nextId("AUTO_NEWS_NEWS_ID");
		//***
			//file
			$cfname = 'content/'.$n_id.'.news';
			
			ignore_user_abort(true);    ## prevent refresh from aborting file operations and hosing file
			$fh = fopen('../'.$cfname, 'w');  
	        fwrite($fh, $announcement);
	        fflush($fh);
	     	fclose($fh);
			ignore_user_abort(false);    ## put things back to normal
		
		
		//*** Notifications intit
		$sql	= "INSERT INTO notifications VALUES ('','ENROLL',$course_id )";
		$result = $db->query($sql);

		
		//***
		
		$sql	= "INSERT INTO news VALUES ($n_id, $course_id, $_SESSION[member_id], SYSDATE, 1, 'Welcome To K-Lore!', '$cfname')";
		$result = $db->query($sql);
		
		if (PEAR::isError($result)) {
			echo 'DB Error: Could not insert course details.<br>';
			print_r($result);
			exit;
		}
		
		$_POST['form_roi_coststud'] = intval($_POST['form_roi_coststud']);
		$_POST['form_roi_costinstr'] = intval($_POST['form_roi_costinstr']);

		$sql	= "INSERT INTO roi (course_id, cost_student, cost_instructor) VALUES ($course_id, $_POST[form_roi_coststud], $_POST[form_roi_costinstr])";
		$result = $db->query($sql);
	
		if (PEAR::isError($result)) {
			echo 'DB Error: Could not insert ROI details<br>';
			print_r($result);
			exit;
		}
		
		$sql = "SELECT COUNT(course_id) FROM skills WHERE course_id=$course_id";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		if ($_POST['min_grade']=='') $_POST['min_grade'] = 0;
		if ($row[0] == 0) {
			$sk_id = $db->nextId("AUTO_SKILLS_SKILL_ID");
			$sql = "INSERT INTO skills VALUES ($sk_id, '$_POST[skill]', $course_id, $_POST[min_grade])";
		} else {
			$sql 	= "UPDATE skills SET skill_desc='$_POST[skill]', min_grade=$_POST[min_grade] WHERE course_id=$course_id";
		}
		$result	= $db->query($sql);
		if (PEAR::isError($result)) {
			echo 'ERROR: ';
			print_r($result);
			exit;
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

		if (!checkdate($month_start, $day_start, $year_start)) {
			$errors[]= AT_ERROR_START_DATE_INVALID;

		}

		if (!checkdate($month_end, $day_end, $year_end)) {
			$errors[]=AT_ERROR_END_DATE_INVALID;
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
			
			$sql 	= "INSERT INTO course_availability VALUES ($course_id, ";
			if ($start_date==0) $sql .= "NULL,";
			else $sql .= "TO_DATE('$start_date', 'DD/MM/YYYY HH24:MI:SS'), ";
			if ($end_date==0) $sql .= "NULL,";
			else $sql .= "end_date=TO_DATE('$end_date', 'DD/MM/YYYY HH24:MI:SS'), ";
			$sql .= "$period)";
			$result	= $db->query($sql);
			$sql = "SELECT course_id, TO_CHAR(start_date, 'DD/MM/YYYY HH24:MI:SS') as start_date, TO_CHAR(end_date, 'DD/MM/YYYY HH24:MI:SS') as end_date, period FROM course_availability";
			$result = $db->query($sql);
			$row =$result->fetchRow(DB_FETCHMODE_ASSOC);

		cache_purge('system_courses','system_courses');
		Header ('Location: ../bounce.php?course='.$course_id.SEP);
		exit;
		}
	}
}

require($_include_path.'cc_html/header.inc.php'); 


/* verify that this user has status to create courses: */
	
	if (!$_SESSION['c_instructor']) {
		$errors[]=AT_ERROR_CREATE_NOPERM;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}

?>
<form method="post" action="<?php echo $PHP_SELF; ?>" name="course_form">
<input type="hidden" name="form_course" value="true" />

<h2><?php  echo $_template['create_course']; ?></h2>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td colspan="2" class="cat"><h4><?php  echo $_template['course_information']; ?></h4></td>
</tr>
<tr>
	<td class="row1" align="right"><b><?php echo $_template['course_group']; ?>:</b></td>
	<td class="row1">
		<span style="white-space: nowrap;"><select name="group" class="dropdown" id="group" title="Group">
		<?php
			$sql = "SELECT * FROM course_groups";
			$res = $db->query($sql);
			$no_groups = 0;
			if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
				do {
					echo '<option value="'.$row['GROUP_ID'].'">'.$row['NAME'];
					$no_groups++;
				} while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC));
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
	<td nowrap="nowrap" class="row1" align="right"><b><?php  echo $_template['course_name']; ?>:</b></td>
	<td class="row1"><input type="text" id="title" name="form_title" class="formfield" size="40" /></td>
</tr>

<tr><td height="1" class="row2" colspan="2"></td></tr>

<tr>
	<td valign="top" class="row1" align="right"><b><?php  echo $_template['course_type']; ?>:</b></td>
	<td class="row1">
	<input type="radio" value="1" name="form_type" id="online" checked="checked"><label for="offline"><b><?php echo $_template['online']; ?></b></label>: <?php echo $_template['about_online']?><br />
	<input type="radio" value="2" name="form_type" id="offline"><label for="offline"><b><?php echo $_template['offline']; ?></b></label>: <?php echo $_template['about_offline'] ?><br />
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
	<!--tr><td class="row1" valign="top" align="right">
	<b><?php //echo $_template['min_grade']; ?>:</b>
	</td><td class="row1" valign="top">
	<?php
		/*if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
			echo '<input type="text" size="3" class="formfield" name="min_grade" id="min_grade" value="'.$row_s['MIN_GRADE'].'">';
		} else {
			echo $row_s['MIN_GRADE'];
		}*/
	?>
	</td>
	</tr -->

<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" valign="top" align="right"><b><?php echo $_template['max_number_of_students']; ?>:</b></td>
	<td class="row1">
	<input type="hidden" name="form_access" value="private">
	<input type="text" size="3" class="formfield" name="max_stud">
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>


<tr>
	<td valign="top" class="row1" align="right"><b><?php  echo $_template['course_availability']; ?>:</b></td>
	<td class="row1" align="left">
	<table cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_START_DATE);  ?>
			<label for="start_date"><input type="checkbox" name="start_date" id="start_date" value="1" checked="checked"><?php echo $_template['start_date']; ?></label>&nbsp;</td>
		<td class="row1">
		<?php
					
				$today_day  = date('d');
				$today_mon  = date('m');
				$today_year = date('Y');
				$today_hour = date('H');
				$today_min  = 0;
				
				$name = '_start';
				require($_include_path.'lib/release_date.inc.php');
	
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_END_DATE);  ?>
			<label for="end_date"><input type="checkbox" name="end_date" id="end_date" value="1"><?php echo $_template['end_date']; ?></label>&nbsp;</td>
		<td class="row1">
		<?php
					
				$today_day  = date('d');
				$today_mon  = date('m');
				$today_year = date('Y');
				$today_hour = date('H');
				$today_min  = 0;
	
				$name = '_end';
				require($_include_path.'lib/release_date.inc.php');
	
		?>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left"><?php print_popup_help(AT_HELP_COURSE_PERIOD);  ?>
			<label for="period"><input type="checkbox" name="period" id="period" value="1"><?php echo $_template['allowed_course_period']; ?></label></td>
		<td class="row1">
		<input type="text" size="4" name="_period" id="_period">
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
		$on = ' checked="checked" '; ?>
		<input type="radio" name="tracking" value="off" id="toff" <?php echo $off; ?>><label for="toff"><?php  echo $_template['off']; ?></label> <input type="radio" name="tracking" value="on" id="ton"<?php echo $on; ?>><label for="ton"><?php  echo $_template['on']; ?></label>
	</td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>


<?php
	$sql = "SELECT * FROM course_custom_fields";
	$res = $db->query($sql);
	$i =1;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($row['MANDATORY'] >0) {	
			echo '<tr><td class="row1" align="right"><b>'.$row['NAME'].' :</b></td>';
 			echo '<td class="row1" align="left"><input type="text" size="30" class="formfield" maxlength="60" name="custom'.$i.'" value="'.$_POST['custom'.$i].'"></td>';
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
<tr>
	<td valign="top" class="row1" align="right"><b><?php  echo $_template['description']; ?>:</b></td>
	<td class="row1"><textarea id="description" cols="45" rows="4" class="formfield" name="form_description"></textarea></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>

<?php
	$sql = "SELECT * FROM course_custom_fields";
	$res = $db->query($sql);
	$i =1;
	while($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (($row['MANDATORY'] ==0) && ($row['NAME'] <>'')) {
			echo '<tr>';
			echo '<td class="row1" align="right"><b>'.$row['NAME'].' :</b></td>';
			echo '<td class="row1" align="left"><input class="formfield" name="custom'.$i.'" type="text" size="30" value="'.$_POST['custom'.$i].'" /></td>';
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
</table>
<br><br> 

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td class="row1" align="center" colspan="2"><input type="submit" name="submit" class="button" value=" <?php echo  $_template['create_course']; ?> Alt-s" accesskey="s" /></td>
</tr>
</table>
</form>

<?php
	require($_include_path.'cc_html/footer.inc.php'); 
?>