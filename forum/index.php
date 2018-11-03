<?php

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$fid = intval($_GET['fid']);

$_section[0][0] = $_template['discussions'];
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($fid);
$_section[1][1] = 'forum/';

if ($fid == 0) {
	Header('Location: ../discussions/');
	exit;
}

/* the last accessed field */
$last_accessed = array();
if ($_SESSION['valid_user']) {
	$sql	= "SELECT * FROM forums_accessed WHERE member_id=$_SESSION[member_id]";
	$result = $db->query($sql);
	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$last_accessed[$row['POST_ID']] = $row['LAST_ACCESSED'];
	}
}
if (($_SESSION['is_admin']) && ($_SESSION['prefs'][PREF_EDIT]==1)) {
$help[] = AT_HELP_FORUM_STICKY;
$help[] = AT_HELP_FORUM_LOCK;

}
require($_include_path.'header.inc.php');
echo '<h2><a href="discussions/">'.$_template['discussions'].'</a></h2>';
//debug($_GET);
print_help($help);
echo '<h3><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h3>';

echo '<p><a href="forum/new_thread.php?fid='.$fid.'">'.$_template['new_thread'].'</a></p>';

$sql	= "SELECT COUNT(*) AS cnt FROM forums_threads WHERE course_id=$_SESSION[course_id] AND parent_id=0 AND forum_id=$fid";
$result	= $db->query($sql);
$num_threads =$result->fetchRow(DB_FETCHMODE_ASSOC);
$num_threads = $num_threads['cnt'];

$num_per_page = 10;
if (!$_GET['page']) {
	$page = 1;
} else {
	$page = intval($_GET['page']);
}
$start = ($page-1)*$num_per_page;
$num_pages = ceil($num_threads/$num_per_page);

$sql	= "SELECT * FROM forums_threads WHERE course_id=$_SESSION[course_id] AND parent_id=0 AND forum_id=$fid ORDER BY sticky DESC, last_comment DESC LIMIT $start,$num_per_page";
$result	= $db->query($sql);

if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="98%" align="center" summary="">';
	echo '<tr>';
	echo '<th>'.$_template['topic'].'</th>';
	echo '<th>'.$_template['replies'].'</th>';
	echo '<th nowrap="nowrap">'.$_template['started_by'].'</th>';
	echo '<th nowrap="nowrap">'.$_template['last_comment'].'</th>';
	$colspan = 4;
	if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {
		echo '<th>&nbsp;</th>';
		$colspan++;
	}
	echo '</tr>';
	echo '<tr>';
	echo '<td class="row1" colspan="'.$colspan.'" align="right">'.$_template['page'].': ';

	for ($i=1; $i<=$num_pages; $i++) {
		if ($i == $page) {
			echo $i;
		} else {
			echo '<a href="'.$PHP_SELF.'?fid='.$fid.SEP.'page='.$i.'">'.$i.'</a>';
		}

		if ($i<$num_pages){
			echo ' <span class="spacer">|</span> ';
		}
	}
	
	echo '</td>';
	echo '</tr>';
	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
	echo '<tr><td height="1" class="row2" colspan="'.$colspan.'"></td></tr>';

	$current_thread = $row['THREAD_ID'];
	do {
		/* crop the subject, if needed */
		if (strlen($row['SUBJECT']) > 28) {
			$row['SUBJECT'] = substr($row['SUBJECT'], 0, 25).'...';
		}
		echo '<tr>';
		echo '<td class="row1" width="60%">';
	
		if ($_SESSION['valid_user']) {
			if ($row['last_comment']+0 > $last_accessed[$row['POST_ID']]) {
				echo '<i style="color: green; font-weight: bold; font-size: .7em;" title="'.$_template['new_thread'].'">'.$_template['new'].'</i> ';
			}
		}

		if ($row['NUM_COMMENTS'] > 10) {
			echo '<i style="color: red; font-weight: bold; font-size: .7em;" title="'.$_template['hot_thread'].'">'.$_template['hot'].'</i> ';
		}

		if ($row['LOCKED'] != 0) {
			echo '<img src="images/topic_lock.gif" alt="'.$_template['thread_locked'].'" class="menuimage" title="'.$_template['thread_locked'].'" /> ';
		}
		
		if ($row['STICKY'] != 0) {
			echo '<img src="images/forum/topic_stick.gif" alt="'.$_template['sticky_thread'].'" class="menuimage"  title="'.$_template['sticky_thread'].'" /> ';
		}
		
		if ($row['LOCKED'] != 1) {
			echo '<a href="forum/view.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].'">'.$row['SUBJECT'].'</a>';

			if ($row['LOCKED'] == 2) {
				echo ' <i class="spacer">('.$_template['post_lock'].')</i>';
			}
		} else {
			echo $row['SUBJECT'].' <i class="spacer">('.$_template['read_lock'].')</i>';
		}

		/* print page numbers */
		$num_pages_2 = ceil(($row['NUM_COMMENTS']+1)/$num_per_page);

		if ($num_pages_2 > 1) {
			echo ' <small class="spacer">( Page: ';
			for ($i=2; $i<=$num_pages_2; $i++) {
				echo '<a href="forum/view.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].SEP.'page='.$i.'">'.$i.'</a>';

				if ($i<$num_pages_2){
					echo ' | ';
				}
			}
			echo ' )</small>';
		}

		echo '</td>';

		echo '<td class="row1" width="10%" align="center">'.$row['NUM_COMMENTS'].'</td>';

		echo '<td class="row1" width="10%"><a href="send_message.php?l='.$row['MEMBER_ID'].'">'.$row['LOGIN'].'</a></td>';

		echo '<td class="row1" width="20%" align="right" nowrap="nowrap"><small>';
		echo AT_date($_SESSION['lang'], $_template['forum_date_format'], $row['LAST_COMMENT'], AT_MYSQL_DATETIME);
		echo '</small></td>';

		if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {
			echo '<td class="row1" nowrap="nowrap">';
			echo ' <a href="forum/stick.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].'"><img src="images/forum/sticky.gif" border="0" alt="'.$_template['sticky_thread'].'" title="'.$_template['sticky_thread'].'" /></a> ';
			
			if ($row['LOCKED'] != 0) {
				echo '<a href="forum/lock_thread.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].SEP.'unlock='.$row['LOCKED'].'"><img src="images/unlock.gif" border="0" alt="'.$_template['unlock_thread'].'"  title="'.$_template['unlock_thread'].'"/></a>';
			} else {
				echo '<a href="forum/lock_thread.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].'"><img src="images/lock.gif" border="0" alt="'.$_template['lock_thread'].'"  title="'.$_template['lock_thread'].'"/></a>';
			}
			echo ' <a href="forum/delete_thread.php?fid='.$fid.SEP.'pid='.$row['POST_ID'].'"><img src="images/icon_delete.gif" border="0" alt="'.$_template['delete_thread'].'"  title="'.$_template['delete_thread'].'"/></a>';
			
			echo '</td>';
		}
		echo '</tr>';
		echo '<tr><td height="1" class="row2" colspan="'.$colspan.'"></td></tr>';

	} while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC));

	echo '<tr><td height="1" class="row2" colspan="'.$colspan.'"></td></tr>';
	echo '<tr>';
	echo '<td class="row1" colspan="'.$colspan.'" align="right">'.$_template['page'].': ';

	for ($i=1; $i<=$num_pages; $i++) {
		if ($i == $page) {
			echo $i;
		} else {
			echo '<a href="'.$PHP_SELF.'?fid='.$fid.SEP.'page='.$i.'">'.$i.'</a>';
		}

		if ($i<$num_pages){
			echo ' <span class="spacer">|</span> ';
		}
	}
	
	echo '</td>';
	echo '</tr>';

	echo '</table>';

} else {
	$infos[]=AT_INFOS_NO_POSTS_FOUND;
	print_infos($infos);
	//echo 'No posts found.';
}

echo '<br />';
require($_include_path.'footer.inc.php');
?>
