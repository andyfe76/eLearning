<?php

	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	require($_include_path.'cc_html/header.inc.php');

	$course = intval($_GET['course']);

	/*$sql	= "SELECT * FROM courses WHERE member_id=$_SESSION[member_id] AND course_id=$course";
	$result = $db->query($sql);
	if (!($row =$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$errors[] = AT_ERROR_NOT_OWNER;
		print_errors($errors);
		require ($_include_path.'cc_html/footer.inc.php');
		exit;
	}*/

	$month_names = $month_name_ext['en'];
	$year  = intval($_GET['year']);
	$month = intval($_GET['month']);

	if ($month == 0) {
		$month = date('m');
		$year  = date('Y');
	}

	$days	= array();
	$sql	= "SELECT * FROM course_stats WHERE course_id=$course AND TO_CHAR(login_date, 'MM')=$month AND TO_CHAR(login_date, 'YYYY')=$year ORDER BY login_date ASC";
	$result = $db->query($sql);
	$today  = 1; /* we start on the 1st of the month */
	$max_total_logins = 0;
	$min_total_logins = (int) 99999999;
	$total_logins = 0;

	$empty = true;
	
	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$empty = false;
		$row_day = substr($row['LOGIN_DATE'], 8, 2);

		if (substr($row_day, 0,1) == '0') {
			$row_day = substr($row_day, 1, 1);
		}
		
		while ($today < $row_day-1) {
			$today++;
			$days[$today] = array(0, 0);
			$min_total_logins = 0;
		}

		$today = $row_day; /* skip this day in the fill-in-the-blanks-loop */
				
		$days[$row_day] = array($row['GUESTS'], $row['MEMBERS']);

		if ($max_total_logins < $row['GUESTS']+$row['MEMBERS']) {
			$max_total_logins = $row['GUESTS']+$row['MEMBERS'];
		}

		if ($min_total_logins > $row['GUESTS']+$row['MEMBERS']) {
			$min_total_logins = $row['GUESTS']+$row['MEMBERS'];
		}

		$total_logins += $row['GUESTS']+$row['MEMBERS'];
	}

	/* add zeros to the end of the month, only if it isn't the current month */
	$now_month = date('m');
	$now_year  = date('Y');
	if ( (($month < $now_month) && ($now_year == $year)) || ($now_year < $year) ) {
		$today++;
		while (checkdate($month, $today,$year)) {
			$days[$today] = array(0, 0);
			$today++;
		}
	}
	$num_days = count($days);

	if ($total_logins > 0) {
		$avg_total_logins = $total_logins/$num_days;
	} else {
		$avg_total_logins = 0;
	}

	$block_height		= 10;
	$multiplyer_height  = 5; /* should be multiples of 5 */

	if ($month == 12) {
		$next_month = 1;
		$next_year  = $year + 1;
	} else {
		$next_month = $month + 1;
		$next_year  = $year;
	}

	if ($month == 1) {
		$last_month = 12;
		$last_year  = $year - 1;
	} else {
		$last_month = $month - 1;
		$last_year  = $year;
	}

?>
	<table cellspacing="1" cellpadding="1" border="0" class="bodyline" summary="">
	<tr>
		<th colspan="2"><small class="bigspacer"><?php
			echo '<a href="users/course_stats.php?course='.$course.SEP.'month='.$last_month.SEP.'year='.$last_year.'">';
			echo ' '.$month_names[$last_month-1]; ?></a> |</small>
		<?php echo $month_names[$month-1]; ?>
<?php echo $_template['statistics']; ?> <small class="bigspacer">| <?php
			echo '<a href="users/course_stats.php?course='.$course.SEP.'month='.$next_month.SEP.'year='.$next_year.'">';
			echo $month_names[$next_month-1]; ?> </a></small></th>
	</tr>
<?php
		if (($num_days == 0) || ($empty)) {
			echo '<tr>';
			echo '<td class="row1" colspan="2">'.$_template['no_month_data'].'</td>';
			echo '</tr>';
			echo '</table>';
			exit;
		}
?>
	<tr>
		<td class="row1" valign="top" align="right"><b><?php echo $_template['total']; ?>:</b></td>
		<td class="row1"><?php echo $total_logins; ?></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" valign="top" align="right"><b><?php echo $_template['maximum']; ?>:</b></td>
		<td class="row1"><?php echo $max_total_logins; ?></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>

	<tr>
		<td class="row1" valign="top" align="right"><b><?php echo $_template['minimum']; ?>:</b></td>
		<td class="row1"><?php
		if ($min_total_logins < 99999999) {
			echo $min_total_logins; 
		} else {
			echo '0';
		} ?></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>

	<tr>
		<td class="row1" valign="top" align="right"><b><?php   echo $_template['average']; ?>:</b></td>
		<td class="row1"><?php echo number_format($avg_total_logins, 1); ?>
<?php   echo $_template['per_day']; ?></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>

	<tr>
		<td class="row1" valign="top" align="right"><b><?php   echo $_template['graph']; ?>:</b></td>
		<td class="row1">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" class="graph1"><small><?php echo $max_total_logins; ?></small></td>

<?php
			foreach ($days as $day => $logins) {
				echo '<td valign="bottom" class="graph"><img src="images/clr.gif" height="'.(($max_total_logins*$multiplyer_height) % $block_height + $block_height).'" width="10" alt="" /><br /><img src="images/blue.gif" height="'.($logins[0]*$multiplyer_height).'" width="9" alt="'.$logins[0].' '.$_template['guests'].' ('.($logins[0]+$logins[1]).' '.$_template['total'].')" /><br /><img src="images/red.gif" height="'.($logins[1]*$multiplyer_height).'" width="9" alt="'.$logins[1].' '.$_template['members'].' ('.($logins[1]+$logins[0]).' '.$_template['total'].')" /></td>';
			} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
?>

			</tr>
			<tr>
				<td valign="top"><small>0</small></td>
			</tr>
			</table>

			<small><?php  echo $_template['legend']; ?>: <img src="images/red.gif" height="10" width="10" alt="<?php echo $_template['red_members']; ?>" /> <?php   echo $_template['members']; ?>,
				<img src="images/blue.gif" height="10" width="10" alt="<?php echo $_template['blue_guests']; ?>" /> <?php echo $_template['guests']; ?>.</small>
		</td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>

	<tr>
		<td class="row1" valign="top" align="right"><b><?php   echo $_template['raw_data']; ?>:</b></td>
		<td class="row1" align="center">
	
		<table cellspacing="1" cellpadding="1" border="0" class="bodyline" summary="">
		<tr>
			<th scope="col"><small><?php echo $_template['date']; ?></small></th>
			<th scope="col"><small><?php echo $_template['guests']; ?></small></th>
			<th scope="col"><small><?php echo $_template['members']; ?></small></th>
		</tr>
<?php
		$short_name = $month_name_con['en'][$month-1];
		foreach ($days as $day => $logins) {
			$counter++;
			echo '<tr>';
			echo '<td class="row1"><small>'.$short_name.' '.$day.'</small></td>';
			echo '<td class="row1" align="right"><small>'.$logins[0].'</small></td>';
			echo '<td class="row1" align="right"><small>'.$logins[1].'</small></td>';
			echo '</tr>';
			
			if ($counter < $num_days) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
		}
?>
			</table>

		</td>
	</tr>
	</table>
<?php
	require ($_include_path.'cc_html/footer.inc.php');
?>
