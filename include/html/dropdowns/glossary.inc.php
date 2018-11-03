<?php

if ($_SESSION['prefs'][PREF_GLOSSARY] == 1){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catf" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_GLOSSARY_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'disable='.PREF_GLOSSARY.'">';
			echo $_template['close_glossary_terms'];
			echo '</a><td>';
			?>
		<td width="8" align="right">
			<img src="images/menu/tbl_end.gif" border="0"></td>
		</tr></table>
	<?php
	
	echo '</td></tr>';
	echo '<tr>';
	echo '<td class="mrow1" align="left">';

	$result =& $contentManager->getContentPage($_GET['cid']);

	if ($result && ($row = mysql_fetch_array($result))) {
		$num_terms = preg_match_all ("/(\[\?\])([\s\w\d])*(\[\/\?\])/i", $row['text'], $matches, PREG_PATTERN_ORDER);

		$matches = $matches[0];
		$word = str_replace(array('[?]', '[/?]'), '', $matches);
		$word = str_replace("\n", ' ', $word);
		$word = array_unique($word);

		if (count($word) > 0) {
			$count = 0;
			foreach ($word as $k => $v) {
				if ($glossary[$v] != '') {

					if (strlen($v) > 26 ) {
						$v_formatted = substr($v, 0, 26-4).'...';
					}else{
						$v_formatted = $v;
					}

					$count++;
					echo '&#176; <a href="glossary/?L='.strtoupper(substr($v,0,1)).SEP.'g=25#'.urlencode($v).'" title="'.$v.'">'.$v_formatted.'</a>';
					echo '<br />';
				}
			}
			if ($count == 0) {
				/* there are defn's, but they're not defined in the glossary */
				echo '<small><i>'.$_template['none_found'].'</i></small>';
			}
		} else {
			/* there are no glossary terms on this page */
			echo '<small><i>'.$_template['none_found'].'</i></small>';
		}
	} else {
		/* there are no glossary terms in the system for this course or error */
		echo '<small><i>'.$_template['none_found'].'</i></small>';
	}

	echo '</td></tr></table>';

} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catf" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_GLOSSARY_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'enable='.PREF_GLOSSARY.'">';
			echo $_template['open_glossary_terms'].'';
			echo '</a>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr></table>';
}

?>
