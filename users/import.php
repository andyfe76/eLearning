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

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'classes/pclzip.lib.php');
require($_include_path.'lib/filemanager.inc.php');

if ($_POST['cancel']) {
	$_SESSION['done'] = 1;
	Header('Location: index.php?f='.AT_FEEDBACK_IMPORT_CANCELLED);
	exit;
}

$course = intval($_REQUEST['course']);

if ($course == 0) {
	exit;
}

function translate_whitespace($input) {
	$input = str_replace('\n', "\n", $input);
	$input = str_replace('\r', "\r", $input);
	$input = str_replace('\x00', "\0", $input);

	return $input;
}

/* to avoid timing out on large files */
set_time_limit(0);

$_SESSION['done'] = 1;

/* make sure we own this course that we're exporting */
$sql	= "SELECT * FROM courses WHERE course_id=$course AND member_id=$_SESSION[member_id]";
$result	= mysql_query($sql, $db);
if (!$row2 = mysql_fetch_array($result)) {
	require($_include_path.'cc_html/header.inc.php');
	$errors[]=AT_ERROR_NOT_OWNER;
	print_errors($errors);
	require ($_include_path.'cc_html/footer.inc.php');
	exit;
}

if ($_POST['submit']) {

	if (	$_FILES['file']['name'] 
		&&	is_uploaded_file($_FILES['file']['tmp_name']) 
		&& (
			(	$_FILES['file']['type'] == 'application/x-zip-compressed')
			|| ($_FILES['file']['type'] == 'application/zip')
			|| ($_FILES['file']['type'] == 'application/x-gzip-compressed')
			)
		)
		{
		if ($_FILES['file']['size'] > 0) {
			/* check if ../content/import/ exists */
			$import_path = '../content/import/';
			$content_path = '../content/';

			if (!is_dir($import_path)) {
				if (!@mkdir($import_path, 0700)) {
					$errors[] = AT_ERROR_IMPORTDIR_FAILED;
					print_errors($errors);
					exit;
				}
			}

			$import_path = '../content/import/'.$course.'/';

			if (!is_dir($import_path)) {
				if (!@mkdir($import_path, 0700)) {
					$errors[] = AT_ERROR_IMPORTDIR_FAILED;
					print_errors($errors);
					exit;
				}
			}

			if ($_FILES['file']['type'] == 'application/x-gzip-compressed') {
				/* for versions < 1.1				*/
				/* copy the file in the directory	*/
				move_uploaded_file($_FILES['file']['tmp_name'], $import_path . $_FILES['file']['name']);

				/* unzip and untar the archive */
				$exec	= 'cd '.$import_path.'; gunzip -dc '.escapeshellcmd($_FILES['file']['name']).' | tar -xf -';
				$result = system ( $exec );
			} else {
				/* for versions >= 1.1				*/
				$archive = new PclZip($_FILES['file']['tmp_name']);
				if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path,
										PCLZIP_CB_PRE_EXTRACT,	'preImportCallBack') == 0) {
					dir ("Error : ".$archive->errorInfo(true));
				}
			}


			if (ALLOW_IMPORT_CONTENT) {
				$totalBytes = dirsize($import_path.'content/');
				$course_total = dirsize($content_path.$course.'/');
				$total_after = $MaxCourseSize-$course_total-$totalBytes;
				if ($total_after < 0) {
					/* remove the content dir, since there's no space for it */
					$errors[] = AT_ERROR_NO_CONTENT_SPACE;
					clr_dir($content_path.$course.'/');
					/*
					$exec	= 'cd '.$import_path.'; rm -r content/';
					$result = system ( $exec );
					*/
				} else {
					/* move the content to the correct course content directory */
					$exec	= 'cd '.$import_path.'; mv content/* ../../'.$course.'/';
					$result = system ( $exec );
				}
			}


			$fp = fopen($import_path.'content.csv','r');

			$lock_sql = 'LOCK TABLES content WRITE';
			$result   = mysql_query($lock_sql, $db);

			$sql	  = 'SELECT MAX(content_id) FROM content';
			$result   = mysql_query($sql, $db);
			$next_index = mysql_fetch_row($result);
			$next_index = $next_index[0] + 1;

			$sql	  = 'SELECT MAX(ordering) FROM content WHERE content_parent_id=0 AND course_id='.$course;
			$result   = mysql_query($sql, $db);
			$next_order = mysql_fetch_row($result);
			$order_offset = $next_order[0];

			$sql = '';
			$index_offset = '';
			$translated_content_ids = array();
			$content_pages = array();
			while ($data = fgetcsv($fp, 10000000, ',')) {
				$content_pages[$data[0]] = $data;
			}

			define('CPID', 1);

			function insert_content($content_id, &$content_pages, &$translated_content_ids) {
				global $db, $course;
				global $order_offset;

				if ($content_pages[$content_id] == '') {
					/* should never reach here. */
					debug('CONTENT NOT FOUND! ' . $content_id);
					exit;
				}

				if ($content_pages[$content_id][CPID] > 0) {
					if ($translated_content_ids[$content_pages[$content_id][CPID]] == '') {
						$last_id = insert_content(	$content_pages[$content_id][CPID],
													$content_pages,
													$translated_content_ids);
						$translated_content_ids[$content_pages[$content_id][CPID]] = $last_id;
					}
				}

				$sql = 'INSERT INTO content VALUES ';
				$sql .= '(0, ';
				$sql .= $course .',';
				if ($content_pages[$content_id][CPID] == 0) {
					$sql .= 0;
				} else {
					$sql .= $translated_content_ids[$content_pages[$content_id][CPID]];
				}
				$sql .= ',';
				if ($content_pages[$content_id][CPID] == 0) {
					$sql .= $content_pages[$content_id][2] + $order_offset;
				} else {
					$sql .= $content_pages[$content_id][2];
				}
				$sql .= ',';

				$sql .= "'".addslashes($content_pages[$content_id][3])."',";
				$sql .= $content_pages[$content_id][4] . ',';
				$sql .= $content_pages[$content_id][5] . ',';
				$sql .= "'".addslashes($content_pages[$content_id][6])."',";
				$sql .= "'".addslashes($content_pages[$content_id][7])."',";

				$content_pages[$content_id][8] = translate_whitespace($content_pages[$content_id][8]);

				$sql .= "'".addslashes($content_pages[$content_id][8])."')";
				$result = mysql_query($sql, $db);
				if (!$result) {
					debug(mysql_error());
					debug($sql);
					exit;
				}
				$last_id = mysql_insert_id( );
				return $last_id;
			}

			$keys = array_keys($content_pages);
			reset($content_pages);
			$num_keys = count($keys);
			for($i=0; $i<$num_keys; $i++) {
				if ($translated_content_ids[$keys[$i]] == '') {
					$last_id = insert_content($keys[$i], $content_pages, $translated_content_ids);
					$translated_content_ids[$keys[$i]] = $last_id;
				}
			}
			fclose($fp);

			$lock_sql = 'UNLOCK TABLES';
			$result   = mysql_query($lock_sql, $db);
			/****************************************************/

			/* related_content.csv */
			$sql = '';
			$fp = fopen($import_path.'related_content.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$sql = 'INSERT INTO related_content VALUES ';
				}
				$sql .= '(';
				$sql .= ($translated_content_ids[$data[0]]) . ',';
				$sql .= ($translated_content_ids[$data[1]]) . '),';
			}
			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);
			unset($translated_content_ids);
			/****************************************************/

			/* forums.csv */
			$sql = '';
			$fp  = fopen($import_path.'forums.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$sql = 'INSERT INTO forums VALUES ';
				}
				$sql .= '(0,'.$course.',';

				$data[0] = translate_whitespace($data[0]);
				$data[1] = translate_whitespace($data[1]);

				$sql .= "'".addslashes($data[0])."',";
				$sql .= "'".addslashes($data[1])."'),";
			}
			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);
			/****************************************************/

			/* glossary.csv */
			/* get the word id offset: */
			$lock_sql = 'LOCK TABLES glossary WRITE';
			$result   = mysql_query($lock_sql, $db);

			$sql	  = 'SELECT MAX(word_id) FROM glossary';
			$result   = mysql_query($sql, $db);
			$next_index = mysql_fetch_row($result);
			$next_index = $next_index[0] + 1;


			$sql = '';
			$index_offset = '';
			$fp  = fopen($import_path.'glossary.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$index_offset = $next_index - $data[0];
					$sql = 'INSERT INTO glossary VALUES ';
				}
				$sql .= '(';
				$sql .= ($data[0] + $index_offset) . ',';
				$sql .= $course .',';

				/* title */
				$data[1] = translate_whitespace($data[1]);
				$sql .= "'".addslashes($data[1])."',";

				/* definition */
				$data[2] = translate_whitespace($data[2]);
				$sql .= "'".addslashes($data[2])."',";

				/* related_word_id */
				$sql .= ($data[3] + $index_offset);
				$sql .= '),';
			}

			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);

			$lock_sql = 'UNLOCK TABLES';
			$result   = mysql_query($lock_sql, $db);
			/****************************************************/

			/* resource_categories.csv */
			/* get the CatID offset:   */
			$lock_sql = 'LOCK TABLES resource_categories WRITE';
			$result   = mysql_query($lock_sql, $db);

			$sql	  = 'SELECT MAX(CatID) FROM resource_categories';
			$result   = mysql_query($sql, $db);
			$next_index = mysql_fetch_row($result);
			$next_index = $next_index[0] + 1;

			$sql = '';
			$index_offset = '';
			$fp  = fopen($import_path.'resource_categories.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$index_offset = $next_index - $data[0];
					$sql = 'INSERT INTO resource_categories VALUES ';
				}
				$sql .= '(';
				$sql .= ($data[0] + $index_offset) . ',';
				$sql .= $course .',';

				/* CatName */
				$data[1] = translate_whitespace($data[1]);
				$sql .= "'".addslashes($data[1])."',";

				/* CatParent */
				if ($data[2] == 0) {
					$sql .= 'NULL';
				} else {
					$sql .= $data[2] + $index_offset;
				}
				$sql .= '),';
			}
			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);

			$lock_sql = 'UNLOCK TABLES';
			$result   = mysql_query($lock_sql, $db);
			/****************************************************/

			/* resource_links.csv */
			$sql = '';
			$fp  = fopen($import_path.'resource_links.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$sql = 'INSERT INTO resource_links VALUES ';
				}
				$sql .= '(0, ';
				$sql .= ($data[0] + $index_offset) . ',';

				/* URL */
				$data[1] = translate_whitespace($data[1]);
				$sql .= "'".addslashes($data[1])."',";

				/* LinkName */
				$data[2] = translate_whitespace($data[2]);
				$sql .= "'".addslashes($data[2])."',";

				/* Description */
				$data[3] = translate_whitespace($data[3]);
				$sql .= "'".addslashes($data[3])."',";

				/* Approved */
				$sql .= $data[4].',';

				/* SubmitName */
				$data[5] = translate_whitespace($data[5]);
				$sql .= "'".addslashes($data[5])."',";

				/* SubmitEmail */
				$data[6] = translate_whitespace($data[6]);
				$sql .= "'".addslashes($data[6])."',";

				/* SubmitDate */
				$data[7] = translate_whitespace($data[7]);
				$sql .= "'".addslashes($data[7])."',";

				$sql .= $data[8]. '),';
			}

			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);
			/****************************************************/

			/* news.csv */
			$sql = '';
			$fp  = fopen($import_path.'news.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$sql = 'INSERT INTO news VALUES ';
				}
				$sql .= '(0,'.$course.', '. $_SESSION['member_id'].', ';

				/* date */
				$data[0] = translate_whitespace($data[0]);
				$sql .= "'".addslashes($data[0])."',";

				$i=1;
				if ($_FILES['file']['type'] != 'application/x-gzip-compressed') {
					/* for versions 1.1+	*/
					/* formatting			*/
					$data[$i] = translate_whitespace($data[$i]);
					$sql .= $data[$i].',';
					$i++;
				} else {
					$sql .= '0,';
				}

				/* title */
				$data[$i] = translate_whitespace($data[$i]);
				$sql .= "'".addslashes($data[$i])."',";
				$i++;

				/* body */
				$data[$i] = translate_whitespace($data[$i]);
				$sql .= "'".addslashes($data[$i])."'";

				$sql .= '),';
			}

			if ($sql != '') {
				$sql = substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);
			/****************************************************/

			/* tests.csv */
			/* get the test_id offset:   */
			$lock_sql = 'LOCK TABLES tests WRITE';
			$result   = mysql_query($lock_sql, $db);

			$sql		= 'SELECT MAX(test_id) FROM tests';
			$result		= mysql_query($sql, $db);
			$next_index = mysql_fetch_row($result);
			$next_index = $next_index[0] + 1;

			$sql = '';
			$index_offset = '';
			$fp  = fopen($import_path.'tests.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$index_offset = $next_index - $data[0];
					$sql = 'INSERT INTO tests VALUES ';
				}
				$sql .= '(';
				$sql .= ($data[0] + $index_offset) . ',';
				$sql .= $course .',';

				/* title */
				$data[1] = translate_whitespace($data[1]);
				$sql .= "'".addslashes($data[1])."',";

				/* format */
				$sql .= $data[2].',';

				/* start date */
				$data[3] = translate_whitespace($data[3]);
				$sql .= "'".addslashes($data[3])."',";
				
				/* end date */
				$data[4] = translate_whitespace($data[4]);
				$sql .= "'".addslashes($data[4])."',";

				/* randomize order */
				$sql .= $data[5].',';

				/* num_questions */
				$sql .= $data[6].',';

				/* instructions */
				$data[7] = translate_whitespace($data[7]);
				$sql .= "'".addslashes($data[7])."'";

				$sql .= '),';
			}
			if ($sql != '') {
				$sql	= substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);


			$lock_sql = 'UNLOCK TABLES';
			$result   = mysql_query($lock_sql, $db);
			/****************************************************/

			/* tests_questions.csv */

			$sql = '';
			$fp  = fopen($import_path.'tests_questions.csv','r');
			while ($data = fgetcsv($fp, 10000000, ',')) {
				if ($sql == '') {
					/* first row stuff */
					$sql = 'INSERT INTO tests_questions VALUES ';
				}
				$sql .= '(0, ';
				$sql .= ($data[0] + $index_offset) . ','; // test_id
				$sql .= $course .',';

				/* ordering */
				$sql .= $data[1].',';

				/* type */
				$sql .= $data[2].',';

				/* weight */
				$sql .= $data[3].',';

				/* required */
				$sql .= $data[4].',';

				/* feedback */
				$data[5] = translate_whitespace($data[5]);
				$sql .= "'".addslashes($data[5])."',";

				/* question */
				$data[6] = translate_whitespace($data[6]);
				$sql .= "'".addslashes($data[6])."',";

				/* choice_0 */
				$data[7] = translate_whitespace($data[7]);
				$sql .= "'".addslashes($data[7])."',";

				/* choice_1 */
				$data[8] = translate_whitespace($data[8]);
				$sql .= "'".addslashes($data[8])."',";

				/* choice_2 */
				$data[9] = translate_whitespace($data[9]);
				$sql .= "'".addslashes($data[9])."',";

				/* choice_3 */
				$data[10] = translate_whitespace($data[10]);
				$sql .= "'".addslashes($data[10])."',";

				/* choice_4 */
				$data[11] = translate_whitespace($data[11]);
				$sql .= "'".addslashes($data[11])."',";

				/* choice_5 */
				$data[12] = translate_whitespace($data[12]);
				$sql .= "'".addslashes($data[12])."',";

				/* choice_6 */
				$data[13] = translate_whitespace($data[13]);
				$sql .= "'".addslashes($data[13])."',";

				/* choice_7 */
				$data[14] = translate_whitespace($data[14]);
				$sql .= "'".addslashes($data[14])."',";

				/* choice_8 */
				$data[15] = translate_whitespace($data[15]);
				$sql .= "'".addslashes($data[15])."',";

				/* choice_9 */
				$data[16] = translate_whitespace($data[16]);
				$sql .= "'".addslashes($data[16])."',";

				/* answer_0 */
				$sql .= $data[17].',';

				/* answer_1 */
				$sql .= $data[18].',';

				/* answer_2 */
				$sql .= $data[19].',';

				/* answer_3 */
				$sql .= $data[20].',';

				/* answer_4 */
				$sql .= $data[21].',';

				/* answer_5 */
				$sql .= $data[22].',';

				/* answer_6 */
				$sql .= $data[23].',';

				/* answer_7 */
				$sql .= $data[24].',';

				/* answer_8 */
				$sql .= $data[25].',';

				/* answer_9 */
				$sql .= $data[26].',';

				/* answer_size */
				$sql .= $data[27];

				$sql .= '),';
			}
			if ($sql != '') {
				$sql	= substr($sql, 0, -1);
				$result = mysql_query($sql, $db);
			}
			fclose($fp);


			$lock_sql = 'UNLOCK TABLES';
			$result   = mysql_query($lock_sql, $db);
			/****************************************************/

			@unlink($import_path . escapeshellcmd($_FILES['file']['name']));
			@unlink($import_path . 'content.csv');
			@unlink($import_path . 'forums.csv');
			@unlink($import_path . 'related_content.csv');
			@unlink($import_path . 'glossary.csv');
			@unlink($import_path . 'resource_categories.csv');
			@unlink($import_path . 'resource_links.csv');
			@unlink($import_path . 'news.csv');
			@unlink($import_path . 'tests.csv');
			@unlink($import_path . 'tests_questions.csv');

			$exec = 'cd '.$import_path.'; cd ..; rm -r '.$course.'/';
			$result = system ( $exec );

			require ($_include_path.'cc_html/header.inc.php'); 

			//print_errors($errors);

			$feedback[] = AT_FEEDBACK_IMPORT_SUCCESS;
			print_feedback($feedback);
			
		} else {
			require($_include_path.'cc_html/header.inc.php');
			$errors[] = AT_ERROR_IMPORTFILE_EMPTY;
			print_errors($errors);
			require($_include_path.'cc_html/footer.inc.php');
			exit;
		}
	} else {
		require($_include_path.'cc_html/header.inc.php');
		$errors[] = AT_ERROR_FILE_NOT_SELECTED;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
}

require ($_include_path.'cc_html/footer.inc.php'); 

?>