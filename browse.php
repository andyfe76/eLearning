<?php
$section = 'users';
$page	 = 'browse'; 
$_include_path = 'include/';
require($_include_path.'vitals.inc.php');

require($_include_path.'basic_html/header.php');

?>
<h2><?php //echo $_template['browse_courses']; ?></h2>
<p><?php //echo $_template['about_browse']; ?></p>

	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" align="center" summary="">
	<tr>
		<th scope="col"><?php echo $_template['course_name']; ?></th>
		<th scope="col"><?php echo $_template['description']; ?></th>
	</tr>
<?php
	$sql	= "SELECT * FROM courses WHERE hide=0 ORDER BY title";
	$result = mysql_query($sql,$db);

	$num = mysql_num_rows($result);
	if ($row = mysql_fetch_array($result)) {
		do {
			echo '<tr><td class="row1" width="150" valign="top"><b>';
			echo '<a href="bounce.php?course='.$row[course_id].'">'.$system_courses[$row[course_id]][title].'</a>';

			echo '</b></td><td class="row1" valign="top">';
			echo '<small>';
			echo $row[description];

			echo '<br /><br />&middot; '.$_template['access'].': ';
			$pending = '';
			switch ($row['access']){
				case 'public':
					echo $_template['public'];
					break;
				case 'protected':
					echo $_template['protected'];
					break;
				case 'private':
					echo $_template['private'];
					break;
			}
			$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$row[course_id] AND approved='y'";
			$c_result = mysql_query($sql, $db);
			$c_row	  = mysql_fetch_array($c_result);

			/* minus 1 because the instructor doesn't count */
			echo '<br />&middot; '.$_template['enrolled'].': '.max(($c_row[0]-1), 0).'<br />';
			echo '&middot; '.$_template['created_date'].': '.$row[created_date].'<br />';

			echo '</small></td>';
			echo '</tr>';
			if ($count < $num-1) {
				echo '<tr><td height="1" class="row2" colspan="3"></td></tr>';
			}
			$count++;
		} while ($row = mysql_fetch_array($result));
	} else {
		echo '<tr><td class=row1 colspan=3><i>'.$_template['no_courses'].'</i></td></tr>';
	}
	echo '</table>';

	require($_include_path.'basic_html/footer.php');
?>
