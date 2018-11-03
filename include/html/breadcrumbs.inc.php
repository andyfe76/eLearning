<?php



	$delim = ' » ';

	//echo '&nbsp;';

	if ($cid != 0) {
		echo '<a href="./?g=10" class="breadcrumbs">'.$_template['home'].'</a>';
		echo $delim;
		/* find the path to this cid */

		foreach ($path as $x => $content_info) {
			if ($content_info['content_id'] == $cid) {
				echo '<b>'.$content_info['title'].'</b>';
			} else {
				echo '<a href="./?cid='.$content_info['content_id'].SEP.'g=10" class="breadcrumbs">'.$content_info['title'].'</a>';
				echo $delim;
			}
		}
	} else if (is_array($_section)) {
		echo '<a href="./?g=10" class="breadcrumbs">'.$_template['home'].'</a>';

		$num_sections = count($_section);
		for($i = 0; $i < $num_sections-1; $i++) {
			echo $delim;
			echo '<a href="'.$_section[$i][1];
			
			if (strpos($_section[$i][1], '?') === false) {
				echo '?';
			} else {
				echo SEP;
			}

			echo 'g=10" class="breadcrumbs">';
			echo $_section[$i][0];
			echo '</a>';
		}

		echo $delim;
		echo '<span style="font-size: 8pt;"><b>'.$_section[$num_sections-1][0].'</b></span>';
	} else {
		echo '<span style="font-size: 8pt;"><b>'.$_template['home'].'</b></span>';
	}

?>
