<?php


if ($_SESSION['prefs'][PREF_ONLINE] == 1){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catd" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_USERS_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'disable='.PREF_ONLINE.'">';
			echo $_template['close_users_online'];
			echo '</a></td>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr>';
	echo '<tr>';
	echo '<td class="mrow1" align="left">';

	$sql	= "SELECT * FROM users_online WHERE course_id=$_SESSION[course_id] AND expiry>".time()." ORDER BY login";
	$result	= mysql_query($sql, $db);

	if ($row = mysql_fetch_array($result)) {
		do {
			echo '&#176; <a href="send_message.php?l='.$row['member_id'].SEP.'g=1">'.$row['login'].'</a><br />';
		} while ($row = mysql_fetch_array($result));
	} else {
		echo '<small><em>'.$_template['none_found'].'.</em></small><br />';
	}

	echo '<small><em>'.$_template['guests_not_listed'].'</em></small>';
	echo '</td></tr></table>';

} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catd" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_USERS_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'enable='.PREF_ONLINE.'">';
			echo $_template['open_users_online'];
			echo '</a>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr></table>';
}

?>