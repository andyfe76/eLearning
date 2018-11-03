<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

$_include_path = '../include/';
$_ignore_page = true; /* used for the close the page option */
require($_include_path.'vitals.inc.php');
require($_include_path.'classes/pclzip.lib.php');
require($_include_path.'lib/filemanager.inc.php');
session_write_close();
$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['file_manager'];
$_section[1][1] = 'tools/file_manager.php';
$_section[2][0] = $_template['zip_manager'];


if ($_POST['cancel']) {
	Header('Location: file_manager.php?frame='.$_POST['frame']);
	exit;
}

	$path = '../content/'.$_SESSION['course_id'].'/';

	if ($_REQUEST['pathext'] != '') {
		$pathext = $_REQUEST['pathext'];
	}

	if (strpos($pathext, '..') !== false) {
		require($_include_path.'header.inc.php');
		$errors[]=AT_ERROR_UNKNOWN;
		print_errors($errors);
		require($_include_path.'footer.inc.php');
		exit;
	}

	$path_parts = pathinfo($file.$pathext);
	
	$temp_name = substr($pathext, 0, -strlen('.'.$path_parts['extension']));

	$zip = new PclZip($path.$pathext);

	if (($list = $zip->listContent()) == 0) {
		die("Error : ".$zip->errorInfo(true));
	}

/*****************************************************************/
	$totalBytes = 0;
	$translated_file_names = array();

	for ($i=0; $i<sizeof($list); $i++) {
		$path_parts = pathinfo($list[$i]['stored_filename']);
		if ($path_parts['dirname'] == '.') {
			$path_parts['dirname'] = '';
		} else {
			$path_parts['dirname'] .= '/';
		}
		$ext = $path_parts['extension'];

		$is_dir = false;
		if($list[$i]['folder']) {

			$filename = $list[$i]['stored_filename'];
			$fileicon = '&nbsp;<img src="images/folder.gif" alt="'.$_template['folder'].'" />&nbsp;';

			$is_dir = true;

		} else if ($ext == 'zip') {

			$totalBytes += $list[$i]['size'];
			$filename = $list[$i]['stored_filename'];
			$fileicon = '&nbsp;<img src="images/icon-zip.gif" alt="'.$_template['zip_archive'].'" height="16" width="16" border="0" />&nbsp;';

		} else {
			$totalBytes += $list[$i]['size'];
			$filename = $list[$i]['stored_filename'];
			$fileicon = '&nbsp;<img src="images/icon_minipost.gif" alt="'.$_template['file'].'" height="11" width="16" />&nbsp;';
		}
		
		if ($is_dir) {
			$dirs[strtolower($filename)] .= '<tr>
				<td class="row1" align="center">'.$fileicon.'</td>
				<td class="row1"><small>&nbsp;'.$filename.'&nbsp;</small></td>';

				$dirs[strtolower($filename)] .= '<td class="row1" align="right"><small>'.number_format($list[$i]['size']/AT_KBYTE_SIZE, 2).' KB&nbsp;</small></td>';
				$dirs[strtolower($filename)] .= '<td class="row1"><small>&nbsp;';
				
				$dirs[strtolower($filename)] .= AT_date($_SESSION['lang'], $_template['filemanager_date_format'], $filedata[10], AT_UNIX_TIMESTAMP);
					
				$dirs[strtolower($filename)] .= '&nbsp;</small></td>';

				$dirs[strtolower($filename)] .= '</tr>
				<tr>
				<td height="1" class="row2" colspan="5"></td>
				</tr>';
		} else {

			$files[strtolower($filename)] .= '<tr>
				<td class="row1" align="center">'.$fileicon.'</td>
				<td class="row1"><small>&nbsp;';

				if (in_array($ext, $IllegalExtentions)) {
					$files[strtolower($filename)] .=  '<span style="text-decoration: line-through;" title="'.$_template['illegal_file'].'">'.$filename.'</span>';
				} else {
					$files[strtolower($filename)] .= $filename;
					
					$trans_name = str_replace(' ', '_', $path_parts['basename']);
					$trans_name = ereg_replace("[^A-Za-z0-9._]", '', $trans_name);

					if (in_array($path_parts['dirname'].$trans_name, $translated_file_names)) {
						$trans_count = 2;
						while (in_array($trans_name, $translated_file_names)) {
							$part = substr($trans_name, 0, -strlen($ext)- 1 - (2*($trans_count-2)));
							$trans_name = $part.'_'.$trans_count.'.'.$ext;
							$trans_count++;
							if ($trans_count>15){
								exit; // INF loop safety thing..
							}
						}
					}
					
					$translated_file_names[$list[$i]['index']] = $path_parts['dirname'].$trans_name;

					if ($path_parts['dirname'].$trans_name != $filename) {
						$files[strtolower($filename)] .= ' => '.$trans_name;
					}
					
				}
					
				$files[strtolower($filename)] .= '&nbsp;</small></td>';

				$files[strtolower($filename)] .= '<td class="row1" align="right"><small>'.number_format($list[$i]['size']/AT_KBYTE_SIZE, 2).' KB&nbsp;</small></td>';
				$files[strtolower($filename)] .= '<td class="row1"><small>&nbsp;';
				
				$files[strtolower($filename)] .= AT_date($_SESSION['lang'], $_template['filemanager_date_format'], $list[$i]['mtime'], AT_UNIX_TIMESTAMP);
					
				$files[strtolower($filename)] .= '&nbsp;</small></td>';
		
				$files[strtolower($filename)] .= '</tr>
				<tr>
				<td height="1" class="row2" colspan="5"></td>
				</tr>';
		}
	}

	$course_total = dirsize($path);
	$total_after = number_format(($MaxCourseSize-$course_total-$totalBytes)/AT_KBYTE_SIZE, 2);

	if ($_POST['submit'] && ($total_after > 0)) {
		$_POST['custom_path'] = trim($_POST['custom_path']);
		$_POST['custom_path'] = str_replace(' ', '_', $_POST['custom_path']);

		/* anything else should be okay, since we're on *nix.. hopefully */
		$_POST['custom_path'] = ereg_replace('[^a-zA-Z0-9._/]', '', $_POST['custom_path']);

		if ($zip->extract(	PCLZIP_OPT_PATH,		$path.$_POST['custom_path'],  
							PCLZIP_CB_PRE_EXTRACT,	'preExtractCallBack')			== 0) {

			echo ("Error : ".$zip->errorInfo(true));
		} else {
			$feedback[] = AT_FEEDBACK_ARCHIVE_EXTRACTED;
			Header('Location: ./file_manager.php?frame='.$_GET[frame].SEP.'f='.urlencode_feedback($feedback));
			exit;
		}

		require($_include_path.'footer.inc.php');
		exit;
	}

	require($_include_path.'header.inc.php');

?>
	<h2><a href="tools/" class="hide" ><?php echo $_template['tools']; ?></a></h2>
	<h3><a href="tools/file_manager.php"><?php echo $_template['file_manager']; ?></a></h3>
	<h3><?php echo $_template['zip_file_manager']; ?></h3>
<br />
	<p>The contents of this archive are listed below. Illegal file types will not be extracted, and file names containing illegal characters will be translated.</p>
<?php

	if ($total_after <= 0) {
		$error[] = AT_ERROR_NO_SPACE_LEFT;
		print_errors($error);
	} else {

?>
	<form method="post" action="tools/zip.php">
	<input type="hidden" name="pathext" value="<?php echo $_REQUEST['pathext']; ?>" />
	<input type="hidden" name="frame" value="<?php echo $_REQUEST['frame']; ?>" />
	<p><?php echo $_template['directory_name']; ?>: <input type="text" name="custom_path" value="<?php echo $temp_name; ?>" class="formfield" />
		<input type="submit" name="submit" value="<?php echo $_template['extract']; ?>" class="button" /> -
		<input type="submit" name="cancel" value="<?php echo $_template['cancel']; ?>" class="button" /><br />
		<small><?php echo $_template['extract_tip']; ?></small>
	</p>
	</form>
<?php
	} // end if

	

	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">';
	echo '<tr>
			<th>';
	echo '<small>&nbsp;</small></th>
	<th><small>'.$_template['name'].'</small></th>';
	echo '<th><small>'.$_template['size'].'</small></th>';
	echo '<th><small>'.$_template['date'].'</small></th>';

	echo '</tr>';
	if (is_array($dirs)) {
		foreach($dirs as $x => $y) {
			echo $y;
		}
	}

	if (is_array($files)) {
		foreach($files as $x => $y) {
			echo $y;
		}
	}

	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

	echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['archive_total'].':</b><br /><br /></small></td><td align="right" class="row1"><small>&nbsp;<b>'.number_format($totalBytes/AT_KBYTE_SIZE, 2).'</b> KB&nbsp;<br /><br /></small></td><td class="row1" colspan="2">&nbsp;</td></tr>';

	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';


	echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['course_total_zip'].':</b></small></td><td align="right" class="row1"><small>&nbsp;<b>'.number_format($course_total/AT_KBYTE_SIZE, 2).'</b> KB&nbsp;</small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';

	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

	echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['course_available_zip1'].':</b></small></td><td align="right" class="row1"><small>&nbsp;<b>';
	if ($MaxCourseSize == -1 ) {
		echo 'Unlimited';	
	} else {
		echo number_format(($MaxCourseSize-$course_total)/AT_KBYTE_SIZE, 2);
	}
	echo '</b> KB&nbsp;</small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';


	echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

	echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['course_available_zip2'].':</b></small></td><td align="right" class="row1"><small>&nbsp;<b>';
	if ($MaxCourseSize == -1 ) {
		echo 'Unlimited';	
	} else {
		if ($total_after <= 0) {
			echo '<span style="color: red;">';
			echo $total_after;
			echo '</span>';
		} else {
			echo $total_after;
		}

	}
	echo '</b> KB&nbsp;</small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';


	echo '</table>';

	require($_include_path.'footer.inc.php');
?>