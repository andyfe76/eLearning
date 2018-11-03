<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/


$_include_path = '../include/';

require ($_include_path.'vitals.inc.php');
$section = 'discussions';
$_section[0][0] = $_template['discussions'];
require ($_include_path.'header.inc.php');

?>
<h2><?php  echo $_template['discussions']; ?></h2>
<?php

	if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {
		$help[] = AT_HELP_CREATE_FORUMS;
		print_help($help);

	}
	
	if ($_SESSION['is_admin'] && !$_SESSION['prefs'][PREF_EDIT]) {
		$help[] = array(AT_HELP_ENABLE_EDITOR, $_my_uri);
		print_help($help);

	}
?>
<ul>
	<li><b><?php echo $_template['forums']; ?></b> <?php

	if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {


		echo '<span class="bigspacer">( ';
		echo '<a href="editor/add_forum.php">'.$_template['new_forum'].'</a>';
		echo ' )</span>';
	}
	?>
		<ul>
		<?php
			$sql	= "SELECT * FROM forums WHERE course_id=$_SESSION[course_id] ORDER BY title";
			$result = mysql_query($sql, $db);

			if ($row = mysql_fetch_array($result)) {
				do {
					echo '<li><a href="forum/?fid='.$row['forum_id'].'">'.$row['title'].'</a>';
					if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {
						echo ' <span class="bigspacer">( ';
						echo '<a href="editor/edit_forum.php?fid='.$row['forum_id'].'">'.$_template['edit'].'</a>';
						echo ' | ';
						echo '<a href="editor/delete_forum.php?fid='.$row['forum_id'].'">'.$_template['delete'].'</a>';
						echo ' )</span>';
					}
					echo '<p>'.$row['description'].'</p>';
					echo '</li>';
				} while ($row = mysql_fetch_array($result));
			} else {
				echo '<li><i>'.$_template['no_forums'].'</i></li>';
			}
		?>
		</ul>

	<?php
	require($_include_path.'language/en_discussions_page.inc.php');
;	echo '<table width="40%" border="0" cellspacing="0" cellpadding="0" class="cat2" summary="">';
	echo '<tr><td class="catd" valign="top">';
	print_popup_help(AT_HELP_USERS_MENU);
	echo '<span class="white">';
	echo $_template['users_online'];
	echo '</span>';
	echo '</td></tr>';
	echo '<tr>';
	echo '<td class="row1" align="left">';

	$sql	= "SELECT * FROM users_online WHERE course_id=$_SESSION[course_id] AND expiry>".time()." ORDER BY login";
	$result	= mysql_query($sql, $db);

	if ($row = mysql_fetch_array($result)) {
		echo '<ul>';
		do {
			echo '<li><a href="send_message.php?l='.$row['member_id'].SEP.'g=1">'.$row['login'].'</a></li>';
		} while ($row = mysql_fetch_array($result));

		echo '</ul>';
	} else {
		echo '<small><i>'.$_template['none_found'].'</i></small><br />';
	}

	echo '<small><i>'.$_template['guests_not_listed'].'</i></small>';
	echo '</td></tr></table>';

	?>
	</li>

</ul>
<br />
<br />
<?php
	require ($_include_path.'footer.inc.php');
?>
