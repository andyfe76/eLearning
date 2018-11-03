<?php

$month_names = $month_name_con['en'];

		echo '<select name="day'.$name.'">';
		for ($i = 1; $i <= 31; $i++) {
			echo '<option value="'.$i.'"';
			if ($i == $today_day) {
				echo ' selected="selected"';
			}
			echo '>';
			echo $i.'</option>';
		}
		echo '</select>';

		echo '<select name="month'.$name.'">';
		for ($i = 1; $i <= 12; $i++) {
			echo '<option value="'.$i.'"';
			if ($i == $today_mon) {
				echo ' selected="selected"';
			}
			echo '>';
			echo $month_names[$i-1].'</option>';
		}
		echo '</select>';

		echo '<select name="year'.$name.'">';
		for ($i = $today_year-1; $i <= $today_year+1; $i++) {
			echo '<option value="'.$i.'"';
			if ($i == $today_year) {
				echo ' selected="selected"';
			}
			echo '>';
			echo $i.'</option>';
		}
		echo '</select>';

		echo $_template['at'].'  <select name="hour'.$name.'">';
		for ($i = 0; $i <= 23; $i++) {
			echo '<option value="'.$i.'"';
			if ($i == $today_hour) {
				echo ' selected="selected"';
			}
			echo '>';
			echo $i.'</option>';
		}
		echo '</select>:';
	
		echo '<select name="min'.$name.'">';
		for ($i = 0; $i <= 59; $i+=5) {
			echo '<option value="'.$i.'"';
			if ($i == $today_min) {
				echo ' selected="selected"';
			}
			echo '>';
			echo $i.'</option>';
		}
		echo '</select><small class="spacer">'.$_template['hours_24'].'</small>';
?>
