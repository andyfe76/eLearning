<?php

if ($_SESSION['prefs'][PREF_RELATED] == 1){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catc" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_RELATED_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'disable='.PREF_RELATED.'">';
			echo $_template['close_related_topics'];
			echo '</a></td>';	
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr>';
	echo '<tr>';
	echo '<td class="mrow1" align="left">';

	$related = $contentManager->getRelatedContent($_SESSION['s_cid']);
	if (count($related) == 0) {
		echo '<small><i>'.$_template['none_found'].'</i></small>';
	} else {

		for ($i=0; $i < count($related); $i++) {
			echo '&#176; <a href="./?cid='.$related[$i].SEP.'g=4">';
			echo $contentManager->_menu_info[$related[$i]][title];
			echo '</a>';
			echo '<br />';
		}
	}
	
	echo '</td></tr></table>';

} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catc" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_RELATED_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'enable='.PREF_RELATED.'">';
			echo $_template['open_related_topics'];
			echo '</a>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr></table>';
} 
?>
