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
require($_include_path.'vitals.inc.php');

$_section[0][0] = 'Tools';

require($_include_path.'header.inc.php');

/////////////////////////////
// Top of the page

?>
<h3>Navigation Tendencies and Click Path</h3>
<?php

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
?>


<?php
//give the admin some help
if($_SESSION['is_admin']){
	$help[]=AT_HELP_TRACKING;
	print_help($help);

}
////////////////////////////
//Build the member selector
if($_SESSION['is_admin']){
//if it's an instructor, present the id picker
	$sql="select DISTINCT member_id from g_click_data order by member_id DESC";
	//$sql="select * from g_click_data";
	$result=mysql_query($sql);
	?>
	<h4>Select a member to view</h4>
	<form action="<?=$PHP_SELF?>">
	<select name="member_id">
	<?
	while($row=mysql_fetch_array($result)){

		if($row["member_id"]== $member_id){
		echo '<option selected>'.$row["member_id"].'</option>'."\n";
		}else{
		echo '<option>'.$row["member_id"].'</option>'."\n";
		}

	}
	?>
	</select>
	<input type="submit">
	</form>
<? } else {
//if its a user, only display their results.
	$member_id=$_SESSION[member_id];
}

/////////////////////////////
//Display the g_data bar chart for the member selected
if($member_id && ($_SESSION[member_id] != $member_id)){
	$sql5 = "select * from g_refs";
	$result = mysql_query($sql5);
	$refs = array();
	while ($row= mysql_fetch_array($result)) {
		$refs[$row['g_id']] = $row['reference'];
	}

	?>

	<h3>Content Navigation Tendencies for User <? echo $member_id; ?></h3>
	<table border="1" width="640">
	<tr><th scope="col">Access Method</th><th scope="col">Count</th></tr>
	<?

	$sql2="select g, count(*) AS cnt from g_click_data where member_id=$member_id AND course_id='$_SESSION[course_id]' group by g";
	if($result=mysql_query($sql2)){
			while($row=mysql_fetch_array($result)){
				//echo '<option>'.$row["member_id"].'</option>'."\n";
				//echo $row["from_cid"]."\n";
				//echo $row["to_cid"]."\n";
				echo '<tr><td>';
				foreach($refs AS $key => $value){
					if($key==$row["g"]){
						echo $value;
					}
				}
				//echo $row["g"];
				echo '</td><td><img src="images/bar.gif" height="12" width="'.($row["cnt"]*2).'" />'.$row["cnt"]."</td></tr>\n";
				//echo '<tr><td>'.$row["reference"].'</td><td><img src="bar.gif" height="12" width="'.($row["cnt"]*2).'" />'.$row["cnt"]."</td></tr>\n";
				//echo $row["timestamp"]."<br />\n";
			}

	}else{
	$infos[]=AT_INFOS_TRACKING_OFF;
	print_infos($infos);

	}
echo '</table>';

}else{
	$infos[]=AT_INFOS_TRACKING_NO_INST;
 	print_infos($infos);
	require($_include_path.'footer.inc.php');
	exit;
}

////////////////////////////
//Show the member's click path
//$sql3="select G.to_cid, G.member_id, C.title, C.content_id from G.g_click_data C.content where G.to_cid=C.title";
?>

<?

$sql5 = "select * from g_refs";
$result = mysql_query($sql5);
$refs = array();
while ($row= mysql_fetch_array($result)) {
	$refs[$row['g_id']] = $row['reference'];
}

$sql3="select 
		content.title, 
		content.content_id, 
		g_click_data.to_cid,  
		g_click_data.g, 
		UNIX_TIMESTAMP(g_click_data.timestamp) AS t
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
		g_click_data.g,
		g_click_data.member_id, 
		g_click_data.to_cid, 
		UNIX_TIMESTAMP(g_click_data.timestamp) AS t 
	from 
		g_click_data 
	where 
		g_click_data.to_cid=0 
		AND
		g_click_data.member_id=$member_id
		AND
		g_click_data.course_id=$_SESSION[course_id]";

$result=mysql_query($sql3);
if($result){
	while($row=mysql_fetch_array($result)){
		$this_data[$row["t"]]= $row;
	}

}


$result2=mysql_query($sql4);
echo '<br>';
if($result2){
	while($row=mysql_fetch_array($result2)){
		$this_data[$row["t"]] = $row;
	}
	if($this_data){
		echo '<br>';

		ksort($this_data);
		echo '<h3>Content Navigation Path for User '.$member_id.'</h3>';
		echo '<table border="1">';
		echo '<tr><th scope="col">Access Method </th><th scope="col">Page Viewed</th><th scope="col">Duration</th><th>Date</th></tr>';
		$current = current($this_data);
		$pre_time = $current[t];

		foreach($this_data AS $key => $value){
		//print_r($current);
			if(!$start_date){
				//$start_date=$value[t];
				$start_date=$pre_time;
			}
			$diff = abs($value[t] - $pre_time);
			//if ($diff > 60*45 || $value[g]==19) {
			if ($diff > 60*45) {
				$end_date=$value[t];
				//echo '<tr><td colspan="2" bgcolor="#CCCCCC">'.date("F j, Y, g:i a", $value[t]).'</td><td>Total:'.$session_time.'</td></tr>';
				echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
				if($start_date>0 && $start_date!=$pre_time){
					echo 'Session above started on '.date("F j, Y,  g:i a", $start_date).' and ended on '.date("F j, Y,  g:i a", $pre_time).'     (Duration:'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
				}elseif($value[g]==19){

				}else{
					echo 'Not a Valid Session';
				}
				$start_date='';
			}else{
				if(!$start_date){
					$start_date=$value[t];
				}
			}
			echo '<tr>';
			echo '<td>';
			echo $that_g;
			//echo $refs[$value['g']];
			echo '</td>';

			echo '<td>';
			//echo $value[title]."&nbsp;";
			echo $that_title;
			echo '</td>';
			echo '<td>';
			//echo $that_time
			if ($diff > 60*45) {
				echo "N/A";
				$session_time='';

			}else{
				$this_time=date('i.s', $diff);
				echo ' '.$this_time;
				$session_time=($session_time+$diff);
			}
			$remainder = $diff / 60;
			echo '</td>';
			echo '<td>';
			echo $that_date;
			//echo date("M/j/y, g:i:s:a", $value[t]);
			echo '</td>';
			echo '</tr>';
			$that_date=date("M/j/y, g:i:s:a", $value[t]);
			$that_g=$refs[$value['g']];
			$that_title=$value[title]."&nbsp;";
			/*if ($diff > 60*45) {
				$that_time="N/A";
				$session_time='';

			}else{
				$this_time=date('i.s', $diff);
				$that_time= ' '.$this_time;
				$session_time=($session_time+$diff);
			}*/
			$pre_time = $value['t'];
		}
		echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
				if($start_date>0 && $start_date!=$pre_time){
					echo 'Session above started on '.date("F j, Y,  g:i a", $start_date).' and ended on '.date("F j, Y,  g:i a", $pre_time).'     (Duration:'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
				}else{
					echo 'Not a Valid Session';
				}
		echo '</td></tr>';
		echo '</table>';
	}


}
//echo array_values($this_data);

	require($_include_path.'footer.inc.php');
?>

