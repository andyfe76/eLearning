<?php
$_include_path = '../include/';
$_ignore_page = true; /* used for the close the page option */
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/filemanager.inc.php');
if (!$_GET['f']) {
	$_SESSION['done'] = 0;
}
session_write_close();
$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['file_manager'];
$_section[1][1] = 'tools/file_manager.php';

$help[]=AT_HELP_FILEMANAGER2;
$help[]=AT_HELP_FILEMANAGER3;
$help[]=AT_HELP_FILEMANAGER4;

if ($_GET['frame'] == 1) {
	$_header_file = 'html/frameset/header.inc.php';
	$_footer_file = 'html/frameset/footer.inc.php';
} else {
	$_header_file = 'header.inc.php';
	$_footer_file = 'footer.inc.php';
}


$start_at = 2;

	$path = '../content/'.$_SESSION['course_id'].'/';
	$MakeDirOn = true;
	/* $MaxFileSize  and $MaxCourseSize are defined in vitals.inc.php */

	/* get this courses MaxQuota and MaxFileSize: */
	$sql	= "SELECT max_quota, max_file_size FROM courses WHERE course_id=$_SESSION[course_id]";
	$result = mysql_query($sql, $db);
	$row	= mysql_fetch_array($result);
	$MaxCourseSize	= $row['max_quota'];
	$MaxFileSize	= $row['max_file_size'];

	$MaxSubDirs  = 5;
	$MaxDirDepth = 3;

	if ($_GET['pathext'] != '') {
		$pathext = $_GET['pathext'];
	}

	if (strpos($pathext, '..') !== false) {
		require($_include_path.$_header_file);
		$errors[]=AT_ERROR_UNKNOWN;
		print_errors($errors);
		require($_include_path.$_footer_file);
		exit;
	}

	if($_GET['back'] == 1) {
		$pathext  = substr($pathext, 0, -1);
		$slashpos = strrpos($pathext, '/');
		if($slashpos == 0) {
			$pathext = '';
		} else {
			$pathext = substr($pathext, 0, ($slashpos+1));
		}
	}

	/* remove the forward or backwards slash from the path */
	$newpath = $path;
	$depth = substr_count($pathext, '/');

	if ($pathext != '') {
		$bits = explode('/', $pathext);
		$bits_path = $bits[0];

		for ($i=0; $i<count($bits)-2; $i++) {
			if ($bits_path != $bits[0]) {
				$bits_path .= '/'.$bits[$i];
			}
			$_section[$start_at][0] = $bits[$i];
			$_section[$start_at][1] = 'tools/file_manager.php?back=1'.SEP.'pathext='.$bits_path.'/'.$bits[$i+1].'/';

			$start_at++;
		}
		$_section[$start_at][0] = $bits[count($bits)-2];
	}

/* if upload successful, close the window */
if ($f) {
	$onload = 'onbeforeload="closeWindow(\'progWin\');"';
}

require($_include_path.$_header_file);

if (!$_SESSION['is_admin']) {
	$errors[]=AT_ERROR_ACCESS_DENIED;
	print_errors($errors);
	require($_include_path.$_footer_file);
	exit;
}

if ($_GET['frame']) {
	echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="cat2"></td></tr></table>';
	echo '<div align="center"><small>(<a href="close_frame.php" target="_top">'.$_template['close_frame'].'</a>)</small></div>';
}

?>
<?php
if($_GET['frame'] == 1){
	echo '<h2><a href="tools/" class="hide" target="content">'.$_template['tools'].'</a></h2>';
}else{
	echo '<h2><a href="tools/" class="hide" >'.$_template['tools'].'</a></h2>';

}

?>
	<h3><?php echo $_template['file_manager']; ?></h3>
<?php


	if ($_POST['mkdir'] && ($depth < $MaxDirDepth) ) {
		$_POST['dirname'] = trim($_POST['dirname']);
		$_POST['dirname'] = str_replace(' ', '_', $_POST['dirname']);

		/* anything else should be okay, since we're on *nix.. hopefully */
		$_POST['dirname'] = ereg_replace('[^a-z0-9._]', '', $_POST['dirname']);
		$dirname = $_POST['dirname'];
		$result = @mkdir($path.'/'.$pathext.$dirname, 0700);
		if($result == 0) {
			$errors[]=AT_ERROR_FOLDER_NOT_CREATED;
			print_errors($errors);
		}
	}


	if ($_GET['delete'] && !$_GET['d']) {
		if(is_dir($path.$pathext.$_GET['delete'])) {
			$warnings[]=array(AT_WARNING_CONFIRM_DIR_DELETE, $_GET['delete']);
		} else {
			$warnings[]=array(AT_WARNING_CONFIRM_FILE_DELETE, $_GET['delete']);
		}
		print_warnings($warnings);
		echo '<p><a href="tools/file_manager.php?delete='.$_GET['delete'].SEP.'pathext='.$_GET['pathext'].SEP.'d=1'.SEP.'frame='.$_GET[frame].'">'.$_template['yes_delete'].'</a>, <a href="tools/file_manager.php?pathext='.$_GET['pathext'].SEP.'frame='.$_GET[frame].'">'.$_template['no_cancel'].'</a></p>';
		require($_include_path.$_footer_file);
		exit;
	}


	$newpath = substr($path.$pathext, 0, -1);

	/* open the directory */
	if (!($dir = @opendir($newpath))) {
		$errors[] = AT_ERROR_CANNOT_OPEN_DIR;
		print_errors($errors);
		require($_include_path.$_footer_file);
		exit;
	}

	/* delete the file or empty directory */
	if (($_GET['delete'] != '') && ($_GET['d'])) {
		if(is_dir($path.$pathext.$_GET['delete'])) {
			
			if (strpos($_GET['delete'], '..') !== false) {
				$errors[]=$AT_ERROR_UNKNOWN;
				print_errors($errors);
				require($_include_path.$_footer_file);
				exit;
			}

			if (!($tempdir = @opendir($path.$pathext.$_GET['delete']))) {
				$errors[]=AT_ERROR_DIR_NOT_DELETED;
				print_errors($errors);
				require($_include_path.$_footer_file);
				exit;
			}
			
			/* check if this dir is empty or not */
			$count =0;
			while (false !== ($tempfile = @readdir($tempdir)) ) {
				$count++;
				if ($count > 2) {
					break;
				}
			}
			@closedir($tempdir);

			if ($count > 2) {
				$errors[]=AT_ERROR_DIR_NOT_EMPTY;
				print_errors($errors);
			} else {
				$result = @rmdir($path.$pathext.$_GET['delete']);
				if (!$result) {
					$errors[]=AT_ERROR_DIR_NO_PERMISSION;
					print_errors($errors);
				} else {
					$feedback[]=AT_FEEDBACK_DIR_DELETED;
					print_feedback($feedback);
				}
			}
		} else {
			@unlink($path.$pathext.$_GET['delete']);
			$feedback[]=AT_FEEDBACK_FILE_DELETED;
			print_feedback($feedback);
		}
	}

	if ($_GET['overwrite']) {
		// get file name, out of the full path
		$path_parts = pathinfo($path.$_GET['overwrite']);
		$pathext = substr($path_parts['dirname'], strlen($path));
		
		if (!file_exists($path_parts['dirname'].'/'.$path_parts['basename']) 
			|| !file_exists($path_parts['dirname'].'/'.substr($path_parts['basename'], 5))) {
		
			/* source and/or destination does not exist */
			$errors[]	= AT_ERROR_CANNOT_OVERWRITE_FILE;
			print_errors($errors);
		} else {
			$result = @rename(	$path_parts['dirname'].'/'.$path_parts['basename'],
								$path_parts['dirname'].'/'.substr($path_parts['basename'], 5));

			if ($result) {
				$feedback[] = AT_FEEDBACK_FILE_OVERWRITE;
				print_feedback($feedback);
			} else {
				$errors[]	= AT_ERROR_CANNOT_OVERWRITE_FILE;
				print_errors($errors);
			}
		}
		$pathext .= '/';
	}


	if ($_GET['frame'] != 1) {
		print_help($help);
	}
	echo '<form name="form1" method="post" action="'.$PHP_SELF.'?frame='.$_GET[frame].'" enctype="multipart/form-data">';
	if( $MakeDirOn ) {
		if ($depth < $MaxDirDepth) {
			echo '<input type="text" name="dirname" size="20" class="formfield" /> ';
			echo '<input type="submit" name="mkdir" value="'.$_template['create_folder'].'" class="button" /><br /><small class="spacer">'.$_template['keep_it_short'].'</small>';
		} else {
			echo $_template['depth_reached'];
		}
	}
	echo '<input type="hidden" name="pathext" value="'.$pathext.'" />';
	echo '</form>';

	echo '<form onsubmit="openWindow(\''.$_base_href.'tools/prog.php\');" name="form1" method="post" action="tools/upload.php?frame='.$_GET[frame].'" enctype="multipart/form-data">';
	echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.$MaxFileSize.'" />';
	echo '<br />';
	echo '<input type="file" name="uploadedfile" class="formfield" size="20" />';

	echo ' <input type="submit" name="submit" value="'.$_template['upload'].'" class="button" />';
	echo '<input type="hidden" name="pathext" value="'.$pathext.'" />';
	echo '</form>';
	echo '<hr />';
	if ($_GET['frame'] != 1) {
		echo '<p><a href="frame.php?p='.urlencode($_my_uri).'">'.$_template['open_frame'].'</a>.</p>';
		echo '<p>'.$_template['current_path'].' ';
	}
	echo '<small>';
	?>
<script type="javascript">
function openWindow(page) {
	newWindow = window.open(page, "progWin", "width=400,height=200,toolbar=no,location=no");
	newWindow.focus();
}
	</script>
	<?php
	
	echo '<a href="'.$PHP_SELF.'?frame='.$_GET[frame].'">CONTENT_DIR</a> / ';
	if ($pathext != '') {
		$bits = explode('/', $pathext);
		$bits_path = $bits[0];
		for ($i=0; $i<count($bits)-2; $i++) {
			if ($bits_path != $bits[0]) {
				$bits_path .= '/'.$bits[$i];
			}
			echo '<a href="'.$PHP_SELF.'?back=1'.SEP.'pathext='.$bits_path.'/'.$bits[$i+1].'/'.SEP.'frame='.$_GET[frame].'">'.$bits[$i].'</a>';
			echo ' / ';
		}
		echo $bits[count($bits)-2];
	}

	echo '</small>';

	echo '</p><br /><table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">';
	echo '<tr>
			<th><small>';
			if($_GET['frame']){
				print_popup_help(AT_HELP_FILEMANAGER1);
			}else{
				print_popup_help(AT_HELP_FILEMANAGER);
			}

			echo '&nbsp;</small></th>
			<th><small>'.$_template['name'].'</small></th>';
	if ($_GET['frame'] != 1) {
		echo '<th><small>'.$_template['size'].'</small></th>';
		echo '<th><small>'.$_template['date'].'</small></th>';
		echo '<th><small>&nbsp;</small></th>';
	}
	echo '</tr>';

	/* if the current directory is a sub directory show a back link to get back to the previous directory */
	if($pathext) {
		echo '<tr><td class="row1" colspan="5"><a href="'.$PHP_SELF.'?back=1'.SEP.'pathext='.$pathext.SEP.'frame='.$_GET[frame].'"><img src="images/arrowicon.gif" border="0" /> '.$_template['back'].'</a></td></tr>';

		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
	}


	$totalBytes = 0;
	while (false !== ($file = readdir($dir)) ) {

		/* if the name is not a directory */
		if( ($file == '.') || ($file == '..') ) {
			continue;
		}

		/* get some info about the file */
		$filedata = stat($path.$pathext.'/'.$file);

		/* create some html for a link to delete files */
		$deletelink = '<a href="'.$PHP_SELF.'?delete='.$file.SEP.'pathext='.$pathext.SEP.'frame='.$_GET[frame].'"><img src="images/icon_delete.gif" border="0" alt="'.$_template['delete'].'" /></a>';
	
		/* if it is a directory change the file name to a directory link */
		$path_parts = pathinfo($file);
		$ext = $path_parts['extension'];

		$is_dir = false;

		if(is_dir($path.$pathext.$file)) {

			$filename = '<small><a href="'.$PHP_SELF.'?pathext='.$pathext.$file.'/'.SEP.'frame='.$_GET[frame].'">'.$file.'</a></small>';
			$fileicon = '<small>&nbsp;<img src="images/folder.gif" alt="'.$_template['folder'].'" />&nbsp;<small>';
			if(!$MakeDirOn) {
				$deletelink = '';
			}

			$is_dir = true;
		} else if ($ext == 'zip') {

			$totalBytes += $filedata[7];
			$filename = $file;
			$fileicon = '<small>&nbsp;<img src="images/icon-zip.gif" alt="'.$_template['zip_archive'].'" height="16" width="16" border="0" />&nbsp;</small>';

		} else {
			$totalBytes += $filedata[7];
			$filename = $file;
			$fileicon = '<small>&nbsp;<img src="images/icon_minipost.gif" alt="'.$_template['file'].'" height="11" width="16" />&nbsp;</small>';
		}

		if ($is_dir) {
			$dirs[strtolower($file)] .= '<tr>
				<td class="row1" align="center"><small>'.$fileicon.'</small></td>
				<td class="row1"><small>&nbsp;<a href="content/'.$_SESSION[course_id].'/'.$pathext.urlencode($filename).'">'.$filename.'</a>&nbsp;</small></td>';

				if ($_GET['frame'] != 1) {
					$dirs[strtolower($file)] .= '<td class="row1" align="right"><small>'.number_format($filedata[7]/AT_KBYTE_SIZE, 2).' KB&nbsp;</small></td>';
					$dirs[strtolower($file)] .= '<td class="row1"><small>&nbsp;';

					$dirs[strtolower($file)] .= AT_date($_SESSION['lang'], $_template['filemanager_date_format'], $filedata[10], AT_UNIX_TIMESTAMP);

					$dirs[strtolower($file)] .= '&nbsp;</small></td>
					<td class="row1"><small>&nbsp;'.$deletelink.'&nbsp;</small></td>';
				}

				$dirs[strtolower($file)] .= '</tr>
				<tr>
				<td height="1" class="row2" colspan="5"></td>
				</tr>';
		} else {
			$files[strtolower($file)] .= '<tr>
				<td class="row1" align="center"><small>'.$fileicon.'</small></td>
				<td class="row1"><small>&nbsp;<a href="content/'.$_SESSION[course_id].'/'.$pathext.urlencode($filename).'">'.$filename.'</a>';

				if (($ext == 'zip') && (!$_GET['frame'])) {
					$files[strtolower($file)] .= ' <a href="tools/zip.php?pathext='.$pathext.$file.SEP.'frame='.$_GET[frame].'">';
					$files[strtolower($file)] .= '<img src="images/archive.gif" border="0" alt="'.$_template['extract_archive'].'" height="16" width="11" />';
					$files[strtolower($file)] .= '</a>';
				}
				$files[strtolower($file)] .= '&nbsp;</small></td>';

				if ($_GET['frame'] != 1) {
					$files[strtolower($file)] .= '<td class="row1" align="right"><small>'.number_format($filedata[7]/AT_KBYTE_SIZE, 2).' KB&nbsp;</small></td>';
					$files[strtolower($file)] .= '<td class="row1"><small>&nbsp;';
					
					$files[strtolower($file)] .= AT_date($_SESSION['lang'], $_template['filemanager_date_format'], $filedata[10], AT_UNIX_TIMESTAMP);

					$files[strtolower($file)] .= '&nbsp;</small></td>
					<td class="row1"><small>&nbsp;'.$deletelink.'&nbsp;</small></td>';
				}
				$files[strtolower($file)] .= '</tr>
				<tr>
				<td height="1" class="row2" colspan="5"></td>
				</tr>';
		}
	}

	if (is_array($dirs)) {
		ksort($dirs, SORT_STRING);
		foreach($dirs as $x => $y) {
			echo $y;
		}
	}

	if (is_array($files)) {
		ksort($files, SORT_STRING);
		foreach($files as $x => $y) {
			echo $y;
		}
	}


	if ($_GET['frame'] != 1) {
		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

		echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['directory_total'].':</b><br /><br /></small></td><td align="right" class="row1"><small>&nbsp;<b>'.number_format($totalBytes/AT_KBYTE_SIZE, 2).'</b> KB&nbsp;<br /><br /></small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';

		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';
		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

		$course_total = dirsize($path);

		echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['course_total'].':</b></small></td><td align="right" class="row1"><small>&nbsp;<b>'.number_format($course_total/AT_KBYTE_SIZE, 2).'</b> KB&nbsp;</small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';

		echo '<tr><td height="1" class="row2" colspan="5"></td></tr>';

		echo '<tr><td class="row1" colspan="2" align="right"><small><b>'.$_template['course_available'].':</b></small></td><td align="right" class="row1"><small>&nbsp;<b>';
		if ($MaxCourseSize == -1 ) {
			echo $_template['unlimited_2'];
		} else {
			echo number_format(($MaxCourseSize-$course_total)/AT_KBYTE_SIZE, 2);
		}
		echo '</b> KB&nbsp;</small></td><td class="row1" colspan="2"><small>&nbsp;</small></td></tr>';
	}
	echo '</table>';
	closedir($dir);


?>
<?php
	require($_include_path.$_footer_file);
?>
