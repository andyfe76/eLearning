<?php
?>
<script language="JavaScript">
	function change_course(){
		document.all.jump_course.submit();
	}
	function change_language() {
		document.all.jump_course.submit();
	}

</script>

<form method="post" name="jump_course" id="jump_course" action="bounce.php" target="_top">

<tr>
	<td colspan="2" bgcolor="#F0F0F5">
		<img src="images/spacer.gif" width="700" height="1">
	</td>
</tr>

<tr>
	<td valign="top"">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td bgcolor="F0F0F2">
				<img src="images/menu/logo_connex.gif" border="0">
				<img src="images/spacer.gif" width="53" height="1"></td>
		</tr><tr>
			<td background="images/menu/left_artifact.gif" valign="top">
				<table cellpadding="2" cellspacing="0" border="0">
				<tr><td>
					<?php
						echo '<span style="font-family: Verdana, Arial; font-size: 10pt; color: #C0D7CF; margin-top: 0px;">';
						if ($_SESSION['valid_user'] === true) {
							echo '&nbsp;<a class="invert" href="users/edit.php" title="'.$_template['edit_profile'].'" target="_top"><b>'.$_SESSION['login'].'</b></a></span> ';
						} else {
							echo ' <b>'.$_template['guest'].'</b>. </span>';
						}
					?>
				</td></tr></table>
				</td>
		</tr><tr>
			<td>
				<?php /*echo '<span class="nblack">Status:';
				if ($status == 0) {
					echo $_template['student'];
				} else if ($status == 1) {
					echo $_template['instructor'];
				} else {
					echo $_template['administrator'];
				} */
				echo '&nbsp;</span></td>'; ?>
				
		</tr>
		</table>
		
	</td><td valign="top" width="100%">
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="right">
		<tr>
			<td bgcolor="f0f0f2" align="right" valign="top" width="100%">
				<img src="images/spacer.gif" width="1" height="42">
				<a href="users/"><img src="images/menu/home.gif" border="0"></a>
				<?php
					if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
						echo '<img src="images/menu/menu_sep.gif" border="0">';
						echo '<a href="users/coursemng.php"><img src="images/menu/course_management.gif" border="0"></a>';
						echo '<img src="images/menu/menu_sep.gif" border="0">';
						echo '<a href="users/usermng.php"><img src="images/menu/user_management.gif" border="0"></a>';
						echo '<img src="images/menu/menu_sep.gif" border="0">';
						echo '<a href="reports/index.php"><img src="images/reports.gif" border="0"></a>';
					}
			
		
			//echo '</td><td bgcolor="F0F0F2" valign="middle">';
			
				
					if ($_SESSION['valid_user']) {
						/* show the list of courses with jump linke */
						$sql	= "SELECT E.course_id FROM course_enrollment E WHERE E.member_id=$_SESSION[member_id] AND E.approved='y'";
						$result = mysql_query($sql,$db);
					
						echo "\n".'&nbsp;<label for="j" accesskey="j"></label><span style="white-space: nowrap;">';
						//echo $_template['jump'].': ';
						echo '<select name="course"'.$tip_jump.' class="dropdown" id="j" title="Jump: '.$_template['accesskey'].' ALT-j" onChange="change_course();">'."\n";
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
						//echo '<input type="submit" name="jump" value="'.$_template['jump'].'" class="button2" />';
						echo '</span>&nbsp;';
						echo '<input type="hidden" name="g" value="22" />';
			
					} else {
						/* this user is a guest */
						//echo $pipe;
						if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
							//echo '<a class="white" href="browse.php" title="'.$_template['browse_courses'].'"><img src="images/browse.gif" border="0" alt="'.$_template['browse_courses'].'" height="14" width="16" /></a>';
						}
						if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
							//echo ' <a class="white" href="browse.php">'.$_template['browse_courses'].'</a>';
						}
					}
					
					echo "\n".'&nbsp;<label for="l" accesskey="l"></label><span style="white-space: nowrap;">';
					//echo $_template['language'].': ';
					//echo '<img src="images/menu/menu_sep.gif" border="0"> &nbsp;';
					
					echo '<select name="lang" class="dropdown" onChange="change_language();">';
					echo '<option value="en"';
					if ($_SESSION['lang'] == 'en') {
						echo ' selected="selected"';
					}
					echo '>English</option>'."\n";
					echo '<option value="ro"';
					if ($_SESSION['lang'] == 'ro') {
						echo ' selected="selected"';
					}
					echo '>Romana</option>'."\n";
					echo '</select>';
					echo '</span>&nbsp;';
					
					echo '&nbsp;</td>';
				?>
			</td>
		</tr>
		
		<tr>
			<td background="images/menu/menu_line.gif" colspan="2">
				<img src="images/spacer.gif" border="0" width="1" height="7"></td>
		</tr>
		
		<tr>
			<td align="right" valign="top"  colspan="2">
				<?php
				/*if ($_SESSION['prefs']['PREF_EDIT'] == 0) {
						echo '<a href="'.$_my_uri.'enable='.PREF_EDIT.'" title="'.$_template['enable_editor'].'"><img src="images/menu/enable_editor.gif" border="0" alt="'.$_template['enable_editor'].'"/></a>';
				} else {
						echo '<a href="'.$_my_uri.'disable='.PREF_EDIT.'" title="'.$_template['disable_editor'].'"><img src="images/menu/disable_editor.gif" border="0" alt="'.$_template['disable_editor'].'" /></a>';
				}*/
				
				if ($_SESSION['is_admin'] == true) {
					if ($_SESSION['prefs']['PREF_EDIT'] == 0) {
						//echo '<a class="white" href="'.$_my_uri.'enable='.PREF_EDIT.'" title="'.$_template['enable_editor'].'"><img src="images/pen.gif" border="0" class="menuimage" alt="'.$_template['enable_editor'].'" height="14" width="16" /></a>';
					} else {
						//echo '<a class="white" href="'.$_my_uri.'disable='.PREF_EDIT.'" title="'.$_template['disable_editor'].'"><img src="images/pen2.gif" border="0" class="menuimage" alt="'.$_template['disable_editor'].'" height="14" width="16" /></a>';
					}
				}
				
				echo '<img src="images/menu/menu_sepw.gif" border="0">';
				
				if ($_SESSION['valid_user']) {
					$sql	= "SELECT COUNT(*) AS cnt FROM messages WHERE to_member_id=$_SESSION[member_id] AND new=1";
					$result	= mysql_query($sql, $db);
					$row	= mysql_fetch_array($result);
		
					if ($_SESSION['course_id'] == 0) {
						$temp_path = 'users/';
					}
		
					if ($row['cnt'] > 0) {
							echo '<a href="'.$temp_path.'inbox.php?g=21" title="'.$_template['you_have_messages'].'"><img src="images/menu/inbox.gif" border="0" alt="'.$_template['you_have_messages'].'" /></a>';
					} else {
							echo '<a href="'.$temp_path.'inbox.php?g=21" title="'.$_template['inbox'].'"><img src="images/menu/inbox.gif" border="0" alt="'.$_template['inbox'].'" /></a>';
					}
				}
				?>
				
				<?php
					if ($_SESSION['course_id'] >0) {
						echo '<img src="images/menu/menu_sepw.gif" border="0">';
						echo '<a href="tools/preferences.php?g=20" title="'.$_template['preferences'].'"><img src="images/menu/preferences.gif" alt="'.$_template['preferences'].'" border="0"" /></a>';
						echo '<img src="images/menu/menu_sepw.gif" border="0">';
						echo '<a href="tools/sitemap/?g=23" title="'.$_template['sitemap'].'"><img src="images/menu/site_map.gif" alt="'.$_template['sitemap'].'" border="0"/></a>';
					}
				?>
				<img src="images/menu/menu_sepw.gif" border="0">
				<?php
				if ($_SESSION['valid_user'] === true) {
					echo '<a href="logout.php?g=19" title="'.$_template['logout'].'" target="_top"><img src="images/menu/logout.gif" border="0" alt="'.$_template['logout'].'" /></a>';
				} else {
					echo ' <b>'.$_template['guest'].'</b>. ';
					echo '<a class="white" href="login.php?course='.$_SESSION[course_id].'" title="'.$_template['login'].'"><img src="images/login.gif" border="0" height="15" width="16" alt="'.$_template['login'].'" class="menuimage" /></a>'."\n";
				}
				echo '&nbsp;';
				?>
			</td>
		</tr>
		</table>
	</td>
</tr>
<!--tr><td colspan="2"><hr></td></tr-->

</form>

