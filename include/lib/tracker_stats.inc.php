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
/////////////////////////////
//Display the g_data bar chart for the member selected

//get the summary data for all pages

//get the translations for the g numbers

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
			G.to_cid = 0
			AND
			course_id='$_SESSION[course_id]'";
	$title_tools = array();
	$result9 = mysql_query($sql9, $db);
	while ($row= mysql_fetch_array($result9)) {
			if($row['g'] == $row['g_id']){
				$title_tools[$row['g_id']] = $row['reference'];
				$tool_grefs[$row['g_id']] = $row['g_id'];
				$gcount[$row['g_id']]++;
			}
	}
$sql10 = "select count(g) from g_click_data where course_id='$_SESSION[course_id]' GROUP BY g";
$result10 = mysql_query($sql10, $db);
while($row=mysql_fetch_array($result10)){
	$thiscount[]=$row;

}

if($_GET['stats']="summary" && !$to_cid &&!$_GET['csv'] && !$_GET['g_id']){

	$sql12= "select to_cid, g, AVG(duration) AS t, count(g) as c from g_click_data where to_cid='0' AND course_id='$_SESSION[course_id]' GROUP BY g";

	if($result12=mysql_query($sql12, $db)){
		while($row=mysql_fetch_array($result12)){
			if($row['g']){
				$nav_total = ($nav_total + $row['c']);
			}
			if($row['to_cid']==0){
				$that_time[$row['g']]= $row['t'];
			}
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

			foreach($title_tools as $key=>$value){
				$tool_names[$key] = $gcount[$key];

			}
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
	echo '</table>';

	?>
	<h3><?php  echo  $_template['page_stats']; ?></h3>
	<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">
	<tr><th scope="col"  width="25%"><?php  echo  $_template['page_title']; ?></th><th scope="col" width="55%"><?php  echo  $_template['hit_count']; ?></th><th scope="col" width="10%"><?php  echo  $_template['avg_duration']; ?></th><th scope="col" width="10%"><?php  echo  $_template['details']; ?></th></tr>
	<tr><td height="1" class="row2" colspan="4"></td></tr>
	<?php
	//get content page traffic

	$sql6="SELECT
			G.to_cid,
			count(*) AS pages,
			G.g

		from
			g_click_data G

		where
			G.to_cid <> 0
			AND
			course_id='$_SESSION[course_id]'

		group by
			G.to_cid";
	if(!$result6 = mysql_query($sql6)){
		echo "query failed";
		require($_include_path.'footer.inc.php');
		exit;
	}
	
	$sql11= "select to_cid, AVG(duration) AS t from g_click_data where course_id='$_SESSION[course_id]' GROUP BY to_cid";

	if($result11=mysql_query($sql11, $db)){
		while($row=mysql_fetch_array($result11)){
			$this_time[$row['to_cid']]= $row['t'];

		}
	}else{
		echo $_template['unknown_error'];
	}
	$max_bar_width='180';
	$result9 = mysql_query($sql6);
	while($row = mysql_fetch_array($result9)){
		$total_hits=($total_hits + $row["pages"]);
	}
	if($total_hits){
		$bar_factor = ($max_bar_width/$total_hits);
	}
	if($result6 = mysql_query($sql6)){
				while($row = mysql_fetch_array($result6)){
					echo '<tr><td class="row1"><small>';
					echo $title_refs[$row['to_cid']];
					echo '</small></td><td class="row1"><img src = "images/bar.gif" height="12" width="'.($row["pages"]*$bar_factor).'" alt=" "/><small>'.$row["pages"].'</small></td>'."\n";
					$this_avgtime=(number_format($this_time[$row['to_cid']], 1  )/$row["pages"]);
					echo '<td class="row1"><small>'.number_format($this_avgtime, 1).'</small></td>';
					echo '<td class="row1"><a href="'.$PHP_SELF.'?stats=details'.SEP.'to_cid='.$row['to_cid'].'#show_pages"><small>'.$_template['details'].'</small></a></td></tr>'."\n";

					echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
					}
				}

	echo '</table>';
}  //end summary

//get the rawdata for a single page
if($_SESSION['is_admin']){
	$sql3="select
		content.title,
		content.content_id,
		g_click_data.member_id as m,
		g_click_data.to_cid,
		g_click_data.g,
		g_click_data.timestamp AS t
	from
		content,
		g_click_data
	where
		content.content_id=g_click_data.to_cid
		AND
		g_click_data.to_cid=$to_cid
		AND
		g_click_data.course_id=$_SESSION[course_id]";



	$result3=mysql_query($sql3);
	if($result3){
		while($row=mysql_fetch_array($result3)){
			$this_data[$row["t"]]= $row;
			$this_user[$row["t"]]= $row['m'];
		}
		ksort($this_data);
		$current = current($this_data);
		$pre_time = $current[t];

	}

}


if($to_cid) {
	?>
	<a name="show_pages"></a>
	<p>[<a href="<?php echo $PHP_SELF.'?stats=summary';?>#show_pages"><?php echo $_template['back_to_summary']; ?></a>]</p>

	<h3><?php echo $_template['access_stats']; ?><?php echo $current['title']; ?></h3>
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



	if($result2 = mysql_query($sql2)){
			while($row = mysql_fetch_array($result2)){
				echo '<tr><td class="row1">';
				foreach($refs AS $key => $value){
					if($key==$row["g"]){
						echo $value;
					}
				}
				echo '</td><td class="row1"><img src = "images/bar.gif" height="12" width="'.($row["cnt"]*2).'" alt=" " />'.$row["cnt"]."</td></tr>\n";
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
		g_click_data.to_cid=0
		AND
		g_click_data.to_cid=$to_cid
		AND
		g_click_data.course_id=$_SESSION[course_id]
		GROUP BY 
		m
		";
	$result4 = mysql_query($sql4, $db);

	if($result4){

		if($this_data){
			echo '<br>';
			echo '<a name="show_pages"></a>';
			echo '<h3>'.$_template['pages_stats'].':  '.$current["title"].'</h3>';
			echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
			echo '<tr><th scope="col" width="">'.$_template['access_method'].'</th><th scope="col">'.$_template['duration_sec'].'</th><th scope="col">'.$_template['date'].'</th><th scope="col">'.$_template['student_id'].'</th></tr>';
			echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
			foreach($this_data AS $key => $value){
				if(!$start_date){
					$start_date=$pre_time;
				}
				$diff = abs($value[t] - $pre_time);
				if ($diff > 60*45) {
					$end_date=$value[t];
					echo '<tr><td colspan="4" bgcolor="#CCCCCC">';
					if($start_date>0 && $start_date!=$pre_time){
						echo $_template['session_start'].' '.date("F j, Y,  g:i a", $start_date).' '.$_template['session_end'].' '.date("F j, Y,  g:i a", $pre_time).'     ('.$_template['duration'].':'.date('i \m\i\n s \s\e\c',($pre_time-$start_date)).')</td></tr>';
					}elseif($value[g]==19){
						//don't do anything if its a logout
					}else{
						echo $_template['invalid_session'];
					}
					$start_date='';
				}else{
					if(!$start_date){
						$start_date=$value[t];
					}
				}
				echo '<tr>';
				echo '<td class="row1">';
				$that_g=$refs[$value['g']];
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
				echo '<td class="row1">'.$this_user[$value['m']].'</td>';
				echo '</tr>';
				echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
				$that_date=date("M-j-y g:i:s:a", $value[t]);
				$that_title=$value[title]."&nbsp;";
				$pre_time = $value['t'];
			}
			echo '</table>';
		}
	}
}  /// end page detail

if($_GET['g_id']){
	$sql14 = "select member_id, login from members";
	$result14=mysql_query($sql14, $db);
	while($row=mysql_fetch_array($result14)){
		$this_user[$row['member_id']]= $row['login'];
	}
	$sql13 = "select *, timestamp as t from g_click_data where to_cid='0' AND g='$_GET[g_id]' AND course_id='$_SESSION[course_id]'";
	$result13 = mysql_query($sql13, $db);
	echo '<a name="show_pages"></a>';
	echo '<h3>'.$_template['tools_details'].'('.$title_refs2[$g_id].')</h3>';
	echo '<p>[<a href="'.$PHP_SELF.'?stats=summary#show_pages">'.$_template['back_to_summary'],'</a>]</p>';
	echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">';
	echo '<tr><th scope="col" width="">'.$_template['origin_page'].'</th><th scope="col">'.$_template['duration_sec'].'</th><th scope="col">'.$_template['date'].'</th><th scope="col">'.$_template['student_id'].'</th></tr>';
	echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';

	while ($row=mysql_fetch_array($result13)){
	
		echo '<tr>';
		if($row['from_cid']==0){
			echo '<td class="row1"><small>'.$title_refs2[$row['g']].'</small></td>';
		}else{
			echo '<td class="row1"><small>'.$title_refs[$row['from_cid']].'</small></td>';
		}
		echo '<td class="row1"><small>'.$row['duration'].'</small></td>';
		echo '<td class="row1"><small>'.date("M-j-y g:i:s:a",$row['t'] ).'</small></td>';
		echo '<td class="row1"><small>'.$this_user[$row['member_id']].'</small></td>';
		echo '</tr>';
		echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
	}
	echo '</table>';
}


?>
