<?php
/****************************************************************/
/* klore														*/
/****************************************************************/


/////////////////////////////
//Display the g_data bar chart for the member selected

//get the summary data for all pages

//get the translations for the g numbers

$sql5 = "select * from g_refs";
	$result = $db->query($sql5);
	$refs = array();
	while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$refs[$row['G_ID']] = $row['REFERENCE'];
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
		course_id=$_SESSION[course_id]";

	if(!$result8 = $db->query($sql8)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}else{
		
		$title_refs = array();
		while ($row=$result8->fetchRow(DB_FETCHMODE_ASSOC)) {
			$title_refs2[$row['G']] = $row['REFERENCE'];
		}
	}

//get the translations for the content id numbers
$sql7 = "select
			C.title,
			C.content_id

		from
			content C

		where
			course_id=$_SESSION[course_id]";
	if(!$result7 = $db->query($sql7)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}
	$title_refs = array();
	while ($row=$result7->fetchRow(DB_FETCHMODE_ASSOC)) {
		$title_refs[$row['CONTENT_ID']] = $row['TITLE'];

	}

//get tools klore tools traffic

$sql9="SELECT 
			G.to_cid,
			G.g,
			R.g_id,
			R.reference

		from
			g_click_data G,
			g_refs R
		where
			course_id=$_SESSION[course_id]";

	$title_tools = array();
	$result9 = $db->query($sql9);
	while ($row=$result9->fetchRow(DB_FETCHMODE_ASSOC)) {
			if($row['G'] == $row['G_ID']){
				$title_tools[$row['G_ID']] = $row['REFERENCE'];
				$tool_grefs[$row['G_ID']] = $row['G_ID'];
				$gcount[$row['G_ID']]++;
			}
	}
$sql10 = "select count(g) from g_click_data where course_id=$_SESSION[course_id] GROUP BY g";
$result10 = $db->query($sql10);
while($row=$result10->fetchRow(DB_FETCHMODE_ASSOC)){
	$thiscount[]=$row;

}
/// --- 
if($_GET['stats']="summary" && !$to_cid &&!$_GET['csv'] && !$_GET['g_id']){

	$sql12= "select g, AVG(duration) AS t, count(g) as c from g_click_data WHERE course_id='$_SESSION[course_id]' GROUP BY g";
	
	if($result12=$db->query($sql12)){
		while($row=$result12->fetchRow(DB_FETCHMODE_ASSOC)){
			if($row['G']){
				$nav_total = ($nav_total + $row['C']);
			}
			$that_time[$row['G']]= $row['T'];
		}
	}else{
		echo $_template['unknown_error'];
	}
	
	
?>
	<a name="show_pages"></a>
	<h3><?php  echo  $_template['tool_summary']; ?></h3>
	<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">
	<tr><th scope="col"  width="25%"><?php  echo  $_template['at_tools']; ?></th><th scope="col" width="55%"><?php  echo  $_template['hit_count']; ?></th><th scope="col" width="10%"><?php  echo  $_template['avg_duration']; ?></th><th scope="col" width="10%"><?php  echo  $_template['details']; ?></th></tr>
	<tr><td height="1" class="row2" colspan="4"></td></tr>
	<?php
			//this array needs to be created from the database (eventually add new field to g_refs table called "timed" values true/false
			$timed_tools=array(14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 20=>20, 21=>21, 23=>23, 27=>27, 28=>28, 29=>29);
			//$this_i=1;

			//$tool_names = new Array(array_count_values($title_tools));
			foreach($title_tools as $key=>$value){
				$tool_names[$key] = $gcount[$key];

			}
			if (is_array($tool_names)){
				arsort($tool_names);
				foreach($tool_names as $key=>$value){
					//$this_i++;
					echo '<tr><td class="row1"><small>';
					echo $title_tools[$key];
					echo '</small></td><td class="row1"><small><img src = "images/bar.gif" height="12" width="'.((($gcount[$key]/$nav_total)*100)*2).'" alt=" " />';
					echo $value;
					echo '</small></td>';
					$that_avgtime='';
					if($timed_tools[$key]==$key){  
						$that_avgtime=number_format((number_format($that_time[$key], 1  )/$gcount[$key]),1);
					}
					echo '<td class="row1"><small>';
					if($that_avgtime){
						echo $that_avgtime;
					}else{
						echo $_template['na'];
					}
					echo '</small></td>';
					echo '<td class="row1"><small><a href="'.$PHP_SELF.'?g_id='.$key.'#show_pages">'.$_template['details'].'</a></td></small>';
					echo '</tr>';
							echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
				}
			}
	echo '</table>';

	?>
	<br><h3><?php  echo  $_template['page_stats']; ?></h3>
	<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">
	<tr><th scope="col"  width="25%"><?php  echo  $_template['page_title']; ?></th><th scope="col" width="55%"><?php  echo  $_template['hit_count']; ?></th><th scope="col" width="10%"><?php  echo  $_template['avg_duration']; ?></th><th scope="col" width="10%"><?php  echo  $_template['details']; ?></th></tr>
	<tr><td height="1" class="row2" colspan="4"></td></tr>
	<?php
	//get content page traffic
	
	$sql6 = "SELECT to_cid, COUNT(*) AS pages, g FROM g_click_data WHERE to_cid<>0 AND course_id=$_SESSION[course_id] GROUP BY to_cid, g";
	if(!$result6 = $db->query($sql6)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}
	
	$sql11= "select to_cid, AVG(duration) AS t from g_click_data where course_id='$_SESSION[course_id]' GROUP BY to_cid";

	if($result11=$db->query($sql11)){
		while($row=$result11->fetchRow(DB_FETCHMODE_ASSOC)){
			$this_time[$row['TO_CID']]= $row['T'];

		}
	}else{
		echo $_template['unknown_error'];
	}
	$max_bar_width='180';
	$result9 = $db->query($sql6);
	while($row =$result9->fetchRow(DB_FETCHMODE_ASSOC)){
		$total_hits=($total_hits + $row["PAGES"]);
	}
	if($total_hits){
		$bar_factor = ($max_bar_width/$total_hits);
	}
	if($result6 = $db->query($sql6)){
				while($row =$result6->fetchRow(DB_FETCHMODE_ASSOC)){
					echo '<tr><td class="row1"><small>';
					echo $title_refs[$row['TO_CID']];
					echo '</small></td><td class="row1"><img src = "images/bar.gif" height="12" width="'.($row["PAGES"]*$bar_factor).'" alt=" "/><small>'.$row["PAGES"].'</small></td>'."\n";
					$this_avgtime=(number_format($this_time[$row['TO_CID']], 1  )/$row["PAGES"]);
					echo '<td class="row1"><small>'.number_format($this_avgtime, 1).'</small></td>';
					echo '<td class="row1"><a href="'.$PHP_SELF.'?stats=details'.SEP.'to_cid='.$row['TO_CID'].'#show_pages"><small>'.$_template['details'].'</small></a></td></tr>'."\n";
					echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
				}
	}

	echo '</table>';
}  //end summary

//get the rawdata for a single page
if($_SESSION['is_admin']){
	if (!isset($to_cid)) $to_cid = 0;
	$sql3="select
		C.title,
		C.content_id,
		G.member_id as m,
		G.to_cid,
		G.g,
		timestamp AS t
	from
		content C,
		g_click_data G
	where
		C.content_id=G.to_cid
		AND
		G.to_cid=$to_cid
		AND
		G.course_id=$_SESSION[course_id]";


	$result3=$db->query($sql3);
	$countsql = "SELECT COUNT(*) FROM (".$sql3.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();
	if($count0[0] >0){
		while($row=$result3->fetchRow(DB_FETCHMODE_ASSOC)){
			$this_data[$row["T"]]= $row;
			$this_user[$row["T"]]= $row['M'];
		}
		ksort($this_data);
		$current = current($this_data);
		$pre_time = $current['T'];

	}

}


if($to_cid) {
	?>
	<a name="show_pages"></a>
	<p>[<a href="<?php echo $PHP_SELF.'?stats=summary';?>#show_pages"><?php echo $_template['back_to_summary']; ?></a>]</p>

	<h3><?php echo $_template['access_stats']; ?><?php echo $current['TITLE']; ?></h3>
	<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">
	<tr><th scope="col"  width="15%"><?php echo $_template['access_method']; ?></th><th scope="col" width="85%"><?php echo $_template['count']; ?></th></tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<?php

	//get the number of clicks per g
	$sql2 = "select
			g,
			count(*) AS cnt
		from
			g_click_data
		where
			to_cid=$to_cid
			AND
			course_id='$_SESSION[course_id]'
		group by
			 g";



	if($result2 = $db->query($sql2)){
			while($row =$result2->fetchRow(DB_FETCHMODE_ASSOC)){
				echo '<tr><td class="row1">';
				foreach($refs AS $key => $value){
					if($key==$row["G"]){
						echo $value;
					}
				}
				echo '</td><td class="row1"><img src = "images/bar.gif" height="12" width="'.($row["CNT"]*2).'" alt=" " />'.$row["CNT"]."</td></tr>\n";
;				echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
			}

	}
	echo '</table>';
	echo '<br>';

	//////////////
	$sql4="select
		g_click_data.g,
		g_click_data.member_id AS m,
		g_click_data.to_cid,
		g_click_data.timestamp AS t
	from
		g_click_data
	where
		g_click_data.to_cid=$to_cid
		AND
		g_click_data.course_id=$_SESSION[course_id]
		GROUP BY 
		m
		";
	$result4 = $db->query($sql4);

	if($result4){
		if($this_data){
			echo '<br>';
			echo '<a name="show_pages"></a>';
			echo '<h3>'.$_template['pages_stats'].':  '.$current["TITLE"].'</h3>';
			echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
			echo '<tr><th scope="col" width="">'.$_template['access_method'].'</th><th scope="col">'.$_template['duration_sec'].'</th><th scope="col">'.$_template['date'].'</th><th scope="col">'.$_template['student_id'].'</th></tr>';
			echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
			foreach($this_data AS $key => $value){
				if(!$start_date){
					$start_date=$pre_time;
				}
				$diff = abs($value['T'] - $pre_time);
				if ($diff > 60*45) {
					$end_date=$value['T'];
					echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
					if($start_date>0 && $start_date!=$pre_time){
						echo $_template['session_start'].' '.date("F j, Y,  g:i a", $start_date).' '.$_template['session_end'].' '.date("F j, Y,  g:i a", $pre_time).'     ('.$_template['duration'].':'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
					}elseif($value['G']==19){
						//don't do anything if its a logout
					}else{
						echo $_template['invalid_session'];
					}
					$start_date='';
				}else{
					if(!$start_date){
						$start_date=$value['T'];
					}
				}
				echo '<tr>';
				echo '<td class="row1">';
				$that_g=$refs[$value['G']];
				echo $that_g;
				echo '</td>';
				echo '<td class="row1">';
				//echo $that_time
				if ($diff > 60*45) {
					echo $_template['na'];
					$session_time='';

				}else{
					$this_time=date('i.s', $diff);
					echo ' '.$this_time;
					$session_time=($session_time+$diff);
				}
				$remainder = $diff / 60;
				echo '</td>';
				echo '<td class="row1">';
				echo $that_date;
				echo '</td>';
				echo '<td class="row1">'.$this_user[$value['M']].'</td>';
				echo '</tr>';
				echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
				$that_date=date("M-j-y g:i:s:a", $value['T']);
				$that_title=$value['TITLE']."&nbsp;";
				$pre_time = $value['T'];
			}
			echo '</table>';
		}
	}
}  /// end page detail

if($_GET['g_id']){
	$sql14 = "select member_id, login from members";
	$result14=$db->query($sql14);
	while($row=$result14->fetchRow(DB_FETCHMODE_ASSOC)){
		$this_user[$row['MEMBER_ID']]= $row['LOGIN'];
	}
	$sql13 = "select member_id, from_cid, to_cid, g, duration, timestamp as t from g_click_data where g=$_GET[g_id] AND course_id=$_SESSION[course_id]";
	$result13 = $db->query($sql13);
	echo '<a name="show_pages"></a>';
	echo '<h3>'.$_template['tools_details'].'('.$title_refs2[$g_id].')</h3>';
	echo '<p>[<a href="'.$PHP_SELF.'?stats=summary#show_pages">'.$_template['back_to_summary'],'</a>]</p>';
	echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
	echo '<tr><th scope="col" width="">'.$_template['origin_page'].'</th><th scope="col">'.$_template['duration_sec'].'</th><th scope="col">'.$_template['date'].'</th><th scope="col">'.$_template['student_id'].'</th></tr>';
	echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
	while ($row=$result13->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<tr>';
		if($row['FROM_CID']==0){
			echo '<td class="row1"><small>'.$title_refs2[$row['G']].'</small></td>';
		}else{
			echo '<td class="row1"><small>'.$title_refs[$row['FROM_CID']].'</small></td>';
		}
		echo '<td class="row1"><small>'.$row['DURATION'].'</small></td>';
		echo '<td class="row1"><small>'.date("M-j-y g:i:s:a",$row['T'] ).'</small></td>';
		echo '<td class="row1"><small>'.$this_user[$row['MEMBER_ID']].'</small></td>';
		echo '</tr>';
		echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
	}
	echo '</table>';
}


?>
