<?php
?>
    <form id="jump" method="post" action="bounce.php" target="_top"><?php

		$sql	= "SELECT login, email, status FROM members WHERE member_id=$_SESSION[member_id]";
		$result = mysql_query($sql, $db);
		$row	= mysql_fetch_array($result);
		$status	= $row['status'];
		$email  = $row['email'];
		$login  = $row['login'];

		$pipe = "\n".' <span class="spacer">|</span> '."\n";
		echo '<br>';
		echo '<small class="loginwhite">';
		echo $_template['login'].': ';

		if ($_SESSION['valid_user']) {
			//echo '<b>'.$_SESSION['login'].'</b> ';
			echo '<a class="white" href="users/edit.php" title="'.$_template['edit_profile'].'" target="_top"><b>'.$_SESSION['login'].'</b></a>';
			echo $pipe;
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
				echo '<a class="white" href="logout.php?g=19" title="'.$_template['logout'].'" target="_top"><img src="images/logout.gif" border="0" height="14" width="15" alt="'.$_template['logout'].'" class="menuimage" /></a>';
			}
			/*if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
				echo ' <a class="white" href="logout.php?g=19" target="_top">'.$_template['logout'].'</a>';
			}*/
		} else {
			echo ' <b>'.$_template['guest'].'</b>. ';
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
				echo '<a class="white" href="login.php?course='.$_SESSION[course_id].'" title="'.$_template['login'].'"><img src="images/login.gif" border="0" height="15" width="16" alt="'.$_template['login'].'" class="menuimage" /></a>'."\n";
			}
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
				echo ' <a class="white" href="login.php?course='.$_SESSION[course_id].'">'.$_template['login'].'</a>';
			}
		}
		echo '<br>';
		echo '<span style="font-size:8pt;"><b>'.$_template['status'].': </b>';
		if ($status == 0) {
			echo $_template['student'];
		} else if ($status ==1) {
			echo $_template['instructor'];
		} else if ($status ==2) {
			echo $_template['administrator'];
		}
			
		echo '<br><br><b><a href="users/">'.$_template['home'].'</a></b><br />';		
		if ($status <2){
			//echo '<a href="users/browse.php">'.$_template['browse_courses'].'</a><br />';
		}
		
		if ($status >= 1){
			/* MANAGEMENT */
			echo '<br>';
			echo '<b><a class="white" href="users/usermng.php">'.$_template['user_management'].'</a></b><br>';
			echo '<b><a class="white" href="users/coursemng.php">'.$_template['course_management'].'</a></b>';
		
			/* REPORTS: */
			echo '<br><br>';
			echo '<b>'.$_template['reports'].'<br></b>';		
			echo ' <a class="white" href="users/member_rep.php">'.$_template['member_reports'].'</a><br>';			
			//echo ' <a class="white" href="users/course_rep.php">'.$_template['course_reports'].'</a><br>';
		}
		echo '</span>';
		echo '<br>';
		echo '<br>';
		
/*		if ($_SESSION['valid_user']) {
			$sql	= "SELECT E.course_id FROM course_enrollment E WHERE E.member_id=$_SESSION[member_id] AND E.approved='y'";
			$result = mysql_query($sql,$db);
		
			echo "\n".'&nbsp;<label for="j" accesskey="j"></label><span style="white-space: nowrap;"><select name="course"'.$tip_jump.' class="dropdown" id="j" title="Jump: '.$_template['accesskey'].' ALT-j" onChange="document.jump.submit()">'."\n";
			echo '<option value="0">'.$_template['my_control_centre'].'</option>'."\n";
			echo '<option value="">-- '.$_template['courses_below'].' --</option>'."\n";
			while ($row = mysql_fetch_array($result)) {
				echo '<option value="'.$row['course_id'].'"';
				if ($_SESSION['course_id'] == $row['course_id']) {
					echo ' selected="selected"';
				}
				echo '>'.$system_courses[$row['course_id']]['title'];
				echo $row['title'];
				echo '</option>'."\n";
			}
			echo '</select>&nbsp;'."\n";
			echo '<input type="submit" name="jump" value="'.$_template['go'].'" class="button2" /></span>&nbsp;';
			echo '<input type="hidden" name="g" value="22" />';
			echo '<br>';
		} else {
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
				echo '<a class="white" href="browse.php" title="'.$_template['browse_courses'].'"><img src="images/browse.gif" border="0" alt="'.$_template['browse_courses'].'" height="14" width="16" /></a>';
			}
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
				echo ' <a class="white" href="browse.php">'.$_template['browse_courses'].'</a>';
			}
			echo '<br>';			
		}

		if ($_SESSION['valid_user']) {
			//echo $pipe;
			$sql	= "SELECT COUNT(*) AS cnt FROM messages WHERE to_member_id=$_SESSION[member_id] AND new=1";
			$result	= mysql_query($sql, $db);
			$row	= mysql_fetch_array($result);

			if ($_SESSION['course_id'] == 0) {
				$temp_path = 'users/';
			}

			if ($row['cnt'] > 0) {
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
					echo '<a class="white" href="'.$temp_path.'inbox.php?g=21" title="'.$_template['you_have_messages'].'"><img src="images/inbox2.gif" border="0" class="menuimage" width="14" height="10" alt="'.$_template['you_have_messages'].'" /></a>';
				}
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
					echo ' <a class="white" href="'.$temp_path.'inbox.php?g=21" title="'.$_template['you_have_messages'].'"><b> '.$_template['inbox'].' </b></a>';
					echo '<span style="font-size:8pt;">&nbsp; ('.$row['cnt'].'&nbsp;unread)</span>';
				}
			} else {
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
					echo '<a class="white" href="'.$temp_path.'inbox.php?g=21" title="'.$_template['inbox'].'"><img src="images/inbox.gif" border="0" width="14" height="10" class="menuimage" alt="'.$_template['inbox'].'" /></a>';
				}
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
					echo ' <a class="white" href="'.$temp_path.'inbox.php?g=21">'.$_template['inbox'].'</a>';
				}
			}
			echo '<br>';
		}
*/		
		if ($_SESSION['course_id'] != 0) {
			//echo $pipe;
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
				echo '<a class="white" href="tools/sitemap/?g=23" title="'.$_template['sitemap'].'"><img src="images/toc.gif" width="16" height="16" alt="'.$_template['sitemap'].'" border="0" class="menuimage" /></a>';
			}
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
				echo ' <a class="white" href="tools/sitemap/?g=23">'.$_template['sitemap'].'</a> ';	
			}
			echo '<br>';
		}


		if ($_SESSION['course_id'] != 0) {
			//echo $pipe;
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
				echo '<a class="white" href="tools/preferences.php?g=20" title="'.$_template['preferences'].'"><img src="images/prefs.gif" width="16" height="14" alt="'.$_template['preferences'].'" border="0" class="menuimage" /></a>';
			}
			if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
				echo ' <a class="white" href="tools/preferences.php?g=20">'.$_template['preferences'].'</a> ';
			}
			echo '<br>';
		}

		if ($_SESSION['is_admin'] == true) {
			//echo $pipe;
			if ($_SESSION['prefs']['PREF_EDIT'] == 0) {
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
					echo '<a class="white" href="'.$_my_uri.'enable='.PREF_EDIT.'" title="'.$_template['enable_editor'].'"><img src="images/pen.gif" border="0" class="menuimage" alt="'.$_template['enable_editor'].'" height="14" width="16" /></a>';
				}
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
					echo ' <a class="white" href="'.$_my_uri.'enable='.PREF_EDIT.'">'.$_template['enable_editor'].'</a>';
				}
			} else {
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
					echo '<a class="white" href="'.$_my_uri.'disable='.PREF_EDIT.'" title="'.$_template['disable_editor'].'"><img src="images/pen2.gif" border="0" class="menuimage" alt="'.$_template['disable_editor'].'" height="14" width="16" /></a>';
				}
				if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
					echo ' <a class="white" href="'.$_my_uri.'disable='.PREF_EDIT.'">'.$_template['disable_editor'].'</a>';
				}
			}
			echo '<br>';	
		}
 
	?></small></form>
