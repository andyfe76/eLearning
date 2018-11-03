<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

//This function only extracts 4 levels of content
function get_children($con_id){
	//global $i;
	global $text;
	global $con_id;
	global $course_select;
	global $db;
		$sql1 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id ORDER BY ordering";
		//echo '<br />'.$sql1;
		//echo "content/".$course_select;
		$result2 = $db->query($sql1);
		while ($myrow2 = $result2->fetchRow()){
			$con_id1=$myrow2[3];
			$text = $myrow2[1];
			$text = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $text);
			$text = str_replace('\"', "\"", $text); 
			$text = str_replace('\`', "'", $text);
			$text = str_replace('/glossary/?', 'glossary/?', $text);

			replace_icons($text);
			echo '<br /><a name="'.$myrow2[0].'"></a><h3>'.$myrow2[0].'</h3><br />';
			echo $text.'<br />';
			$sql3 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id1 ORDER BY ordering";
			$result3 = $db->query($sql3);
			while ($myrow3 = $result3->fetchRow()){
				$con_id2=$myrow3[3];
				$text = $myrow3[1];
				$text = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $text);
				$text = str_replace('\"', "\"", $text); 
				$text = str_replace('\`', "'", $text);
				$text = str_replace('/glossary/?', 'glossary/?', $text);

				replace_icons($text);
				echo '<br /><a name="'.$myrow3[0].'"></a><h3>'.$myrow3[0].'</h3><br />';
				echo $text.'<br />';
				$sql4 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id2 ORDER BY ordering";
				$result4 = $db->query($sql4);
				while ($myrow4 = $result4->fetchRow()){
					$con_id3=$myrow4[3];
					$text = $myrow4[1];
					$text = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $text);
					$text = str_replace('\"', "\"", $text); 
					$text = str_replace('\`', "'", $text);
					$text = str_replace('/glossary/?', 'glossary/?', $text);

					replace_icons($text);
					echo '<br /><a name="'.$myrow4[0].'"></a><h3>'.$myrow4[0].'</h3><br />';
					echo $text.'<br />';
					$sql5 = "SELECT title, text, content_parent_id, content_id FROM content WHERE content_parent_id = $con_id3 ORDER BY ordering";
					$result5 = $db->query($sql5);
					while ($myrow5 = $result5->fetchRow()){
						$con_id4=$myrow5[3];
						$text = $myrow5[1];
						$text = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $text);
						$text = str_replace('\"', "\"", $text); 
						$text = str_replace('\`', "'", $text);
						$text = str_replace('/glossary/?', 'glossary/?', $text);
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

	$course = intval($_GET['course']);
	
	if ($_POST['cancel']) {
		Header('Location: index.php?f='.AT_FEEDBACK_EXPORT_CANCELLED);
		exit;
	}

	if ($course == 0) {
		$course = intval($_POST['course']);
	}

	$sql = "SELECT title FROM courses WHERE course_id=$course";
	$res = $db->query($sql);
	$row2 = $res->fetchRow(DB_FETCHMODE_ASSOC);

	$row2['TITLE'] = str_replace(' ',  '_', $row2['TITLE']);
	$row2['TITLE'] = str_replace('%',  '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('\'', '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('"',  '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('`',  '',  $row2['TITLE']);

	/* check if ../content/export/ exists */
	/*if (!is_dir('../content/export/')) {
		if (!@mkdir('../content/export', 0700)) {
			$errors[]=AT_ERROR_EXPORTDIR_FAILED;
			print_errors($errors);
			exit;
		}
	} */
	
		$index = "SELECT title, content_parent_id, content_id FROM content WHERE course_id=$course AND content_parent_id=0 ORDER BY ordering";
		$res = $db->query($index);
		$countsql = "SELECT COUNT(*) FROM (".$index.")";
		$countres = $db->query($countsql);
		$count = $countres->fetchRow();
		
		$sql = "SELECT title, content_parent_id, content_id, ordering, text FROM content WHERE  ";
		$i=0;	
		if ($res && $count[0] > 0) {
			$parent=array();
			$i=0;
			while ( $index_row = $res->fetchRow() ) {
				$value = $index_row[2];
				if($i==0){
					$sql.= ' content_id='.$value.' ';
				}else{
					$sql.= ' OR content_id='.$value.' ';
				}
				$i++;
			}
		} else {
			print_errors('Error getting content.');
			exit;
		}
		$sql.=' ORDER BY ordering';
		
		if ($result= $db->query($sql)) {

			$htmlFile = '../content/export/html_'.$course.'_'.$_SESSION['member_id'].'.html';
			ob_start();
			while ($myrow = $result->fetchRow()){
				$con_id = $myrow[2];
				$text = $myrow[4];
				$text = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $text);
				$text = str_replace('\"', "\"", $text); 
				$text = str_replace('\`', "'", $text);
				$text = str_replace('/glossary/?', 'glossary/?', $text);
				replace_icons($text);
				if ($myrow[0] != 'Welcome To klore') {
					echo '<br /><br /><a name="'.$myrow[0].'"></a><h2>'.$myrow[0].'</h2><br />';
					echo $text.'<br />';
					//echo '&nbsp;<a href="#top">top</a><br />';
				}
				get_children($con_id);
				echo '<hr />';
			}
			$fp = fopen($htmlFile, 'w');
			fwrite($fp, ob_get_contents());
			fclose($fp);
			//ob_end_flush();
		} else {
			$errors[]=AT_ERROR_NO_COURSE_CONTENT;
		}
	
	require_once($_include_path.'html2pdf/HTML_ToPDF.php');
	$html_file = '../content/export/html_'.$course.'_'.$_SESSION['member_id'].'.html';
	$default_domain = 'site.com';
	$pdf_file = '../content/export/pdf_'.$course.'_'.$_SESSION['member_id'].'.pdf';
	@unlink($pdf_file);
	
	// Instantiate the class with our variables
	$pdf =& new HTML_ToPDF($htmlFile, $defaultDomain, $pdfFile);
	
	// Set headers/footers
	$pdf->setHeader('color', 'blue');
	$pdf->setFooter('left', 'K-Lore Learning Management System');
	$pdf->setFooter('right', '$D');
	$result = $pdf->convert();
	
	// Check if the result was an error
	if (PEAR::isError($result)) {
		die($result->getMessage());
	}
	else {
		//echo "PDF file created successfully.";
		//echo '<br />Click <a href="' . basename($result) . '">here</a> to view the PDF file.';
		Header('Location: '.$result);
	}
	
	@unlink($html_file);
	@unlink($pdf_file);

	



?>
