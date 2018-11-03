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
$_section[0][0] =  $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] =  $_template['custom_styles'];

$filenames = $_include_path.'../content/'.$_SESSION[course_id].'/stylesheet.css';

if($_POST['submit_file']=="Upload" && $_FILES['uploadedfile']['name']=='')	{
	$errors[]=AT_ERROR_FILE_NOT_SELECTED;

}else if($_FILES['uploadedfile']['name']!=''){
	$path_parts = pathinfo($_FILES['uploadedfile']['name']);
	$ext = strtolower($path_parts['extension']);
	if (in_array($ext, array("css"))) {
	//$errors[]=AT_ERROR_UNSUPPORTED_FILE;
	}else{
		$errors[]=AT_ERROR_CSS_ONLY;
	}

}
if($_POST['submit_file']=="Upload" && $_FILES['uploadedfile']['name']=='')	{
	$errors[]=AT_ERROR_FILE_NOT_SELECTED;

}else if ($_FILES['uploadedfile']['name'] &&  ($_FILES['uploadedfile']['type'] == 'text/css') )	{
		copy($_FILES['uploadedfile']['tmp_name'], $filenames);
		$ft=fopen($filenames,r);
		$this_style=fread($ft, filesize($filenames));
		$path_parts = pathinfo($filenames);
		$ext = strtolower($path_parts['extension']);
		if (in_array($ext, array('css'))) {
			/* strip everything before <body> */
			$start_pos	= strpos(strtolower($this_style), '<body');
			if ($start_pos !== false) {

				$start_pos	+= strlen('<body');
				$end_pos	= strpos(strtolower($this_style), '>', $start_pos);
				$end_pos	+= strlen('>');

				$this_style = substr($this_style, $end_pos);
			}

			/* strip everything after </body> */
			$end_pos	= strpos(strtolower($this_style), '</body>');
			if ($end_pos !== false) {
				$this_style = trim(substr($this_style, 0, $end_pos));
			}

			fwrite($ft, $this_style);
			fclose ($ft);
			$ft=fopen($filenames, w);
			fwrite($ft,$this_style);
			fclose($ft);
		} else {
			$errors[]=AT_ERROR_CSS_ONLY;

		}
	}
if($_POST['update']){
	//$filenames = $_include_path.'../content/'.$_SESSION[course_id].'/stylesheet.css';
	$fp = fopen ($filenames, w);
	$clean_styles=stripslashes($_POST['styles']);
	$clean_styles=trim($clean_styles);
	fwrite($fp, $clean_styles);
	fclose($fp);
	$feedback[]=AT_FEEDBACK_CSS_UPDATED;
	$feedback[]=AT_FEEDBACK_CSS_PREVIEW;

} 



if($_GET['copy']==1){
		$default_stylesheet = $_include_path.'../stylesheet.css';
		$fp = fopen ($default_stylesheet, r);
		$ft = fopen ($filenames , w);
		$this_style=fread($fp, filesize($default_stylesheet));
		$this_style=str_replace("images", "../../images",$this_style);
		fwrite($ft, $this_style);
		fclose($fp);
		fclose($ft);
		$feedback[]=AT_FEEDBACK_DEFAULT_CSS_LOADED;
}

//$onload = 'onLoad="document.form.styles.focus()"';
require($_include_path.'header.inc.php');
//echo $default_stylesheet;
//echo $_GET['copy'];
//echo $this_style;
//debug($submit);
?>
<h2><a href="tools/" class="hide" ><?php   echo $_template['tools'];  ?></a></h2>
<h3> <?php   echo $_template['style_editor'];  ?></h3>
<?
//$warnings[]=AT_WARNING_SAVE_YOUR_WORK;
$help[]=AT_HELP_EDIT_STYLES;
print_feedback($feedback);
print_errors($errors);
print_help($help);
print_warnings($warnings);  ?>
<p align="center">(<a href="frame.php?p=<?php echo urlencode($_my_uri); ?>"><?php   echo $_template['open_frame'];  ?></a> | <a href="<?php echo $PHP_SELF ?>?copy=1"><?php echo  $_template['load_default_css'];  ?></a>)</p>


<form action="<?php echo $PHP_SELF; ?>" method="post" name="form" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="204000" />
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
	<tr>
	<td colspan="2" class="cat"><label for="styles"><?php  echo  $_template['course_styles']; ?></label></td>
	</tr>
	<tr>
	<td align="right" class="row1" valign="top"><?php print_popup_help(AT_HELP_EDIT_STYLES_MINI); ?><b><?php  echo  $_template['paste_file']; ?>:</b></td>
	<td class="row1"><input type="file" name="uploadedfile" class="formfield" size="20" /> <input type="submit" name="submit_file" value="<?php  echo  $_template['upload']; ?>" class="button" /><br />
	<small class="spacer"><?php  echo  $_template['css_only']; ?><br />
	<?php  echo  $_template['edit_after_upload']; ?></small>
	</td>
	</tr>
	<tr><td colspan="2" align="center" class="row1">

	<textarea name="styles" rows="20" cols="50" class="formfield" id="styles"><?php
		if (file_exists($filenames)) {
			trim(readfile($filenames));
		}else{
			echo $_template['could_not_read'];
		}

	?></textarea>
	<input type="hidden" name="update" value="1" />
	<br />
	<input type="submit" value="<?php echo $_template['save_styles']; ?> Alt-s" accesskey="s" class="button"/>
	</td></tr>
	</table>
</form>
 
<?php
require($_include_path.'footer.inc.php');
?>
