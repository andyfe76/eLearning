<?php

$_include_path = '../include/';
$_editor_path = '../editor/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/forum_codes.inc.php');

$fid = intval($_GET['fid']);

$_section[0][0] = $_template['discussions'];
$_section[0][1] = 'discussions/';
$_section[1][0] = get_forum($fid);
$_section[1][1] = 'forum/?fid='.$_GET['fid'];
$_section[2][0] = $_template['view_post'];
?>
<style type="text/css">
	* {font-size: 8pt}
</style>
<?php 

function print_entry($row) {
	global $page;
	global $_template;
	echo '<tr>';
	echo '<td class="row1"><a name="'.$row['POST_ID'].'"></a><p><b>'.$row['SUBJECT'].'</b>';
	if ($_SESSION['is_admin'] && $_SESSION['prefs'][PREF_EDIT]) {
		echo ' <span class="bigspacer">( <a href="forum/delete_thread.php?fid='.$row['FORUM_ID'].SEP.'pid='.$row['POST_ID'].SEP.'ppid='.$row['PARENT_ID'].'"><img src="images/icon_delete.gif" border="0" alt="'.$_template['delete_thread'].'"  title="'.$_template['delete_thread'].'" /></a> | <a href="editor/edit_post.php?fid='.$row['FORUM_ID'].SEP.'pid='.$row['POST_ID'].'">'.$_template['edit'].'</a> )</span>';
	}
	echo ' <a href="forum/view.php?fid='.$row['FORUM_ID'].SEP.'pid=';

	if ($row['PARENT_ID'] == 0) {
		echo $row['POST_ID'];
	} else {
		echo $row['PARENT_ID'];
	}
	echo SEP.'reply='.$row['POST_ID'].SEP.'page='.$page.'#post">'.$_template['reply'].'</a>';
	echo '<br />';

	$date = AT_date($_SESSION['lang'], $_template['forum_date_format'], $row['DATA'], AT_MYSQL_DATETIME);

	echo '<span class="bigspacer">'.$_template['posted_by'].' <a href="send_message.php?l='.$row['MEMBER_ID'].'">'.$row['LOGIN'].'</a> '.$_template['posted_on'].' '.$date.'</span><br />';
	echo format_final_output(' '.$row['BODY'].' ');
	//echo $row['BODY'];
	echo '</p>';
	echo '</td>';
	echo '</tr>';
	echo '<tr><td height="1" class="row2" colspan="'.$colspan.'"></td></tr>';
}

if ($_REQUEST['reply']) {
	$onload = 'onLoad="document.form.subject.focus()"';
}
require($_include_path.'header.inc.php');
require($_editor_path.'spaw_control.class.php');

echo '<a href="discussions/?g=11"><h2>'. $_template['discussions'].'</h2></a>';
echo '<h3><a href="forum/?fid='.$fid.'">'.get_forum($fid).'</a></h3>';

$pid = intval($_GET['pid']);

if ($_SESSION['valid_user']) {
	$sql = "INSERT INTO forums_accessed VALUES ($pid, $_SESSION[member_id], SYSDATE)";
	$result = $db->query($sql);
	if (!$result) {
		$sql = "UPDATE forums_accessed SET last_accessed=SYSDATE WHERE post_id=$pid AND member_id=$_SESSION[member_id]";
		$result = $db->query($sql);
	}
}

$num_per_page = 10;
if (!$_GET['page']) {
	$page = 1;
} else {
	$page = intval($_GET['page']);
}
$start = ($page-1)*$num_per_page;
	
/* get the first thread first */
$sql	= "SELECT * FROM forums_threads WHERE course_id=$_SESSION[course_id] AND post_id=$pid AND forum_id=$fid";
$result	= $db->query($sql);

if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
	$num_threads = $row['NUM_COMMENTS']+1;
	$num_pages = ceil($num_threads/$num_per_page);
	$locked = $row['LOCKED'];
	if ($locked == 1) {
		echo '<p><b>'.$_template['lock_no_read1'].'</b></p>';
		require($_include_path.'footer.inc.php');
		exit;
	}

	echo '<h2>'.$row['SUBJECT'];
	echo ' - <a href="forum/view.php?fid='.$row['FORUM_ID'].SEP.'pid='.$pid;
	echo SEP.'page='.$page.'#post">'.$_template['reply'].'</a>';

	echo '</h2>';

	$parent_name = $row['SUBJECT'];


	echo '<table border="0" cellpadding="0" cellspacing="1" width="97%" class="bodyline" align="center" summary="">';
	echo '<tr>';
	echo '<td class="row1" align="right">'.$_template['page'].': ';
	for ($i=1; $i<=$num_pages; $i++) {
		if ($i == $page) {
			echo $i;
		} else {
			echo '<a href="'.$PHP_SELF.'?fid='.$fid.SEP.'pid='.$pid.SEP.'page='.$i.'">'.$i.'</a>';
		}

		if ($i<$num_pages){
			echo ' <span class="spacer">|</span> ';
		}
	}
	echo '</td>';
	echo '</tr>';
	echo '<tr><td height="1" class="row2"></td></tr>';
	echo '<tr><td height="1" class="row2"></td></tr>';
	
	if ($page == 1) {
		print_entry($row);
		$subject   = $row['SUBJECT'];
		if ($_GET['reply'] == $row['POST_ID']) {
			$saved_post = $row;
		}
		$num_per_page--;
	} else {
		$start--;
	}
	$sql	= "SELECT * FROM forums_threads WHERE course_id=$_SESSION[course_id] AND parent_id=$pid AND forum_id=$fid ORDER BY date ASC LIMIT $start, $num_per_page";
	$result	= $db->query($sql);

	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		print_entry($row);
		$subject   = $row['SUBJECT'];
		if ($_GET['reply'] == $row['POST_ID']) {
			$saved_post = $row;
		}
	}
	echo '<tr><td height="1" class="row2"></td></tr>';
	echo '<tr>';
	echo '<td class="row1" align="right">'.$_template['page'].': ';
	for ($i=1; $i<=$num_pages; $i++) {
		if ($i == $page) {
			echo $i;
		} else {
			echo '<a href="'.$PHP_SELF.'?fid='.$fid.SEP.'pid='.$pid.SEP.'page='.$i.'">'.$i.'</a>';
		}

		if ($i<$num_pages){
			echo ' <span class="spacer">|</span> ';
		}
	}
	echo '</td>';
	echo '</tr>';
	echo '</table>';

	$parent_id = $pid;
	$body	   = '';
	if (substr($subject,0,3) != 'Re:') {
		$subject = 'Re: '.$subject;
	}
	
	if ($_SESSION['valid_user']) {
		$sql	= "SELECT * FROM forums_subscriptions WHERE post_id=$_GET[pid] AND member_id=$_SESSION[member_id]";
		$result = $db->query($sql);

		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo '<p><a href="forum/subscribe.php?fid='.$fid.SEP.'pid='.$_GET['pid'].SEP.'us=1">'.$_template['unsubscribe'].'</p>';

			$subscribed = true;
		} else {
			echo '<p><a href="forum/subscribe.php?fid='.$fid.SEP.'pid='.$_GET['pid'].'">'.$_template['subscribe'].'.</p>';
		}
	}

	if ($locked == 0) {
		require($_include_path.'lib/new_thread.inc.php');
	} else {
		echo '<p><b>'.$_template['lock_no_post1'].'</b></p>';
	}
} else {
	echo $_template['no_post'];
}

require($_include_path.'footer.inc.php');
?>
