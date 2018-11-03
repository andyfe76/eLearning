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
require($_include_path.'lib/filemanager.inc.php');

/* $MaxFileSize  and $MaxCourseSize are defined in vitals.inc.php */

/* get this courses MaxQuota and MaxFileSize: */
$sql	= "SELECT max_quota, max_file_size FROM courses WHERE course_id=$_SESSION[course_id]";
$result = mysql_query($sql, $db);
$row	= mysql_fetch_array($result);
$MaxCourseSize	= $row['max_quota'];
$MaxFileSize	= $row['max_file_size'];

$_section[0][0] = 'Tools';
$_section[0][1] = 'tools/';

$_section[1][0] = 'File Manager';


if ($_GET['frame'] == 1) {
	$_header_file = 'html/frameset/header.inc.php';
	$_footer_file = 'html/frameset/footer.inc.php';
} else {
	$_header_file = 'header.inc.php';
	$_footer_file = 'footer.inc.php';
}

$path = '../content/'.$_SESSION['course_id'].'/'.$_POST['pathext'];

if ($_POST['submit']) {
	if($_FILES['uploadedfile']['name'])	{


		$_FILES['uploadedfile']['name'] = trim($_FILES['uploadedfile']['name']);
		$_FILES['uploadedfile']['name'] = str_replace(' ', '_', $_FILES['uploadedfile']['name']);

		$path_parts = pathinfo($_FILES['uploadedfile']['name']);
		$ext = $path_parts['extension'];

		/* check if this file extension is allowed: */
		/* $IllegalExtentions is defined in ./include/config.inc.php */
		if (in_array($ext, $IllegalExtentions)) {
			require($_include_path.$_header_file);
			$errors[] = array(AT_ERROR_FILE_ILLEGAL, $ext);
			print_errors($errors);
			echo '<a href="tools/file_manager.php?frame='.$_GET['frame'].'">Back</a>.';
			require($_include_path.$_footer_file);
			exit;
		}

		/* also have to handle the 'application/x-zip-compressed'  case	*/
		if (($_FILES['uploadedfile']['type'] == 'application/x-zip-compressed')
			|| ($_FILES['uploadedfile']['type'] == 'application/zip')){
			$is_zip = true;						
		}

	
		/* anything else should be okay, since we're on *nix.. hopefully */
		$_FILES['uploadedfile']['name'] = ereg_replace("[^A-Za-z0-9._]", '', $_FILES['uploadedfile']['name']);

		/* if the file size is within allowed limits */
		if( ($_FILES['uploadedfile']['size'] > 0) && ($_FILES['uploadedfile']['size'] <= $MaxFileSize) ) {

			/* if adding the file will not exceed the maximum allowed total */
			$course_total = dirsize($path);
			if ((($course_total + $_FILES['uploadedfile']['size']) <= $MaxCourseSize) || ($MaxCourseSize == -1)) {

				/* check if this file exists first */
				if (file_exists($path.$_FILES['uploadedfile']['name'])) {
					/* this file already exists, so we want to prompt for override */

					/* save it somewhere else, temporarily first			*/
					/* file_name.time ? */
					$_FILES['uploadedfile']['name'] = substr(time(), -4).'.'.$_FILES['uploadedfile']['name'];

					$f[] = array(	AT_FEEDBACK_FILE_EXISTS,
									substr($_FILES['uploadedfile']['name'], 5), 
									$_FILES['uploadedfile']['name'],
									$_POST['pathext']);
				}

				/* copy the file in the directory */
				$result = move_uploaded_file(	$_FILES['uploadedfile']['tmp_name'], 			
												$path.$_FILES['uploadedfile']['name'] );
				if (!$result) {
					require($_include_path.$_header_file);
					$errors[] = AT_ERROR_FILE_NOT_SAVED;
					print_errors($errors);
					echo '<a href="tools/file_manager.php?frame='.$_GET['frame'].'">Back</a>.';
					require($_include_path.$_footer_file);
					exit;
				} else {
					if ($is_zip) {
						$f[] = array(	AT_FEEDBACK_FILE_UPLOADED_ZIP,
										$_POST['pathext'].$_FILES['uploadedfile']['name'], 
										$_GET['frame']);
						
						$_SESSION['done'] = 1;
						Header('Location: ./file_manager.php?pathext='
								.$_POST['pathext']
								.SEP.'frame='.$_GET[frame]
								.SEP.'f='.urlencode_feedback($f));
						exit;

					} /* else */

					$f[] = AT_FEEDBACK_FILE_UPLOADED;

					$_SESSION['done'] = 1;
					Header('Location: ./file_manager.php?pathext='.
							$_POST['pathext']
							.SEP.'frame='.$_GET['frame']
							.SEP.'f='.urlencode_feedback($f));
					exit;
				}
			} else {
				$_SESSION['done'] = 1;
				require($_include_path.$_header_file);
				$errors[]=array(AT_ERROR_MAX_STORAGE_EXCEEDED,'('.$MaxCourseSize.' Bytes)');
				print_errors($errors);
				echo '<a href="tools/file_manager.php?frame='.$_GET['frame'].'">Back</a>.';
				require($_include_path.$_footer_file);
				exit;
			}
		} else {
			$_SESSION['done'] = 1;
			require($_include_path.$_header_file);
			$errors[]=array(AT_ERROR_FILE_TOO_BIG,'('.$MaxFileSize.' Bytes)');
			print_errors($errors);
			echo '<a href="tools/file_manager.php?frame='.$_GET['frame'].'">Back</a>.';
			require($_include_path.$_footer_file);
			exit;
		}
	} else {
		$_SESSION['done'] = 1;
		require($_include_path.$_header_file);
		$errors[]=AT_ERROR_FILE_NOT_SELECTED;
		print_errors($errors);
		echo '<a href="tools/file_manager.php?frame='.$_GET['frame'].'">Back</a>.';
		require($_include_path.$_footer_file);
		exit;
	}
}


?>