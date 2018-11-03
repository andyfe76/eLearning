<?php


if ($_SESSION['prefs'][PREF_ONLINE] == 1){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catd" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			if (!$_SESSION['prefs'][PREF_MINI_HELP]) {	
				echo '<img src="images/menu/tbl_bg.gif" width="18" height="18">';
			}
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

	$sql	= "SELECT U.*, M.status FROM users_online U INNER JOIN members M ON U.member_id=M.member_id WHERE U.course_id=$_SESSION[course_id] AND U.expiry>".time()." ORDER BY U.login";
	$result	= $db->query($sql);

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		do {
			if (($_SESSION['status']==STATUS_ADMIN) || ($_SESSION['status']==STATUS_TRAINER) || ($_SESSION['status']==STATUS_TRAINING_MANAGER)) { 
				echo '&#176; <a href="send_message.php?l='.$row['MEMBER_ID'].SEP.'g=1">'.$row['LOGIN'].'</a><br />';
			} else {
				if (($row['STATUS']==STATUS_ADMINISTRATOR) || ($row['STATUS']==STATUS_TRAINER) || ($row['STATUS']==STATUS_TRAINING_MANAGER)) {
					echo '&#176; <a href="send_message.php?l='.$row['MEMBER_ID'].SEP.'g=1">'.$row['LOGIN'];
					if (($_SESSION['status']!=STATUS_ADMIN) && ($_SESSION['status']!=STATUS_TRAINER) && ($_SESSION['status']!=STATUS_TRAINING_MANAGER)) { 
						echo '&nbsp;('.$_template['send_message'].')</a><br />';
					} else {
						echo '</a><br />';
					}
				} else {
					echo '&#176; '.$row['LOGIN'].'<br />';
				}
			}
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
	} else {
		echo '<small><em>'.$_template['none_found'].'.</em></small><br />';
	}

	//echo '<small><em>'.$_template['guests_not_listed'].'</em></small>';
	echo '</td></tr></table>';

} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
	echo '<tr><td class="catd" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			if (!$_SESSION['prefs'][PREF_MINI_HELP]) {	
				echo '<img src="images/menu/tbl_bg.gif" width="18" height="18">';
			}
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
