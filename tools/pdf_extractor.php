<?php

$_include_path	='../include/';
	$_section = $_template['home'];
	require($_include_path.'vitals.inc.php');
	require($_include_path.'header.inc.php');
$course_select=$_SESSION[course_id];
$submit=1;
echo '<a name="top"></a>';
//====---------- PDF stuff
require_once dirname(__FILE__) . '/../include/html2pdf/PDFEncryptor.php';
require_once dirname(__FILE__) . '/../include/html2pdf/HTML_ToPDF.php';
//$lhref=dirname(__FILE__).'/tools/PDF-test';
$linkToPDFFull = $linkToPDF = dirname(__FILE__).'/'.str_replace(' ','_',$_SESSION['course_title']);
// remove the temporary file it creates
//if (is_file($linkToPDFFull)) unlink($linkToPDFFull);
// give it an extension
$linkToPDFFull .= '.pdf';
$linkToPDF .= '.pdf';
// make it web accessible

$linkToPDF = 'tools/'.basename($linkToPDF);

//====---------- ==========
if ($_POST['print']) {
				
				

print_feedback(AT_FEEDBACK_SUCCESS);
echo '<img src="../images/icons/ad-pdf.gif"> <a href="'.$linkToPDF.'">'.$_template['download_pdf'].'</a>';
ob_start();
}


?>
<html>
<head>
</head>

<body >
<?php
if ($print) {
	if(!$parent){
		$errors[]=AT_ERROR_CHOOSE_ONE_SECTION;
	}else{	
		/*echo '<p class="hide">';
			$help[]=AT_HELP_BROWSER_PRINT_BUTTON;
			print_help($help);
		echo '</p>';
		echo '<p class="hide">[<a href="'.$PHP_SELF.'?print=">Back to Content Selector</a>]</p>';*/
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
		if ($result= $db->query($sql)) {
			while ($myrow = $result->fetchRow()){
				$con_id = $myrow[2];
				$text = '../'.$myrow[4];
					$fh = fopen($text, 'r');  
					$chf_text = fread($fh, filesize($text));


					fflush($fh);
					fclose($fh);
				
				replace_icons($chf_text);
				if ($myrow[0] != 'Welcome To klore') {
					echo '<br /><br /><a name="'.$myrow[0].'"></a><h2>'.$myrow[0].'</h2><br />';
					echo $chf_text.'<br />';
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
	global $db;
		error_reporting(E_ERROR);
		$sql1 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id ORDER BY ordering";
		//echo '<br />'.$sql1;
		//echo "content/".$course_select;
		$result2 = $db->query($sql1);
		while ($myrow2 = $result2->fetchRow()){
			$con_id1=$myrow2[3];
			$text = '../'.$myrow2[1];
				$fh = fopen($text, 'r');  
				$chf_text = fread($fh, filesize($text));
				fflush($fh);
				fclose($fh);
			replace_icons($chf_text);
			echo '<br /><a name="'.$myrow2[0].'"></a><h3>'.$myrow2[0].'</h3><br />';
			echo $chf_text.'<br />';
			$sql3 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id1 ORDER BY ordering";
			$result3 = $db->query($sql3);
			while ($myrow3 = $result3->fetchRow()){
				$con_id2=$myrow3[3];
				$text = '../'.$myrow3[1];
					$fh = fopen($text, 'r');  
					$chf_text = fread($fh, filesize($text));
					fflush($fh);
					fclose($fh);
					
				replace_icons($chf_text);
				echo '<br /><a name="'.$myrow3[0].'"></a><h3>'.$myrow3[0].'</h3><br />';
				echo $chf_text.'<br />';
				$sql4 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id2 ORDER BY ordering";
				$result4 = $db->query($sql4);
				while ($myrow4 = $result4->fetchRow()){
					$con_id3=$myrow4[3];
					$text = '../'.$myrow4[1];
						$fh = fopen($text, 'r');  
						$chf_text = fread($fh, filesize($text));
						fflush($fh);
						fclose($fh);
					replace_icons($chf_text);
					echo '<br /><a name="'.$myrow4[0].'"></a><h3>'.$myrow4[0].'</h3><br />';
					echo $chf_text.'<br />';
					$sql5 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id3 ORDER BY ordering";
					$result5 = $db->query($sql5);
					while ($myrow5 = $result5->fetchRow()){
						$con_id4=$myrow5[3];
						$text = '../'.$myrow5[1];
						$fh = fopen($text, 'r');  
						$chf_text = fread($fh, filesize($text));
						fflush($fh);
						fclose($fh);
						replace_icons($chf_text);
						echo '<br /><a name="'.$myrow5[0].'"></a><h3>'.$myrow5[0].'</h3><br />';
						echo $chf_text.'<br /><!--NewPage-->';

					}
				}

			}

		}
}

function replace_icons($text){
	global $text;
	global $course_select;
	global $db;
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
	//print_help($help);
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
				echo '<tr><td class="row1"><input type="checkbox" checked value="SelectAll" id="all" title="select/unselect all" name="selectall" onclick="CheckAll();"/></td><td class="row1"> <b><label for="all">'.$_template['select_all'].'</label></b><input type="hidden" name="course_select" value="'.$course_select.'" /></td></tr>'."\n";

				$index = "SELECT title, content_parent_id, content_id, ordering, text FROM content WHERE course_id=$course_select AND content_parent_id=0 ORDER BY ordering";
				$index_result = $db->query($index);
				$countsql = "SELECT COUNT(*) FROM (".$sql.")";
				$countres = $db->query($countsql);
				$count = $countres->fetchRow();

				if ($index_result && $count[0] > 0) {
					$parent=array();
					$i=0;
					while ($index_row = $index_result->fetchRow()){
			
						$index_con_id = $index_row[2];
						if ($index_row[0] != 'Welcome To K-Lore') {
							echo '<tr><td class="row1"><input type="checkbox" checked id="a_'.$index_row[2].'" value="'.$index_row[2].'" name="parent['.$i++.']" onclick="CheckCheckAll(); /></td>';
							echo '<td class="row1"><strong><label for="a_'.$index_row[2].'">'.$index_row[0].'</label></strong></td></tr>'."\n";
							
							$index_sql = "SELECT title, text FROM content WHERE course_id=$course_select AND content_parent_id=$index_con_id ORDER BY ordering";
							$index_result2 = $db->query($index_sql);
							while ($index_row2 = $index_result2->fetchRow()){
								echo '<tr><td class="row1">&nbsp;</td><td class="row4"> - ';
								echo $index_row2[0];
								echo '</td></tr>';
							}

						}
						

					}
				}
				
				echo '</table>';
				echo '<div align="center"><input type="submit" name="print" class="button" value="'.$_template['export_pdf'].' Alt-s" accesskey="s" /></div>'."\n";
				echo '</form>'."\n";
				//echo '<tr><td class="row1"><input type="checkbox" value="SelectAll" id="all" title="select/unselect all" name="selectall" onclick="CheckAll();"/></td><td class="row1"> <b><label for="all">'.$_template['select_all'].'</label></b><input type="hidden" name="course_select" value="'.$course_select.'" /></td></tr>'."\n";

				//echo '</td></tr>';
				if($count[0]==0){
					$infos[]=AT_INFOS_NO_CONTENT;
					print_infos($infos);
				}
			}
		}
	}
} 


// tempoary HTML file name
$htmlFile = str_replace('.pdf', '.htm', $linkToPDFFull); 
$defaultDomain = '';//de skimbat?

if (!$_POST['print']) {
require($_include_path.'footer.inc.php');
exit;
}
//echo "</body>";

// write the buffered HTML file
$fp = fopen($htmlFile, 'w');
fwrite($fp,/*$_SESSION['buf']*/ob_get_contents());
fclose($fp);
//ob_end_clean();
ob_end_flush();
//session_unregister('buf');
//$_SESSION['buf']='';
$pdf =& new HTML_ToPDF($htmlFile, $defaultDomain);
// Example setup if running under windows:
// $pdf->setHtml2Ps('perl c:\html2ps\bin\html2ps');
// $pdf->setPs2Pdf('c:\ghostscript\bin\ps2pdf');
// Could turn on debugging to see what exactly is happening
// (commands being run, images being grabbed, etc.)
//$pdf->setDebug(true);
// convert the file
$result = $pdf->convert();

// check if the result was an error
if (PEAR::isError($result)) {
    die($result->getMessage());
}
else {
    // move the generated PDF to the web accessible file
    copy($result, $linkToPDFFull);
    unlink($result);
    // remove the temporary html file
    unlink($htmlFile);

    // Set up encryption
    $encryptor =& new PDFEncryptor($linkToPDFFull);
    // set paths
    $encryptor->setJavaPath('/usr/java/j2sdk1.4.1_02/bin/java');
    $encryptor->setITextPath(dirname(__FILE__) . '/../lib/itext-0.99.jar');
    // set meta-data
    $encryptor->setAuthor('Klore');
    //$encryptor->setKeywords('HTML_ToPDF, php, encryption of PDF');
    //$encryptor->setSubject('Example of HTML_ToPDF with Ecnryption');
    $encryptor->setTitle('Curs');
    // set permissions
    $encryptor->setAllowPrinting(true);
    $encryptor->setAllowModifyContents(false);
    $encryptor->setAllowDegradedPrinting(true);
    $encryptor->setAllowCopy(true);
    // set password
    //$encryptor->setUserPassword('foobar');
    // $encryptor->setOwnerPassword('barfoo');
    //$result = $encryptor->encrypt();
    if (PEAR::isError($result)) {
        die($result->getMessage());
    }
}
				
				


//echo "<a href=".$linkToPDF.">".$_template['download_pdf']."</a>";

require($_include_path.'footer.inc.php');
//require('$_include/footer.php');


/*

DEBUG: html2ps config: 
        @html2ps {
          
        option {
          titlepage: 0;         // do not generate a title page //
          toc: 0;               // no table of contents //
          colour: 1; /* create the page in color //
          underline: 1;        // underline links //
          grayscale: 0; // Make images grayscale? //
          scaledoc: 1; // Scale the document //
        }
        package {
          geturl: /usr/bin/curl -i; // path to the geturl //
        }
        showurl: 0;             // do not show the url next to links //
header {
  left: $T
  right: $[author]
  odd-left: $T
  even-left: $T
  odd-right: $[author]
  even-right: $[author]
}
footer {
  center: - $N -
  odd-center: - $N -
  even-center: - $N -
}
        }
        
@page {
  size: 8.5in 11in;
}
DEBUG: html2ps command run: /usr/bin/html2ps  -f /tmp/CONF-NjKloE -o /tmp/PS-JTmBCw /tmp/HTML-707GuA 2>&1DEBUG: html2ps output: Error in block 'option' in configuration file: unknown key 'titlepage'
Bareword found where operator expected at (eval 230) line 1, near "$@page"
	(Missing operator before page?)

*/
?>
