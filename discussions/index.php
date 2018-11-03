<?php
/****************************************************************/
/* klore														*/
/****************************************************************/


$_include_path = '../include/';

require ($_include_path.'vitals.inc.php');
$section = 'discussions';
$_section[0][0] = $_template['discussions'];
require ($_include_path.'header.inc.php');

?>
<br><br><h2><?php  echo $_template['discussions']; ?></h2>
<ul>
	<!--li><b><?php echo //$_template['forums']; ?></b--> <?php

	if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {


		//echo '<span class="bigspacer">( ';
		//echo '<a href="editor/add_forum.php">'.$_template['new_forum'].'</a>';
		//echo ' )</span>';
	}
	?>
		<ul>
		<?php
			$sql	= "SELECT * FROM forums WHERE course_id=$_SESSION[course_id] ORDER BY title";
			$result = $db->query($sql);

			if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				do {
					//echo '<li><a href="forum/?fid='.$row['FORUM_ID'].'">'.$row['TITLE'].'</a>';
					if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
						//echo ' <span class="bigspacer">( ';
						//echo '<a href="editor/edit_forum.php?fid='.$row['FORUM_ID'].'">'.$_template['edit'].'</a>';
						//echo ' | ';
						//echo '<a href="editor/delete_forum.php?fid='.$row['FORUM_ID'].'">'.$_template['delete'].'</a>';
						//echo ' )</span>';
					}
					//echo '<p>'.$row['DESCRIPTION'].'</p>';
					//echo '</li>';
				} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));
			} else {
				//echo '<li><i>'.$_template['no_forums'].'</i></li>';
			}
		?>
		</ul>

	<?php
	require($_include_path.'language/ro_discussions_page.inc.php');
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
	$result	= $db->query($sql);

	if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		echo '<ul>';
		do {
			/*$res_tmp=$db->query('select * from members where status=1 and member_id='.$row['MEMBER_ID']);
			if (mysql_num_rows($res_tmp)==1) {$_SESSION['IsInstrOnline']='true'} */			
			echo '<li><a href="send_message.php?l='.$row['MEMBER_ID'].SEP.'g=1">'.$row['LOGIN'].'</a></li>';
		} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));

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
