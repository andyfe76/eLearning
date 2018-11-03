<?php
/****************************************************************/
/* klore														*/
/****************************************************************/


/////////////////////////////
//Display the g_data bar chart for the member selected
//get the translations to the gdata numbers first

$sql5 = "select * from g_refs";
$result = $db->query($sql5);
$refs = array();
while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)) {
	$refs[$row['G_ID']] = $row['REFERENCE'];
}

$sql2 = "SELECT g, COUNT(*) AS cnt FROM g_click_data WHERE member_id=$member_id AND course_id=$_SESSION[course_id] GROUP BY g ORDER BY cnt DESC";
	$countsql = "SELECT COUNT(*) FROM (".$sql2.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
		
	$result7 = $db->query($sql2);
if ($count0[0] >0) {
	while($row =$result7->fetchRow(DB_FETCHMODE_ASSOC)){
			$nav_total = ($nav_total + $row["CNT"]);
	}
}

	$result = $db->query($sql2);
if ($count0[0] >0) {
	echo '<h3>'.$_template['nav_tendencies'].' '.$this_user["$member_id"].'</h3>';
	echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
	echo '<tr><th scope="col"  width="15%">'.$_template['access_method'].'</th><th scope="col" width="85%">'.$_template['count'].'</th></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';

	while($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<tr><td class="row1"><small>';
		foreach($refs AS $key => $value){
			if($key==$row2["G"]){
				echo $value;
			}
		}
		echo '</small></td><td class="row1"><img src = "images/bar.gif" height="12" width="'.((($row2["CNT"]/$nav_total)*100)*3).'" /> <small>'.$row2["CNT"]."</small></td></tr>\n";
		echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	}
	echo '</table>';




//}

////////////////////////////
//Show the member's click path
	echo '<a name="access"></a>';
	echo '<h3>'.$_template['nav_path'].' '.$this_user["$member_id"].'</h3>';
	echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
	echo '<tr><th scope="col" width="">'.$_template['access_method'].'</th><th scope="col">'.$_template['page_viewed'].'</th><th scope="col">'.$_template['duration'].'</th><th>'.$_template['date'].'</th></tr>';
	echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
	if($_SESSION['is_admin']){
		$sql	= "SELECT COUNT(*) AS cnt FROM g_click_data WHERE course_id=$_SESSION[course_id] AND member_id='$_GET[member_id]'";

	}else{
		$sql	= "SELECT COUNT(*) AS cnt FROM g_click_data WHERE course_id=$_SESSION[course_id] AND member_id='$_SESSION[member_id]'";

	}
	//create the paginator
	if(!$result	= $db->query($sql)){
		echo $_template['page_error'];
	}else{
		$num_rows =$result->fetchRow(DB_FETCHMODE_ASSOC);
		$num_records = $num_rows['CNT'];
		$num_per_page = 50;
		if (!$_GET['page']) {
			$page = 1;
		} else {
			$page = intval($_GET['page']);
		}
		$start = ($page-1)*$num_per_page;
		$num_pages = ceil($num_records/$num_per_page);
		//echo '<table border="1">';
		echo '<tr>';
		echo '<td class="row1" colspan="4" align="right">'.$_template['page'].': ';

			for ($i=1; $i<=$num_pages; $i++) {
				if ($i == $page) {
					echo ' <strong>'.$i.'</strong> ';
				} else {
					echo '<a href="'.$PHP_SELF.'?member_id='.$_GET["member_id"].SEP.'page='.$i.'#access">'.$i.'</a>';
				}

				if ($i<$num_pages){
					echo ' <span class="spacer">|</span> ';
				}
			}

		echo '</td>';
		echo '</tr>';
		echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
		//echo '</table>';
	}
$end = $start + $num_per_page;

$sql3="select 
		content.title,
		content.content_id,
		g_click_data.to_cid,
		g_click_data.g,
		g_click_data.duration,
		g_click_data.timestamp AS t
	from
		content, 
		g_click_data
	where 
		content.content_id=g_click_data.to_cid
		AND
		g_click_data.member_id=$member_id
		AND
		g_click_data.course_id=$_SESSION[course_id]";
	
$sql4="select
		g,
		member_id, 
		to_cid, 
		duration,
		timestamp AS t
	from 
		g_click_data 
	where 
		to_cid=0 AND
		member_id=$member_id
		AND
		course_id=$_SESSION[course_id]
		AND rownum BETWEEN $start AND $end
	order by
		t DESC";

if($result2 = $db->query($sql4)){
	while($row=$result2->fetchRow(DB_FETCHMODE_ASSOC)){
		$row['TITLE'] = $refs[$row['G']];
		$this_data[$row['T']] = $row;
	}
}

if($result=$db->query($sql3)){
	while($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
		$this_data[$row['T']]= $row;
	}
}
if($this_data){
	echo '<br>';
	ksort($this_data);
	$current = current($this_data);
	$pre_time = $current[t];
	foreach($this_data AS $key => $value){
		/*
		if(!$start_date){
			$start_date=$pre_time;
		}
		*/
		$diff = $value['DURATION']; // - $pre_time);
		$that_g = $refs[$value['G']];
		/*
		if ($diff > 60*45 ) {
			$end_date=$value[t];
			echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
			if($start_date>0 && $start_date!=$pre_time){
				echo $_template['session_start'].'  '.date("F j, Y,  g:i a", $start_date).' '.$_template['session_end'].' '.date("F j, Y,  g:i a", $pre_time).'     ('.$_template['duration'].':'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
			}elseif($value[g]==19){

			}else{
				echo $_template['invalid_session'];
			}
			$start_date='';
		}else{
			if(!$start_date){
				$start_date=$value[t];
			}
		}
		*/

		if ($that_g != ''){
			echo '<tr>';
			echo '<td class="row1"><small>';
			echo $that_g;
			echo '</small></td>';
			echo '<td class="row1"><small>';
			echo $value['TITLE'];
			echo '</small></td>';
			echo '<td class="row1"><small>';
			if ($diff > 60*45) {
				/* time out */
				echo $_template['na'];
				$session_time='';
			} else {
				$this_time=date('i:s', $diff);
				echo ' '.$this_time;
				$session_time=($session_time+$diff);
			}
			$remainder = $diff / 60;
			echo '</small></td>';
			echo '<td class="row1"><small>';
			echo $that_date;
			echo '</small></td>';
			echo '</tr>';
			echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
		}
		$that_date=date("M-j-y g:i:s:a", $value['T']);
		$that_g=$refs[$value['G']];
		$that_title=$value['TITLE']."&nbsp;";
		$pre_time = $value['T'];
	}
}
	echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
	if($start_date>0 && $start_date!=$pre_time){
		echo $_template['session_start'].' '.date("F j, Y,  g:i a", $start_date).' '.$_template['session_end'].' '.date("F j, Y,  g:i a", $pre_time).'     ('.$_template['duration'].':'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
	}else{
		//echo $_template['invalid_session'];
	}
	echo '</td></tr>';
	echo '</table>';
}

?>
