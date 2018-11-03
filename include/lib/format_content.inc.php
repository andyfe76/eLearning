<?php

/* @See: ./index.php */

function format_content($input, $html = 0, $get='') {
	global $glossary, $learning_concept_tags, $_template;

	
	/* do the glossary search and replace: */
	foreach ($glossary as $k => $v) {
		// fix for replacing < with &lt; in glossary terms 
		if (is_alpha($k)) {
			$L = strtoupper(substr($k,0,1)); 
		} else {
			$L = 'Other';
		}
		$k = str_replace('&lt;', '<', $k);
		$k = str_replace('/', '\/', $k);

		$original_term = $k;
		$term = '(\s*'.$original_term.'\s*)';
		$term = str_replace(' ','((<br \/>)*\s*)', $term); 

		$def = $v;
		$input = preg_replace
						("/(\[\?\])$term(\[\/\?\])/i",

						'\\2<sup>[<a href="glossary/?L='.$L.SEP.'g=24#'.urlencode($original_term).'" onmouseover="return overlib(\''.$def.'\', CAPTION, \''.$_template['definition'].'\', AUTOSTATUS);" onmouseout="return nd();">?</a>]</sup>',

						$input);
		
		$input = str_replace('http://'.$_SERVER['HTTP_HOST'].'/klore/editor/glossary/?', 'glossary/?', $input);
		$input = str_replace('\"', '"', $input);
	}

	/* search and replace the learning concepts: */
	foreach ($learning_concept_tags as $tag => $concept) {
		if ($tag == 'link') {
			$input = str_replace('['.$tag.']','<a href="resources/links/"><img src="images/concepts/'.$concept['icon_name'].'" alt="'.$concept['title'].'" border="0" /></a>', $input);
		} else if ($tag == 'discussion') {
			$input = str_replace('['.$tag.']','<a href="forum/"><img src="images/concepts/'.$concept['icon_name'].'" alt="'.$concept['title'].'" border="0" /></a>', $input);
		} else {
			$input = str_replace('['.$tag.']','<img src="images/concepts/'.$concept['icon_name'].'" alt="'.$concept['title'].'" />', $input);
		}
	}

	$input = str_replace('CONTENT_DIR', 'content/'.$_SESSION['course_id'], $input);
	
	if ($get){
		if (!$html) {
			$input = str_replace('<', '&lt;', $input);
		} else {
			$input = str_replace("\`", "'", $input);
			$input = str_replace("`", "'", $input);
			// here we should remove absolute references to images. TBC
			$input = preg_replace('/(<a href=(\\\"|\")(?!glossary))/i', '<a target="_blank" href="', $input);
			$input = str_replace('\"', "\"", $input); 
		}
	} else {
		if (!$html) {
			$input = str_replace('<', '&lt;', $input);
		} else {
			$input = str_replace("'", "`", $input);
		}
	}	

	
	if (($get) && ($html)) {
		return format_final_output($input, false);
	}

	//$output = format_final_output($input);
	$output = $input;

	if (!$html) {
		$output = '<p>'.$output.'</p>';
	}

	return $output;
}
?>