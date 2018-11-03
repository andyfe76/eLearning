<?php

	/* next and previous link:	*/
	if ($_SESSION['prefs'][PREF_SEQ] != TOP) {
		echo '<br><br>';
		echo '<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="95%" align="center">';
		echo '<tr>';
		//echo '<div align="right" id="seqtop">';
		echo $next_prev_links;
		//echo '</div>';
		echo '</tr></table>';
	}
?>
<br>
</td></tr></table>

<div align="right" id="top"><small><br />
<?php
	if (is_array($help)) {
		// Disabled until separation of help per page id.
		// echo '<a href="help/about_help.php"><em>'.$_template['help_available'].'</em>.</a> ';
	}
	
	echo '<table border="0" align="right"><tr>';
	if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
		echo '<td><a href="' . $_my_uri . 'g=6#content" title="' . $_template['back_to_top'] . ' ALT-c">' . $_template['top'] . '</a></td>';
	}
	if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
		echo '<td><a href="'.$_my_uri.'g=6#content" title="'.$_template['back_to_top'].' ALT-c"><img src="images/top.gif" alt="'.$_template['back_to_top'].'" border="0" class="menuimage" /></a></td>';
	}
	echo '</tr></table>';
	
	echo '&nbsp;&nbsp;</small></div>';
?>
</td>
	<?php
	if (($_SESSION['prefs'][PREF_MAIN_MENU] == 1) && ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] != MENU_LEFT)) {
		/* the right menu is open: */
		echo '<td width="25%" valign="top" rowspan="2" style="padding-top: 1px;" id="menuR">';

		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="" id="contentR">';
		echo '<tr><td class="cata" valign="top">';
		
			echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
				print_popup_help(AT_HELP_MAIN_MENU);
			echo '</td><td background="images/menu/tbl_bg.gif">';
				echo '<a name="menu"></a><a href="'.$_my_uri.'disable='.PREF_MAIN_MENU.'" accesskey="6" class="white" title="'.$_template['close_menus'].' ALT-6">' . $_template['close_menus'] . '</a>';
			echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
			echo '</tr></table>';
			
		echo '</td></tr></table>';

		if (isset($_SESSION['prefs'][PREF_STACK])) {
			foreach ($_SESSION['prefs'][PREF_STACK] as $stack_id) {
				echo '<img src="images/clr.gif" height="1" width="1" alt="" />';
				require($_include_path.'html/dropdowns/'.$_stacks[$stack_id].'.inc.php');
			}
		}
		echo '</td>';
	}
	?>
</tr>
</table>
<?php

$sql_foot="select footer from courses where course_id='$_SESSION[course_id]'";
if($result = mysql_query($sql_foot, $db)) {
	while($row=mysql_fetch_row($result)) {
		if(strlen($row[0])>0) {
			$custom_foot= $row[0];
			$custom_foot = str_replace("CONTENT_DIR", "content/".$_SESSION['course_id'], $custom_foot);
		}
	}
}

if(strlen($custom_foot) > 0){
	echo $custom_foot;
}

require($_include_path.'html/copyright.inc.php');?>
</td></tr></table>
</td><td><img src="images/spacer.gif" border="0" width="10" height="1"></td></tr>
</table>

</body>
</html>