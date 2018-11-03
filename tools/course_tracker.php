<?php

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];

//get the login name or real name for member_id translation
$sql14 = "select member_id, login from members";
$result14=mysql_query($sql14, $db);
while($row=mysql_fetch_array($result14)){
	$this_user[$row['member_id']]= $row['login'];
}

///////////
// Create a CSV dump of the tracking data for this course
if($_GET['csv']=='1'){
	$sql5 = "select * from g_refs";
	$result = mysql_query($sql5);
	$refs = array();
	while ($row= mysql_fetch_array($result)) {
		$refs[$row['g_id']] = $row['reference'];
	}
	//get the g translation for non content pages
	$sql8= "select
		G.g,
		R.reference,
		R.g_id
	from
		g_click_data G,
		g_refs R
	where
		G.g = R.g_id
		AND
		course_id='$_SESSION[course_id]'";

	if(!$result8 = mysql_query($sql8)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}else{

		$title_refs = array();
		while ($row= mysql_fetch_array($result8)) {
			$title_refs2[$row['g']] = $row['reference'];

		}
	}
	//get the translations for the content id numbers
	$sql7 = "select
			C.title,
			C.content_id

		from
			content C

		where
			course_id='$_SESSION[course_id]'";
	if(!$result7 = mysql_query($sql7)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}
	$title_refs = array();
	while ($row= mysql_fetch_array($result7)) {
		$title_refs[$row['content_id']] = $row['title'];

	}

	$name=ereg_replace(" ", "_", $_SESSION['course_title']);
	$name=ereg_replace("'", "", $name);
	header('Content-Type: text/csv');
	header('Content-Disposition: inline; filename="'.$name.'_tracking.csv"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$sqlall="select * from g_click_data where course_id='$_SESSION[course_id]'";

	$result_all=mysql_query($sqlall, $db);
	$num_fields = mysql_num_fields($result_all);
	for($i=0; $i<$num_fields; $i++){
		if($i==($num_fields-1)){
			$this_row .= mysql_field_name($result_all,$i);
		}else{
			$this_row .= mysql_field_name($result_all,$i).',';
		}

	}
	$this_row .= "\n";
	while($row=mysql_fetch_array($result_all)){
		$this_row .= quote_csv($this_user[$row['member_id']]).",";
		$this_row .= quote_csv($row['course_id']).",";
		if($row['from_cid']=='' || $row['from_cid']=='0'){
			$this_row .= '"0",';
		}else{
			$this_row .= quote_csv($title_refs[$row['from_cid']]).",";
		}
		if($row['to_cid']=='' || $row['to_cid']=='0'){
			$this_row .= '"0",';
		}else{
			$this_row .= quote_csv($title_refs[$row['to_cid']]).",";
		}
		$this_row .= quote_csv($title_refs2[$row['g']]).",";
		$this_row.= quote_csv($row['timestamp']).",";
		$this_row.= quote_csv($row['duration'])."\n";

	}

	$fp = @fopen('../content/export/'.$name.'_tracking.csv', 'w');
	if (!$fp) {
		$errors[]=array(AT_ERROR_CSV_FAILED, $name);
		print_errors($errors);
		exit;
	}
	@fputs($fp, $this_row); @fclose($fp);
	@readfile('../content/export/'.escapeshellcmd($name).'_tracking.csv');
	@unlink('../content/export/'.escapeshellcmd($name).'_tracking.csv');
	//$exec = 'cd ../content/export; \rm '.$name.'_tracking.csv';
	//$result = system ( $exec );
	exit;
	//debug($fields);

}

///////
require($_include_path.'header.inc.php');

//Give the user two chances when deleting tracking data
if($_GET['reset']==1){
	//$warning[]=AT_WARNING_DELETE_TRACKING;
	echo '<a name="warning"></a>';
	$warnings[]=array(AT_WARNING_DELETE_TRACKING, $PHP_SELF);
	print_warnings($warnings);
	echo '<center><a href="'.$PHP_SELF.'?reset=2">'.$_template['yes_delete'].'</a> | <a href="'.$PHP_SELF.'?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED).'">'.$_template['no_cancel'].'</a></center>';
	require($_include_path.'footer.inc.php');
	exit;
}else if($_GET['reset']==2){
	$sql_delete= "delete from g_click_data where course_id='$_SESSION[course_id]'";
	if($result_delete_track=mysql_query($sql_delete, $db)){
		$feedback[]=AT_FEEDBACK_TRACKING_DELETED;
	}else{
		$errors[]=AT_ERRORS_TRACKING_NOT_DELETED;
		require($_include_path.'footer.inc.php');
		exit;
	}
}
/////////////////////////////
// Top of the page


?>
<h2><a href="tools/?g=11"><?php echo $_template['tools']; ?></a></h2>
<h3><?php echo $_template['pages_stats']; ?></h3>
<?php
print_feedback($feedback);

//This page is only for instructor/owners
if(!$_SESSION['is_admin'] && !$_SESSION['c_instructor']){
	$infos[]=AT_INFOS_NO_PERMISSION;
	print_infos($infos);
	require($_include_path.'footer.inc.php');
	exit;
	//$infos[]=AT_INFOS_TRACKING_OFFST;
}

//}
//see if tracking is turned on
$sql="SELECT tracking from courses where course_id=$_SESSION[course_id]";
$result=mysql_query($sql, $db);
while($row= mysql_fetch_array($result)){
	if($row['tracking']== "off"){
		if($_SESSION['is_admin']){
			$infos[]=AT_INFOS_TRACKING_OFFIN;
		}else{
			$infos[]=AT_INFOS_TRACKING_OFFST;
		}
	print_infos($infos);
	require($_include_path.'footer.inc.php');
	exit;
	}
}
//$warnings[]=AT_WARNING_EXPERIMENTAL11;
//print_warnings($warnings);


//Get page stats
//$help[]=AT_HELP_TRACKING1;
//print_help($help);
?>
	<ul>
	<li><a href="<?php echo $PHP_SELF ?>?stats=summary#show_pages">Show page statistics</a>
	<br />Review content and feature usage patterns as a source of information from which to improve the effectiveness of your course.
	</li>
	<li><a href="<?php echo $PHP_SELF ?>?stats=student#show_members">Show member statistics</a>
	<br />Understand how individual students are using your course, and provide them with content that will match their learning preferences.
	</li>
	<li><a href="<?php echo $PHP_SELF ?>?csv=1">Download tracking data in a CSV file.</a>
	<br />Import the raw tracking data into a spreadsheet application, or database table, to do your own study of usage patterns. Or, archive CSV files after each session to create a course usage history.
	</li>
	<li><a href="<?php echo $PHP_SELF ?>?reset=1#warning">Reset tracker for new session.</a>
	<br />Empty your tracking data after each course session. You might choose to first archive data from previous sessions using the CSV tool above.
	</li>
	</ul>

<hr />
<?php

// present the id picker
if($_GET['stats']=='student' || $_GET['member_id']){
	//[]=AT_HELP_TRACKING;
	//print_help($help);
	$sql="select DISTINCT member_id from g_click_data where course_id='$_SESSION[course_id]' order by member_id DESC";
	$result=mysql_query($sql);
	//get the course enrollment
	$sql2="select * from course_enrollment where course_id='$_SESSION[course_id]' AND approved='y'";
	$result2=mysql_query($sql2, $db);
	while($row2=mysql_fetch_array($result2)){
		$enrolled[$row2['member_id']]=$row2['member_id'];
	}
	?>
	<a name="show_members"></a>
	<table class="bodyline" width="90%" align="center" cellpadding="0" cellspacing="1">
	<tr><th>
	<?php echo $_template['select_member']; ?>
	</th>
	</tr>
	<tr>
	<tr><td height="1" class="row2"></td></tr>
	<td class="row1">
	<form action="<?php echo $PHP_SELF; ?>#show_members" method="get">
	<select name="member_id">
	<?php
	while($row=mysql_fetch_array($result)){
		if($row["member_id"] == $enrolled[$row["member_id"]]){
			if($_GET["member_id"]==$row["member_id"]){
				echo ' selected="selected"';
			}
			echo '<option  value="'.$row["member_id"].'" ';
			if($_GET["member_id"]==$row["member_id"]){
				echo ' selected="selected"';
			}
			echo '>'.$this_user[$row["member_id"]].'</option>'."\n";
		}
	}
	?>
	</select>
	<input type="submit" value="<?php echo $_template['view_tracking'];  ?>" class="button">
	</form>
	</td>
	</tr>
	</table>
<?php
}

if($stats =="details" ||
	$_GET['stats'] == "summary"||
	$_GET['g_id'] || 
	$_GET['csv']==1)
{
require($_include_path.'lib/tracker_stats.inc.php');
}else{
require($_include_path.'lib/tracker.inc.php');
}

	require($_include_path.'footer.inc.php');

	
function quote_csv($line) {
	$line = str_replace('"', '""', $line);

	$line = str_replace("\n", '\n', $line);
	$line = str_replace("\r", '\r', $line);
	$line = str_replace("\x00", '\0', $line);

	return '"'.$line.'"';
}
?>
