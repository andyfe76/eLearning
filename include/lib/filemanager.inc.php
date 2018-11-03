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

// Enables deletion of directory if not empty
function clr_dir($dir) {
	if(!$opendir = @opendir($dir)) {
		return false;
	}
	
	while(($readdir=readdir($opendir)) !== false) {
		if (($readdir !== '..') && ($readdir !== '.')) {
			$readdir = trim($readdir);

			clearstatcache(); /* especially needed for Windows machines: */

			if (is_file($dir.'/'.$readdir)) {
				if(!@unlink($dir.'/'.$readdir)) {
					return false;
				}
			} else if (is_dir($dir.'/'.$readdir)) {
				/* calls itself to clear subdirectories */
				if(!clr_dir($dir.'/'.$readdir)) {
					return false;
				}
			}
		}
	} /* end while */

	closedir($opendir);
	
	if(!@rmdir($dir)) {
		return false;
	}
	return true;
}

function dirsize($dir) {
	$dh = @opendir($dir);
	if (!$dh) {
		return -1;
	}
	$size = 0;
	while (($file = readdir($dh)) !== false) {

		if ($file != '.' && $file != '..') {
			$path = $dir.$file;
			if (is_dir($path)) {
				$size += dirsize($path.'/');
			} elseif (is_file($path)) {
				$size += filesize($path);
			}
		}
		
	}
	closedir($dh);
	return $size;
}


	function preExtractCallBack($p_event, &$p_header) {
		global $translated_file_names;

		if ($p_header['folder'] == 1) {
			return 1;
		}

		if ($translated_file_names[$p_header['index']] == '') {
			return 0;
		}

		if ($translated_file_names[$p_header['index']]) {
			$p_header['filename'] = substr($p_header['filename'], 0, -strlen($p_header['stored_filename']));
			$p_header['filename'] .= $translated_file_names[$p_header['index']];
		}
		return 1;
	}

	function preImportCallBack($p_event, &$p_header) {
		global $IllegalExtentions;

		if ($p_header['folder'] == 1) {
			return 1;
		}


		$path_parts = pathinfo($p_header['filename']);
		$ext = $path_parts['extension'];

		if (in_array($ext, $IllegalExtentions)) {
			return 0;
		}

		return 1;
	}
?>