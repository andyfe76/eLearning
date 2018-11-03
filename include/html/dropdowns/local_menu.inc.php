<?php
if ($_SESSION['prefs'][PREF_LOCAL] == 1){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catb" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_LOCAL_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'disable='.PREF_LOCAL.'">';
			echo $_template['close_local_menu'];
			echo '</a></td>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
	echo '</tr></table>';
	echo '</td></tr>';

	if ($_SESSION['s_cid']){
		/* @see: ./include/html/breadcrumbs.inc.php (for $path) */
		if (($_GET['cid'] == '') || ($_GET['cid'] == 0) ) {
			$path = $contentManager->getContentPath($_SESSION['s_cid']);
		}
		$location =	$contentManager->getLocationPositions(0, $path[0]['content_id']);
		$temp_path = $path;
		$garbage = next($temp_path);
		$temp_menu = $contentManager->getContent();
		
		/* previous topic: */
		echo '<tr><td valign="top" class="mrow1" align="left">';
		if ($temp_menu[0][$location-1] != '') {
			echo '<a href="./?cid='.$temp_menu[0][$location-1][content_id].SEP.'g=22" class="breadcrumbs"><small><b>'.$_template['previous_topic'].':</b> ';
			
			if ($_SESSION['prefs'][PREF_NUMBERING]) {
				echo ($location);
				echo ' ';
			}

			echo $temp_menu[0][$location-1][title].'</small></a>';
		} else {
			echo '<small class="spacer"><b>'.$_template['previous_topic'].'</b> '.$_template['none'].'</small>';
		}
		echo '</td></tr>';
		//echo '<tr><td class="mrow2" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
		
		echo '<tr>';
		echo '<td align="left" nowrap="nowrap" class="mrow2">';
		
		echo '&nbsp;<a class="breadcrumbs" href="./?g=26">'.$_template['home'].'</a><br />';
		echo '<img src="images/tree/tree_end.gif" alt="collapse" border="0" />';

		
		if ($_SESSION['prefs'][PREF_NUMBERING]) {
			echo ($location+1);
		}

		if (strlen($path[0]['title']) > 26 ) {
			$path[0]['title'] = substr($path[0]['title'], 0, 26-4).'...';
		}

		echo ' <a class="breadcrumbs" href="./?cid='.$path[0]['content_id'].SEP.'g=2"><b>'.$path[0]['title'].'</b></a>';
		echo '<br />';

		/* @see: ./include/lib/content_functions.inc.php */
		print_menu_collapse($path[0]['content_id'], $temp_menu, 1, ($location+1).'.', array(), 2);

		echo '</td></tr>';

		/* next topic: */
		//echo '<tr><td class="mrow2" height="1"><img src="images/clr.gif" alt="" height="1" width="1" /></td></tr>';
		echo '<tr><td valign="top" class="mrow1" align="left">';
		if ($temp_menu[0][$location+1] != '') {
			echo '<a class="breadcrumbs" href="./?cid='.$temp_menu[0][$location+1][content_id].SEP.'g=22"><small><b>'.$_template['next_topic'].':</b> ';
			
			if ($_SESSION['prefs'][PREF_NUMBERING]) {
				echo ($location+2);
				echo ' ';
			}
			echo $temp_menu[0][$location+1][title];
			echo '</small></a>';
		} else {
			echo '<small class="spacer"><b>'.$_template['next_topic'].'</b> '.$_template['none'].'</small>';
		}
		echo '</td></tr>';
	} else {
		echo '<tr>';
		echo '<td class="mrow1" align="left">';

		echo '<small><i>'.$_template['select_topic_first'].'</i></small>';
		echo '</td></tr>';
	}

	echo '</table>';
} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catb" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_LOCAL_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'enable='.PREF_LOCAL.'">';
			echo $_template['open_local_menu'].'';
			echo '</a>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr></table>';
}

?>
