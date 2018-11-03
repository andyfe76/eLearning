<?php

$_include_path	='../include/';
	$_section = $_template['home'];
	require($_include_path.'vitals.inc.php');
	require($_include_path.'header.inc.php');
$course_select=$_SESSION[course_id];
$submit=1;
echo '<a name="top"></a>';
?>
<h1 class="hide"><?php echo $_template['print_compiler']; ?></h3>

<?php
if ($print) {
	if(!$parent){
		$errors[]=AT_ERROR_CHOOSE_ONE_SECTION;

	}else{	
		echo '<p class="hide">';
			$help[]=AT_HELP_BROWSER_PRINT_BUTTON;
			print_help($help);
		echo '</p>';
		echo '<p class="hide">[<a href="'.$PHP_SELF.'?print=">Back to Content Selector</a>]</p>';
		$sql = "SELECT title, content_parent_id, content_id, ordering, text FROM content WHERE  ";
		$i=0;
		foreach($parent as $key=>$value){
			if($i==0){
				$sql.= 'content_id='.$value.' ';
			}else{
				$sql.= 'OR content_id='.$value.' ';
			}
			$i++;
		}
		$sql.=' ORDER BY ordering';
		if ($result= mysql_query($sql)) {
			while ($myrow = mysql_fetch_row($result)){
				$con_id = $myrow[2];
				$text = $myrow[4];
				replace_icons($text);
				if ($myrow[0] != 'Welcome To klore') {
					echo '<br /><br /><a name="'.$myrow[0].'"></a><h2>'.$myrow[0].'</h2><br />';
					echo $text.'<br />';
					//echo '&nbsp;<a href="#top">top</a><br />';
				}
				get_children($con_id);
				echo '<hr />';
			}
		} else {
			$errors[]=AT_ERROR_NO_COURSE_CONTENT;
		}
	}
	//require($_include_path.'footer.inc.php');
	//exit;
}
//This function only extracts 4 levels of content
function get_children($con_id){
	//global $i;
	global $text;
	global $con_id;
	global $course_select;
		$sql1 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id ORDER BY ordering";
		//echo '<br />'.$sql1;
		//echo "content/".$course_select;
		$result2 = mysql_query($sql1);
		while ($myrow2 = mysql_fetch_row($result2)){
			$con_id1=$myrow2[3];
			$text = $myrow2[1];
			replace_icons($text);
			echo '<br /><a name="'.$myrow2[0].'"></a><h3>'.$myrow2[0].'</h3><br />';
			echo $text.'<br />';
			$sql3 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id1 ORDER BY ordering";
			$result3 = mysql_query($sql3);
			while ($myrow3 = mysql_fetch_row($result3)){
				$con_id2=$myrow3[3];
				$text = $myrow3[1];
				replace_icons($text);
				echo '<br /><a name="'.$myrow3[0].'"></a><h3>'.$myrow3[0].'</h3><br />';
				echo $text.'<br />';
				$sql4 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id2 ORDER BY ordering";
				$result4 = mysql_query($sql4);
				while ($myrow4 = mysql_fetch_row($result4)){
					$con_id3=$myrow4[3];
					$text = $myrow4[1];
					replace_icons($text);
					echo '<br /><a name="'.$myrow4[0].'"></a><h3>'.$myrow4[0].'</h3><br />';
					echo $text.'<br />';
					$sql5 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id3 ORDER BY ordering";
					$result5 = mysql_query($sql5);
					while ($myrow5 = mysql_fetch_row($result5)){
						$con_id4=$myrow5[3];
						$text = $myrow5[1];
						replace_icons($text);
						echo '<br /><a name="'.$myrow5[0].'"></a><h3>'.$myrow5[0].'</h3><br />';
						echo $text.'<br />';

					}
				}

			}

		}
}

function replace_icons($text){
	global $text;
	global $course_select;
	$text = str_replace("CONTENT_DIR", "content/".$course_select,$text);
	$text = str_replace("[write]", '<img src="images/concepts/write1a.gif" alt="Write"/>',$text);
	$text = str_replace("[link]", '<img src="images/concepts/chain.gif" alt="Web Links"/>',$text);
	$text = str_replace("[discussion]", '<img src="images/concepts/discussion.gif" alt="Discussions"/>',$text);
	$text = str_replace("[important]", '<img src="images/concepts/exclaim.gif" alt="Important"/>',$text);
	$text = str_replace("[information]", '<img src="images/concepts/info1.gif" alt="Information"/>',$text);
	$text = str_replace("[project]", '<img src="images/concepts/project.gif" alt="Project Topic"/>',$text);
	$text = str_replace("[read]", '<img src="images/concepts/read.jpg" alt="Advanced Reading"/>',$text);
	$text = str_replace("[test]", '<img src="images/concepts/test.jpg" alt="Test"/>',$text);
	$text = str_replace("[do]", '<img src="images/concepts/yes1b.gif" alt="Do"/>',$text);
	$text = str_replace("[dont]", '<img src="images/concepts/no2a.gif" alt="Dont"/>',$text);
	$text = str_replace("[listen]", '<img src="images/concepts/listen1b.gif" alt="Listen"/>',$text);
	$text = str_replace("Links open in a new window", "",$text);
	$text = str_replace("[think]", '<img src="images/concepts/think.gif" alt="Think Critically"/>',$text);
	$text = str_replace("[question]", '<img src="images/concepts/questiona.gif" alt="Question This"/>',$text);
	//$text = strip_tags($text, '<p><img><strong><em><b><i><ul><ol><li><hr /><span><div><br><h1><h2><h3><h4><h5><h6><table><td><tr>');
	//return $text;
}

if ($submit){

?>
	<script language="JavaScript" type="text/javascript">
	<!--
	function CheckAll()
	{
		for (var i=0;i<document.selectform.elements.length;i++)
		{
			var e = document.selectform.elements[i];
			if ((e.name != 'selectall') && (e.type=='checkbox'))
			e.checked = document.selectform.selectall.checked;
		}
	}
	function CheckCheckAll()
	{
		var TotalBoxes = 0;
		var TotalOn = 0;
		for (var i=0;i<document.selectform.elements.length;i++)
		{
			var e = document.selectform.elements[i];
			if ((e.name != 'selectall') && (e.type=='checkbox'))
			{
				TotalBoxes++;
			if (e.checked)
			{
				TotalOn++;
			}
			}
		}
		if (TotalBoxes==TotalOn)
		{document.selectform.selectall.checked=true;}
		else
		{document.selectform.selectall.checked=false;}
	}
	-->
	</script>
<?php
	print_errors($errors);
	$help[]=AT_HELP_PRINT_COMPILER;
	$help[]=AT_HELP_PRINT_COMPILER2;
	print_help($help);
if(!$print || $errors){
	if(!$errors){
?>
	<?php
		$warnings[]=AT_WARNING_RAM_SIZE;
		print_warnings($warnings);
	}
	if($errors || !$print){
	?>
		<hr />
		<h3><?php $_template['content_selector']; ?></h3>
		<?php
			echo '<form action="'.$PHP_SELF.'" name="selectform" method="post">'."\n";
			if ($db) {
				//echo '<p>Please select the content you would like to display to print.</p><br />';
				echo '<table border="0" width="90%" class="bodyline" cellspacing="1" cellpadding="0" align="center">'."\n";
				echo '<tr><th scope="col"  width="10%">'.$_template['select'].'</th><th scope="col" width="90%">'.$_template['title'].'</th></tr>'."\n";
				echo '<tr><td class="row1"><input type="checkbox" value="SelectAll" id="all" title="select/unselect all" name="selectall" onclick="CheckAll();"/></td><td class="row1"> <b><label for="all">'.$_template['select_all'].'</label></b><input type="hidden" name="course_select" value="'.$course_select.'" /></td></tr>'."\n";

				$index = "SELECT title, content_parent_id, content_id, ordering, text FROM content WHERE course_id=$course_select AND content_parent_id=0 ORDER BY ordering";
				$index_result = mysql_query($index);
				if ($index_result && mysql_num_rows($index_result) > 0) {
					$parent=array();
					$i=0;
					while ($index_row = mysql_fetch_row($index_result)){
						$index_con_id = $index_row[2];
						if ($index_row[0] != 'Welcome To klore') {
							echo '<tr><td class="row1"><input type="checkbox" id="a_'.$index_row[2].'" value="'.$index_row[2].'" name="parent['.$i++.']" onclick="CheckCheckAll();" /></td>';
							echo '<td class="row1"><strong><label for="a_'.$index_row[2].'">'.$index_row[0].'</label></strong></td></tr>'."\n";
							
							$index_sql = "SELECT title, text FROM content WHERE course_id=$course_select AND content_parent_id=$index_con_id ORDER BY ordering";
							$index_result2 = mysql_query($index_sql);
							while ($index_row2 = mysql_fetch_row($index_result2)){
								echo '<tr><td class="row1">&nbsp;</td><td class="row4"> - ';
								echo $index_row2[0];
								echo '</td></tr>';
							}

						}
						

					}
				}
				
				echo '</table>';
				echo '<div align="center"><input type="submit" name="print" class="button" value="'.$_template['select_display'].' Alt-s" accesskey="s" /></div>'."\n";
				echo '</form>'."\n";
				//echo '<tr><td class="row1"><input type="checkbox" value="SelectAll" id="all" title="select/unselect all" name="selectall" onclick="CheckAll();"/></td><td class="row1"> <b><label for="all">'.$_template['select_all'].'</label></b><input type="hidden" name="course_select" value="'.$course_select.'" /></td></tr>'."\n";

				//echo '</td></tr>';

				if(mysql_num_rows($index_result)==1){
				$infos[]=AT_INFOS_NO_CONTENT;
				print_infos($infos);
				}
			}
		}
	}
} 

require($_include_path.'footer.inc.php');
//require('$_include/footer.php');
?>
